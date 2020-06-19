<?php
require_once 'init.php';

$user = new User;   // $user parameter is NOT provided (see constructor)

// check whether the form was submited - returns TRUE if it was and FALSE if it was NOT
if(Input::isSubmited()) {
// if form was submited, then:

    $validation = new Validate();

    // check whether new values correspond with validation's rules
    $validation = $validation->check($_POST, [
        'username'  =>  ['required'=>true, 'min'=>2, 'max'=>12]
    ]); // returns `Validate object`

    // check whether `form's token value` exists in the `$_SESSION[] array`
    if(Token::check(Input::get('token'))) {

        // check whether `$passed property` of `Validate object` is TRUE
        if($validation->passed()) {

            // update data in db's table
            $user->update(['username' => Input::get('username')]);
            // $updateduser = Database::getinstance()->update('users', $user->data()->id, ['username' => Input::get('username')]);
            
            Redirect::to('update.php');
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
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo $user->data()->username;?>">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
</form>
