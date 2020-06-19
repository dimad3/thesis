<?php

class Validate
{

private $passed = false, $errors = [], $db = null;

public function __construct() {
    // call `getInstance method` on `Database object`
    $this->db = Database::getInstance();
    // set `$db property` of `Validate object` as new instance of `Database object`
}


/* L#8 9:00
1) $source - array with elements from `$POST array`
2) $fields_to_check - multidimentional array with elements that represents form's fields' names 
(each field as array's element's KEY) to be checked and rules (as array of VALUES) for each form's field.
`$fields_to_check array` is MANNUALLY set as 2nd parameter when `check method` is called
Returns `Validate object`
*/
public function check($source, $fields_to_check = [])
{
    //  $field_name (new variable) - field's name (as key)
    //  $field_rules (new variable) - array of rules (as value)
    foreach($fields_to_check as $field_name => $field_rules) {
        
        //  $rule (new variable) - rule's name (as key)
        //  $rule_value (new variable) - rule's value
        foreach($field_rules as $rule => $rule_value) {

            // set the value of the current field to the `$field_value variable`
            $field_value = $source[$field_name];

            // check the rules of current field
            if($rule == 'required' && empty($field_value)) {
                // if the field is 'required' and is EMPTY -> add this error description
                $this->addError("{$field_name} is required");
            
            } else if(!empty($field_value)) {
                // if the field is NOT empty run these checks
                switch ($rule) {
                    /*
                    The value of the `$rule variable` is compared with the values for each `case` 
                    in the structure. If there is a match, the block of code associated with  
                    that `case` is executed. */
                    case 'min':
                        // check whether field's length is less then `$rule_value`
                        if(strlen($field_value) < $rule_value) {
                            // if it is -> add this error description
                            $this->addError("{$field_name} must be a minimum of {$rule_value} characters.");
                        }
                    // Use break to prevent the code from running into the next case automatically
                    break;

                    case 'max':
                        if(strlen($field_value) > $rule_value) {
                            $this->addError("{$field_name} must be a maximum of {$rule_value} characters.");
                        }
                    break;

                    case 'matches':
                        if($field_value != $source[$rule_value]) {
                            $this->addError("{$rule_value} must match {$field_name}");
                        }
                    break;

                    case 'unique':
                        // set `$check variable` by calling `get method` on `Datbase object`
                        $recordset = $this->db->get($rule_value, [$field_name, '=', $field_value]);
                        // $check = `Database object` which represents the recordset returned by `get method`
                        
                        // check whether the `$count property` of `Database object` is grater then 0
                        if($recordset->count()) {   // the same as $recordset->count()>0 (see forum)
                            // if it is -> add this error description
                            $this->addError("{$field_name} already exists.");
                        }
                    break;

                    case 'email':
                        // filter_var - Check if $email is a valid email address
                        // Returns the filtered data on success, FALSE on failure
                        if(!filter_var($field_value, FILTER_VALIDATE_EMAIL)) {
                            $this->addError("{$field_name} is not an email");
                        }
                    break;
                }
            }
        }
    }

    // check whether $errors array is still empty after all checks were implemented
    if(empty($this->errors)) {
        // if it is empty - set `Validate` object's `$passed property` to TRUE
        $this->passed = true;
    }
    
    return $this;
}

/*
Add an error description to the `$errors array`, where `$errors array` is `Validate` object's property
`$error` (string) - error description */
public function addError($error) 
{
    $this->errors[] = $error;
}


// Returns the `$error property` of `Validate object`
// we can't access PRIVATE property `$error` from external page to access it use PUBLIC `error method`
public function errors() 
{
    return $this->errors;
}


// Returns the `$passed property` of `Validate object`
// we can't access PRIVATE property `$passed` from external page to access it use PUBLIC `error method`
public function passed() 
{
    return $this->passed;
}

}
