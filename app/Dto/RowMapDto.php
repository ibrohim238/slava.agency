<?php

namespace App\Dto;

final class RowMapDto
{

    public function __construct(
        public readonly AttributeImportMapDto $attributes,
        public readonly RowDto            $values,
    ){
    }

    public static function fromArray(array $data): RowMapDto
    {
        return new self(
            attributes: new AttributeImportMapDto(
                id: $data['id'] ?? null
            ),
            values: RowDto::fromArray([
                'name' => $data['name'] ?? null,
                'date' => $data['date'] ?? null
            ])
        );
    }

    public function toArray(): array
    {
        return [
            'attributes' => $this->attributes->toArray(),
            'values' => $this->values->toArray(),
        ];
    }
}
