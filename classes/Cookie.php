<?php
// L#17.2 - 6:00
/* A cookie is often used to identify a user.
A cookie is a small file that the server embeds on the user's computer.
Each time the same computer requests a page with a browser, it will send the cookie too.
*/
class Cookie 
{

/* L#17 - checks whether element exists in the $_COOKIE[] global array
Parametrs: string Required - key name to be checked in the $_SESSION[] array
Returns TRUE or FALSE */
public static function exists($keyName) {
    return (isset($_COOKIE[$keyName])) ? true : false;
}


/* L#17 - find element in the $_COOKIE[] global array
Parametrs: string Required - key name to be found in the $_COOKIE[] global array
Returns elements VALUE */
public static function get($keyName) {
    return $_COOKIE[$keyName];
}


/* L#17 - ADD new element in the $_COOKIE[] global array
$_COOKIE[] - an associative array of variables passed to the current script via HTTP Cookies
Note:
This is a 'superglobal', or automatic global, variable. This simply means that it is available 
in all scopes throughout a script.
Parametrs:
1) $keyName string - new element's KEY name
2) $value - new element's VALUE for corresponding new key
3) $expiry - Specifies when the cookie expires
Returns BOOLEAN
*/
public static function put($keyName, $value, $expiry) {
    
    /* `setcookie() function` - defines a cookie to be sent along with the rest of the HTTP headers
    Note:
    1) The setcookie() function must appear BEFORE the <html> tag.
    2) The value of the cookie is automatically URLencoded when sending the cookie, and
    automatically decoded when received (to prevent URLencoding, use setrawcookie() instead).
    Parametrs:
    name    Required. Specifies the name of the cookie
    value	Optional. Specifies the value of the cookie
    expire	Optional. Specifies when the cookie expires. The value: time()+86400*30, 
            will set the cookie to expire in 30 days. If this parameter is omitted or set to 0, 
            the cookie will expire at the end of the session (when the browser closes). Default is 0
    path	Optional. Specifies the server path of the cookie. If set to "/", the cookie 
            will be available within the entire domain. If set to "/php/", the cookie 
            will only be available within the php directory and all sub-directories of php. 
            The default value is the current directory that the cookie is being set in
    domain, sequre, httponly - Optional
    Return Value:	TRUE on success. FALSE on failure
    */
    if(setcookie($keyName, $value, time() + $expiry, '/')) {
        // if cookie is set
        return true;
    }
    // if cookie is NOT set
    return false;
}


/* L#17 - REMOVE cookie file from user's browser + REMOVE element from the $_COOKIE[] global array
Parametrs: string Required - key name to be deleted from the $_COOKIE[] global array 
Returns nothing */
public static function delete($keyName) {
    // it is not possible to delete file from user's browser, so we just put new cookie file wit expiry in the past
    self::put($keyName, '', time() - 1);
}

}
