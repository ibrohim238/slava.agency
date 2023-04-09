<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

/**
 * @property-read UploadedFile $excel
*/
class RowRequest extends FormRequest
{
    /**
     * @return array<string,Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'excel' => ['required', 'file', 'mimes:xlsx,xls']
        ];
    }
}
