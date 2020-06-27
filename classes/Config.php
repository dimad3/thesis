<?php

class Config
{

// L#9 - Returns - last element's VALUE in a multidimential array
// Parametrs:
// string - full path for an element in an array where each next element is devided by '.'
public static function get($path = null) {
    // check whether $path is NUL, if it is NOT - run the code inside if statment
    if(isset($path)) {
        /* $GLOBALS is a PHP super global variable which is used to access global variables
        from anywhere in the PHP script (also from within functions or methods).
        PHP stores all global variables in an array called $GLOBALS[index].
        The index holds the name of the variable.
        
        It is possible to add our own elements in the `$GLOBALS array` */
        $config = $GLOBALS['config'];   // returns array

        /* The explode() in-build function breaks a string into an array.
        Note: The "separator" parameter cannot be an `EMPTY string`
        Parameter Values:
        1) separator    Required. Specifies where to break the string
        2) string	    Required. The string to split
        3) limit	    Optional. Specifies the number of array elements to return.
        Returns an indexed array of strings */
        $path = explode('.', $path); // returns array

        /* foreach (array_expression as $value)
        Loops over the array given by array_expression. On each iteration:
        1) the value of the current element is assigned to `$value variable`
        ($value - name of a NEW variable, that will be used to store the VALUE of each element of the array)
        and the internal array pointer is advanced by one (so on the next iteration, you'll be looking at the next element) */
        
        foreach($path as $key) {
            /*
            The isset() function is an inbuilt function in PHP which checks whether 
            a `variable` is set and is different than NULL
            or
            an array's index/key is set AND its VALUE is NOT NULL.
            Returns:
            1) TRUE if the `variable` exists and has any value other than NULL. FALSE otherwise.
            2) If you want to know whether a particular key is defined AND has any value other than NULL
            use isset($array[$key]). isset() returns TRUE if the element with provided key exists 
            in an array AND its VALUE is NOT NULL */
            $variable_exists = isset($config[$key]);
            
            if($variable_exists == true) {
                /* if the element with provided KEY exists 
                then assign the corresponding VALUE to the $config variable */
                $config = $config[$key];
            }
        }
        return $config;
    }

    return false;
}
}
