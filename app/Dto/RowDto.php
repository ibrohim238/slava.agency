<?php

namespace App\Dto;

use Carbon\Carbon;

final class RowDto
{
    public function __construct(
        public readonly string $name,
        public readonly Carbon $date,
    ) {
    }


    public static function fromArray(array $data): RowDto
    {
        return new self(
            name: $data['name'] ?? null,
            date: Carbon::make($data['date'] ?? null),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'date' => $this->date,
        ];
    }
}
