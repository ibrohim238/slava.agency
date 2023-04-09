<?php

namespace App\Http\Controllers;

use App\Http\Requests\RowRequest;
use App\Services\RowImportService;
use Illuminate\Support\Facades\Redis;

class ImportRowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth.basic']);
    }

    public function import(RowRequest $request)
    {
        $uuid = (new RowImportService())
            ->import(
                file: $request->excel
            );

        return response()
            ->json([
                'message' => 'File uploaded and processing started',
                'importId' => $uuid
            ]);
    }

    public function progress(string $importId)
    {
        $cacheKey = sprintf('import.excel:%s', $importId);

        $progress = Redis::get($cacheKey);

        return response()->json([
            'importId' => $importId,
            'progress' => $progress ? intval($progress) : 0,
        ]);
    }
}
