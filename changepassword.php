<?php
require_once 'init.php';

$user = new User;

// check whether the form was submited - returns TRUE if it was and FALSE if it was NOT
if(Input::isSubmited()) {
// if form was submited, then:
        
    // check whether new values correspond with validation's rules
    $validation = new Validate();
    $validation = $validation->check($_POST, [
        'current_password'      =>  [
            'required'  =>  true, 
            'min'       =>  3
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
    if(Token::check(Input::get('token'))) {
    
        // check whether `$passed property` of `Validate object` is TRUE
        if($validation->passed()) {

            // set `$user_hash variable` assigning the user's password value from table `users` 
            $user_hash = $user->data()->password;    // returns hash string

            // set `$password` assigning form's field's value 
            $password = Input::get('current_password');
            
            // $password - 1-st parameter - form's field `current_password` value
            if(password_verify($password, $user_hash)) {
            // Returns TRUE if the `$password` and `$user_hash` match, or FALSE otherwise
            
            /*
            password    Required. The user's password (string)
            algo        Required. A password algorithm constant denoting the algorithm 
                        to use when hashing the password.
            options     Optional. An associative array containing options.
                        See the password algorithm constants for documentation on 
                        the supported options for each algorithm. 
            Returns the hashed password (as string), or FALSE on failure */
            $new_hash = password_hash(Input::get('new_password'), PASSWORD_DEFAULT);
            
            // update hash in db's table
            $user->update(['password' => $new_hash]);
                
                Session::flash('success', 'Password has been updated.');
                Redirect::to('index.php');
            } else {
                echo 'Invalid current password';
            }

        } else {
            foreach($validation->errors() as $error) {
                // $validation->errors() - ARRAY - `$errors property` of `Validate object`
                // $error - VALUE of each error
                echo $error . '<br>';
            }
        }
    }
}
?>

<form action="" method="post">

    <div class="field">
        <label>Current password</label>
        <input type="text" name="current_password">
    </div>

    <div class="field">
        <label>New password</label>
        <input type="text" name="new_password">
    </div>

    <div class="field">
        <label>New password again</label>
        <input type="text" name="new_password_again">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
</form>
