<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRiderRequest extends FormRequest
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
            'rider_id' => 'required|exists:riders,id',
            'status' => 'required|in:accepted,declined',
            'bus_id.*' => 'required|exists:buses,id',
        ];
    }
}
