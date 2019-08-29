<?php

namespace Whitwhoa\LaravelSubAuth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Whitwhoa\LaravelSubAuth\SubAuth;


class LoginRequest extends FormRequest
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

                // Verify that an 'id' is given in the request
                if(!isset($this->id)){
                    return $fail('Auth id must be provided');
                }

                // Verify that an 'id' is given in the request
                if(!isset($this->pass)){
                    return $fail('Auth pass must be provided');
                }

                // Verify that a record exists within the table defined within the config file for the given
                // type key that matches the id and pass provided, if not return validation message
                $qr = SubAuth::read_GetUserAccount($value, $this->id);

                if(count($qr) > 1){
                    throw new \Exception("More than one account with same username not allowed");
                }

                if(count($qr) === 0){
                    return $fail('Incorrect username / password');
                }

                // There must be a single result in $account, so verify it's password
                $assocAccount = (array)$qr[0];

                if(!Hash::check($this->pass, $assocAccount[config('laravelsubauth')[$value]['pass']])){
                    return $fail('Incorrect username / password');
                }

            }]
        ];
    }
}