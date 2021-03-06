<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Exceptions\ErrorCodes;
use App\Exceptions\NoticeException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

/**
 * Class FormRequest.
 */
abstract class FormRequest extends LaravelFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize(): bool;

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     * @throws NoticeException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = implode(', ', $validator->errors()->all());

        throw new NoticeException($errors, ErrorCodes::VALIDATION_ERROR);
    }
}
