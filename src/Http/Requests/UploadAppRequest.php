<?php

namespace Herode\Amana\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadAppRequest extends FormRequest
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
            'app_file'    => 'required|extensions:ipa,apk',
            'env'         => 'required|in:dev,stg,prod',
            'device_type' => 'required|in:ios,android',
            'version'     => 'required',
            'build'       => 'required',
        ];
    }
}
