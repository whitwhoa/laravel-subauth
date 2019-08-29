<?php

namespace Whitwhoa\LaravelSubAuth\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Whitwhoa\LaravelSubAuth\Requests\LoginRequest;
use Whitwhoa\LaravelSubAuth\Requests\LogoutRequest;
use Whitwhoa\LaravelSubAuth\SubAuth;


class SubAuthController extends Controller{

    /**
     * If LoginRequest successful, then we know that the provided
     * credentials are valid
     *
     * Create a session for this account type
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request){
        \Session()->put($request->type, json_encode(SubAuth::read_GetUserAccount($request->type, $request->id)[0]));
        return redirect($request->redirect);
    }

    /**
     * If LogoutRequest successful, then we know that the provided
     * values are valid and we can proceed
     *
     * @param LogoutRequest $request
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(LogoutRequest $request){
        \Session()->forget($request->type);
        return redirect($request->redirect);
    }

}