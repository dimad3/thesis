<?php
require_once __DIR__ . '/../includes/init.php';

$user = new User;

if ($user->isLoggedIn()) {

    // Input::isSubmited() - check whether the form was submited (see forum)
    // Returns TRUE if it was and FALSE if it was NOT
    $form_submited = Input::isSubmited();
    if ($form_submited == true) { // true or false
    // if form was submited, then:
            
        // check whether values correspond with validation's rules
        $validation = new Validation();
        $validation = $validation->check($_POST, [
            'password'      =>  [
                'required'  =>  true,
                'wrong_pass'=>  'users'     // the name of the table where to check the password
            ],

            'new_password'          =>  [
                'required'  =>  true, 
                'min'       =>  3
            ],

            'new_password_again'    =>  [
                'required'  =>  true, 
                'min'       =>  3, 
                'matches'   =>  'new_password'
            ]
        ]);

        // check whether `form's token value` exists in the `$_SESSION[] array`
        if(Token::check(Input::getFieldVal('token'))) {
        
            // check whether `$passed property` of `Validate object` is TRUE
            if($validation->passed()) {
                    /*
                    password    Required. The user's password (string)
                    algo        Required. A password algorithm constant denoting the algorithm 
                                to use when hashing the password.
                    options     Optional. An associative array containing options.
                                See the password algorithm constants for documentation on 
                                the supported options for each algorithm. 
                    Returns the hashed password (as string), or FALSE on failure */
                    $new_hash = password_hash(Input::getFieldVal('new_password'), PASSWORD_DEFAULT);
                    
                    // update hash in db's table
                    $user->update(['password' => $new_hash]);
                    
                    Session::flash('success', 'Password has been updated.');
            }
        }
    }

    $title = 'Change password';

    include_once __DIR__ . '/../templates/nav.html.php';

    $output = __DIR__ . '/../templates/changepassword.html.php';

    include_once __DIR__ . '/../templates/layout.html.php';

} else {
    Redirect::to(404);
}
