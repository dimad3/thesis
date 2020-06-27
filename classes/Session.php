<?php

class Session
{

/* L#9 4:00 - ADD new element in the $_SESSION[] array
Parametrs:
1) $keyName string - new element's KEY name
2) $value - new element's VALUE for corresponding new key
*/
public static function put($keyName, $value)
{
    return $_SESSION[$keyName] = $value;
}


/* L#9 4:00 - checks whether element exists in the $_SESSION[] array
Parametrs: string Required - key name to be checked in the $_SESSION[] array
Returns TRUE or FALSE */
public static function exists($keyName) {
    return (isset($_SESSION[$keyName])) ? true : false;
}


/* L#9 4:00 - REMOVE element from $_SESSION[] array
Parametrs: string Required - key name to be deleted from the $_SESSION[] array 
Returns: nothing */
public static function delete($keyName) 
{
    if(self::exists($keyName)) {
        unset($_SESSION[$keyName]);
    }
}


/* L#9 4:00 - find element in the $_SESSION[] global array
Parametrs: string Required - key name to be found in the $_SESSION[] array
Returns elements VALUE (as string) */
public static function get($keyName) 
{
    return $_SESSION[$keyName];
}


/* L#10 - returns flash message as string 
or set new element ('keyName' => 'flash message') in the $_SESSION[] array
Parameters:
1) $keyName string  Required. new element's KEY name
2) $value string    Optional. new element's VALUE (flash message)
*/
public static function flash($keyName, $value = '') 
{
    // get msg from the $_SESSION[] array
    // check whether element with provided `$keyName` exists in the $_SESSION[] array
    // AND whether this element's VALUE NOT equal to empty string
    if(self::exists($keyName) && self::get($keyName) !== '') {
        // assign flash message to `$flash variable`
        $flash = self::get($keyName);
        
        // delete flash element from the $_SESSION[] array
        self::delete($keyName);

        return $flash; // flash message as string
    
    // if element with provided `$keyName` does NOT exist in the $_SESSION[] array
    } else {
        // add new element in the $_SESSION[] array
        self::put($keyName, $value);
    }
}

}
