<?php

namespace App\Imports;

use App\Dto\RowMapDto;
use App\Events\RowCreated;
use App\Models\Row;
use App\Utils\Helpers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;

class RowImport implements
    ToArray,
    ShouldQueue,
    WithChunkReading,
    WithBatchInserts,
    WithValidation,
    SkipsOnFailure,
    WithHeadingRow,
    WithMapping
{
    use Importable;
    use SkipsFailures;

    private readonly string $uuid;
    private readonly string $filePath;
    public function __construct(
        string $uuid,
        string $filePath,
    ) {
        $this->uuid = $uuid;
        $this->filePath = $filePath;
    }

    public function array(array $array)
    {
        foreach ($array as $row) {
            $dto = RowMapDto::fromArray($row);

            $model = Row::updateOrCreate(
                $dto->attributes->toArray(),
                $dto->values->toArray(),
            );

            Redis::incr($this->cacheKey());
            event(new RowCreated($model));
        }
    }

    public function rules(): array
    {
        return [
            'id' => ['nullable', 'int'],
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date']
        ];
    }

    public function map($row): array
    {
        return [
            'id' => $row['id'] ?? null,
            'name' => $row['name'] ?? null,
            'date' => Helpers::castDate($row['date'] ?? null),
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    private function cacheKey(): string
    {
        return sprintf('import.excel:%s', $this->uuid);
    }
}
