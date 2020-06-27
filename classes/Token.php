<?php

class Token
{

//L9 4:15 - create new token string and add it as new element in the $_SESSION[] array
public static function generate() 
{
    // set the `$tokenKey variable` by calling `get method` on `Config object`
    $tokenKey = Config::get('session.tokenKey');
    

    /* uniqid() - generates a unique ID based on the microtime (the current time in microseconds).
    Returns the unique identifier, as a string.
    Parametrs: 2 Optional parametrs.
    https://www.w3schools.com/php/func_misc_uniqid.asp */
    $random_string = uniqid();

    /* md5 — Calculate the md5 hash of a string
    Returns the calculated MD5 hash on success, or FALSE on failure
    Parametrs:
    1) string	Required. The string to be calculated
    2) raw	Optional.   Specifies hex or binary output format:
                        TRUE - Raw 16 character binary format
                        FALSE - Default. 32 character hex number
    https://www.w3schools.com/php/func_string_md5.asp */
    $token = md5($random_string);

    // add new element in the $_SESSION[] array
    return Session::put($tokenKey, $token);
}


/*L#9 4:30 - checks whether `form's token value` exists in the `$_SESSION[] array`
Parametrs: string Required - token value to be checked
Returns true or false */
public static function check($token) 
{
    // set the `$tokenKey variable` by calling `get method` on `Config object`
    $tokenKey = Config::get('session.tokenKey'); // returns string

    /* checks whether `token` KEY exists in the `$_SESSION[] array` AND
    `form's token value` is equal to `token VALUE` in the `$_SESSION[] array` */
    if(Session::exists($tokenKey) && $token == Session::get($tokenKey)) {
        Session::delete($tokenKey);
        return true;
    }

    return false;
}

}
