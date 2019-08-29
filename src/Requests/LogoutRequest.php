<?php

namespace Whitwhoa\LaravelSubAuth\Requests;

use Illuminate\Foundation\Http\FormRequest;


class LogoutRequest extends FormRequest
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
        // This is hacky, so pay attention
        return [
            'redirect'                      => 'required|url',
            'type'                          => ['required', function($attribute, $value, $fail){

                // Verify the type given is a key within the config array
                if(!array_key_exists($value, config('laravelsubauth'))){
                    return $fail('Given auth type is not configured');
                }

            }]
        ];
    }
}