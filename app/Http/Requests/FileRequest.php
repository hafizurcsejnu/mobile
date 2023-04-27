<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxFileSize;

class FileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "folderId" => "required|exists:folders,id",
            "file.*" => ['required','unique:files,name','mimes:jpg,jpeg,pdf,doc,docx', new MaxFileSize()],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file.*.mimes' => 'The file must be a file of type: jpg, pdf, doc.',
        ];
    }
}
