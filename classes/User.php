<?php
// L#10
class User 
{
    
private $db, $data /*stdClass Object*/, $userKey /*string*/, $hashKey /*string*/, $isLoggedIn /*bool*/;

public function __construct($user = null) 
{
    $this->db = Database::getInstance();

    // set `$userKey property` of the `User Object`
    $this->userKey = Config::get('session.userKey');

    // set `$hashKey property` of the `User Object`
    $this->hashKey = Config::get('cookie.hashKey');
    
    // check whether `$user parameter` is null (not provided)
    if(!$user) {    // = if(!isset($user)) { ...
        
        // IF `$user parameter` IS NULL then:
        // check whether element with provided KEY exists in the $_SESSION[] array
        if(Session::exists($this->userKey)) {    // returns boolean
            
            // set `$userId variable` by assigning `userId VALUE` from $_SEESION - returns string 
            $userId = Session::get($this->userKey); 
            
            // checks whether `find method` on `User object`
            if($this->find($userId)) {
            // set `$data property` of the `User Object` as stdClass Object and returns BOOLEAN
            
                $this->isLoggedIn = true;  // set `$isLoggedIn property` of the `User Object`
            }
        }
    } else {
        // IF `$user parameter` IS NOT NULL then:
        $this->find($user); // where do we need it till L#15? L#17
        // set `$data property` of the `User Object` as stdClass Object and returns BOOLEAN
    }

}

// add new user to db
// Parameters: array    Required. Array of table's fields
public function create($fields = []) 
{
    $this->db->insert('users', $fields);
}


/**
 * L#14 - verifies provided values of form's fields and add new user element in the $_SEESION[] array
 * @param string|null $email
 * @param string|null $password
 * @param bool $remember
 * @return bool
 */
public function login($email = null, string $password = null, bool $remember = false)
{
    // L#17.2 - check whether method's parameters `$email` and `$password` + `$data property` NOT EMPTY
    // L#17.3 0:40
    if(!$email && !$password && $this->exists()) {
    // if(!$email) - It's the same as: if((bool)$something != true)
    // if all 3 conditions are met - add new element in $_SEESION[] as userId WITHOUT email & password check
        Session::put($this->userKey, $this->data()->id);
    } else {
    
        // find the record by email in db and set `$data property` of the `User Object` as stdClass Object
        $user = $this->find($email);
        // Retrns TRUE or FALSE
        
        // checks whether provided email exists in db's table
        if($user) { // if($user == TRUE)
            
            // if $user == TRUE then:
            // set `$user_hash variable` assigning the user's password value from table `users` 
            $user_hash = $this->data()->password;    // returns hash string
            
            // $password - 1-st parameter - form's field `password` value
            if(password_verify($password, $user_hash)) {
            // Returns TRUE if the password and hash match, or FALSE otherwise
            
                // add new element in $_SEESION[] as userId
                Session::put($this->userKey, $this->data()->id);

                // L#17 - check whether form's checkbox is on
                if($remember) {
                // if it is generate Cookie, add this Cookie to db's table and set it in user's browser 
                    
                    /* hash() Function - Returns the hashed string 
                    (either in lowercase hex character sequence or raw binary form)
                    Parameters:
                    $algo   Required. This parameter expects a string defining the hashing algorithm 
                            to be used. PHP has a total of 46 registered hashing algorithms among which 
                            “sha1”, “sha256”, “md5”, “haval160, 4” are the most popular ones.
                    $string Required. This parameter expects the string to be hashed.
                    $getRawOutput   Optional. This optional parameter expects a boolean value, on TRUE the function returns the hash in a raw binary format.
                    */
                    $hashVal = hash('sha256', uniqid());

                    // find `user's hash` in the 'user_sessions' table by user id
                    $db_cookie = $this->db->findByCriteria('user_sessions', ['user_id', '=', $this->data()->id]);
                    //  Returns Database Object - record from the 'user_sessions' table

                    // checks whether user has records in the 'user_sessions' table (count > 0)
                    if(!$db_cookie->count()) {
                    // if user does NOT have cookie in db's table, then insert cookie
                        $this->db->insert('user_sessions', [
                        'user_id'   =>  $this->data()->id,
                        'hash'  =>  $hashVal
                    ]);
                    } else {
                    // if user HAS cookie in db's table, then rewrite $hashVal with hash value from db
                        $hashVal = $db_cookie->first()->hash;
                    }
                    // ADD new element in the $_COOKIE[] global array
                    Cookie::put($this->hashKey, $hashVal, Config::get('cookie.expiry'));

                }
                return true;
            }
        }
    }
    return false;
}


// L#14 - set `$data property` of the `User Object` as stdClass Object
// and
// Retrns TRUE or FALSE
public function find($value = null)
{
    if(is_numeric($value)) {
        // find user by id
        $this->data = $this->db->findByCriteria('users', ['id', '=', $value])->first();
        // Returns stdClass Object
    } else {
        // find user by email
        $this->data = $this->db->findByCriteria('users', ['email', '=', $value])->first();
        // Returns stdClass Object
    }

    if($this->data) {   // if (isset($data))
        return true;
    }
    return false;
}


// L#14 - Returns the `$data property` of `User object` as stdClass Object
public function data()
{
    return $this->data;
}


// L#15 - Returns the `$isLoggedIn property` of `User object` as Boolean
public function isLoggedIn() {
    return $this->isLoggedIn;
}


/* L#16 - REMOVES user's cookie from db's 'user_sessions' table
REMOVES elements from the $_SESION[] and $_COOKIE[] global arrays
Returns nothing */
public function logout() {
    // L#17.3 - delete cookie string from db's 'user_sessions' table
    $this->db->delete('user_sessions', ['user_id', '=', $this->data()->id]);
    
    // L#16 - `login method` ADDS element in the $_SESION array
    // `logout method` REMOVES element from the $_SESION array
    Session::delete($this->userKey);
    
    // L#17.3 - REMOVE element from the $_COOKIE[] global array
    Cookie::delete($this->hashKey);
}


// L#17.2 - checks whether `$data property` not empty (whether `User object` is created)
// returns boolean
public function exists() {
    return (!empty($this->data())) ? true : false;
}


// L#18 - 4:00
public function update($fields = [], $id = null) {
    
    if(!$id && $this->isLoggedIn()) {
    // if $id is null it means that update is done by logged in user, so
        // set $id variable
        $id = $this->data()->id;
    
    // if $id is NOT null it means that update is done by Admin who is able to provide his id,
    // so there NO necessity to do above-mentioned check and id assining
    }
    $this->db->update('users', $id, $fields);
}


// L#20 - Parameters: $key Required - string - the key of element in an assotiative array
// Returns BOOLEAN
public function hasPermissions($key = null) {

    if($key) {  // if(isset($key))
        $group = $this->db->findByCriteria('groups', ['id', '=', $this->data()->groupid]);
        // Returns Database Object

        if($group->count()) {   // $group->count() >0
            // set `$permissions variable` assigning the value from `permissions field` of related record (`groups` table)
            $permissions = $group->first()->permissions;    // returns string
            
            /* JSON Objects - https://www.w3schools.com/js/js_json_objects.asp
            json_decode() function is used to decode or convert a JSON object to a PHP object
            Parameters:
            string	Required. Specifies the value to be encoded
            assoc	Optional. Specifies a Boolean value. When set to true, the returned object will be converted 
                    into an associative array. When set to false, it returns an object. False is default
            depth	Optional. Specifies the recursion depth. Default recursion depth is 512
            options	Optional. Specifies a bitmask (JSON_BIGINT_AS_STRING, JSON_INVALID_UTF8_IGNORE, 
                    JSON_INVALID_UTF8_SUBSTITUTE, JSON_OBJECT_AS_ARRAY, JSON_THROW_ON_ERROR)
            Returns:
            The value encoded in JSON in appropriate PHP type. If the JSON object cannot be decoded it returns NULL
            */
            $permissions = json_decode($permissions, true); // if 2-nd parameter is true -> returns array

            if($permissions[$key]) {
                return true;
            }
        }
    }

    return false;
}

}