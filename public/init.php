<?php
session_start(); // L#9 9:08 - creates a session or resumes the current one
// Create an associative array $_SESSION[] containing session variables available to the current script

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Config.php';
require_once __DIR__ . '/../classes/Input.php';
require_once __DIR__ . '/../classes/Validate.php';
require_once __DIR__ . '/../classes/Token.php';
require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Redirect.php';
require_once __DIR__ . '/../classes/Cookie.php';


// var_dump($GLOBALS); die;
// add our own element in the $GLOBALS array
$GLOBALS['config'] = [ // in init.php
    'mysql' => [
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => '',
        'database'  => 'thesis',
        'something' => [
            'no'    => [
                'foo'   => [
                    'bar'   => 'baz'
                ]
            ]
        ]
    ],

    'session' => [
        'tokenKey'  => 'token',  // L#9 - new element's KEY name in the $_SESSION[] array (forum)
        'userKey'   => 'userId'  // L#13 - new element's KEY name in the $_SESSION[] array
    ],

    'cookie'    =>  [
        'hashKey'   =>  'hash', // specifies the name of the cookie
        'expiry'    =>  604800  // = 1 week
    ]
];


// L#17.1 - thise code will be caled on any page where init.php is included
// find `hashKey name` in the `cookie setiings`
$hashKey = Config::get('cookie.hashKey');

// find `userKey name` in the `session setiings`
$userKey = Config::get('session.userKey');

/* checks:
1) whether element with `hash` KEY exists in the $_COOKIE[] global array
2) whether element with `userId` KEY DOES NOT exist in the $_SESSION[] global array
if `hash` KEY exists in the $_COOKIE[] global array (in the user's browser) and
`userId` KEY DOES NOT exist in the $_SESSION[] global array (user is NOT logged in) 
then run this code: */
if(Cookie::exists($hashKey) && !Session::exists($userKey)) {
    
    // set `$browser_hash variable` by assigning `hash value` from the $_COOKIE[] global array
    $browser_cookie = Cookie::get($hashKey); // returns string
    
    // find `user's hash` in the 'user_sessions' table where $browser_hash is criteria
    $db_cookie = Database::getInstance()->findByCriteria('user_sessions', ['hash', '=', $browser_cookie]);
    // Returns Database Object - record from the 'user_sessions' table

    // checks whether `$browser_cookie value` exists in the 'user_sessions' table (count > 0)
    if($db_cookie->count()) {
        
        // get user_id from the 'user_sessions' table
        $user_id = $db_cookie->first()->user_id; // returns user_id as string

        $user = new User($user_id); // WITH parameter (see constructor)!
        // returns `User Object`
        
        // L#17.3 0:40 - if the method is called `WITHOUT PARAMETERS` it means that a user will bu logged in
        // by opennyng any page without providing email and password
        $user->login();
    }
}
