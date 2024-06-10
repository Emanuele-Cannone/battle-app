<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'name' => 'required|string',
            'location_name' => 'required|string',
            'location_street' => 'required|string',
            'location_city' => 'required|string',
            'location_zipcode' => 'required|string',
            'categories' => 'required|array',
        ];
    }
}
