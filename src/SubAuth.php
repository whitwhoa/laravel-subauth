<?php

namespace Whitwhoa\LaravelSubAuth;

use Illuminate\Support\Facades\DB;

class SubAuth
{
    /**
     * return object representing table row of account object of $type or false
     * if one does not exist
     *
     * @param string $type
     * @return null|object
     */
    public static function account(string $type) : ?object {
        if(!\Session()->exists($type)){
            return null;
        }
        return json_decode(\Session()->get($type));
    }

    /**
     * This might look scary at first, but there's no sql injection possible here. Look carefully.
     *
     * @param string $type
     * @param string $id
     * @return array
     */
    public static function read_GetUserAccount(string $type, string $id){
        return DB::select("SELECT * FROM " . config('laravelsubauth')[$type]['table'] . " WHERE " .
            config('laravelsubauth')[$type]['id'] . " = ?", [$id]);
    }

}