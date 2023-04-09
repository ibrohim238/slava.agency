<?php

namespace App\Http\Controllers;

use App\Models\Row;

class RowsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth.basic']);
    }

    public function index()
    {
        $rows = Row::orderBy('date')->get();

        $grouped_rows = $rows->groupBy('date');

        return response()->json([
            'data' => $grouped_rows
        ]);
    }
}
