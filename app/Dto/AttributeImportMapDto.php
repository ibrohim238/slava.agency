<?php

namespace App\Dto;

final class AttributeImportMapDto
{
    public function __construct(
        public readonly ?int $id = null
    ){
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id
        ];
    }
}
