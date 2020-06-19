<?php

class Input
{
    // L#8 04:00
    // checks whether the form was submited
    // Returns TRUE if it was and FALSE if it was NOT
    public static function isSubmited($type = 'post') 
    {
    /* L#8
    The switch-case statement differs from the if-elseif-else statement in one important way. 
    The switch statement executes line by line (i.e. statement by statement) and once PHP 
    finds a case statement that evaluates to TRUE, it's not only executes the code corresponding 
    to that case statement, but also executes all the subsequent case statements till the end 
    of the switch block automatically.

    To prevent this add a `BREAK` statement to the end of each case block.
    The 'BREAK' statement tells PHP to break out of the switch-case statement block 
    once it executes the code associated with the first true case.
    */
    switch ($type) {
        /*
        The value of the `$type variable` is compared with the values for each case in the structure.
        If there is a match, the block of code associated with that `case` is executed.
        */
        case 'post':
            return (!empty($_POST)) ? true : false; // !empty is better than isset() (see forum)
        case 'get':
            return (!empty($_GET)) ? true : false;
        
        // The default statement is used if no match is found
        default:
            return false;
        
        // Use break to prevent the code from running into the next case automatically
        break;  // (see forum)
    }
}


// L#8 04:40 - get a VALUE of a form's field after the form was submited
// Parameters:
// string   Required. the name of the form's field = the key of the one element in the $_POST or $_GET array
// Returns the VALUE of the provided field (as string)
public static function get($fieldName) // getFieldVal is better
{
    // check whether the form was submited using the `POST method`
    if(isset($_POST[$fieldName])) {
        /* if it was - returns the cooresponding value of `$fieldName key` 
        in the `$_POST array` (as string)
        */
        return $_POST[$fieldName];
    } else if(isset($_GET[$fieldName])) {
        return $_GET[$fieldName];
    }

    return '';
}

}
