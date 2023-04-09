<?php

namespace App\Services;

use App\Imports\RowImport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class RowImportService
{
    public function import(UploadedFile $file): string
    {
        $filePath = $file->store('import_excel');
        $uuid = Str::uuid();

        (new RowImport(
            uuid: $uuid,
            filePath: $filePath,
        ))
            ->queue();

        return $uuid;
    }
}
