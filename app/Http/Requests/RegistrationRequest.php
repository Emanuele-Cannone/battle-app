<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required_unless:member_file,null|sometimes|string|max:255',
            'surname' => 'required_unless:member_file,null|sometimes|string|max:255',
            'telephone' => 'required_unless:member_file,null|sometimes|string|max:255',
            'email' => 'required_unless:member_file,null|sometimes|email',
            'school' => 'required_unless:member_file,null|sometimes|string|max:255',
            'teacher' => 'required_unless:member_file,null|sometimes|string|max:255',
            'member_file' => ['required_unless:name,null', 'sometimes', File::types(['xlsx'])],
            'category_id' => 'required_unless:member_file,null|sometimes|exists:categories,id',
            'event_id' => 'required','exists:events,id',
        ];
    }
}
