<?php
require_once 'init.php';

$user = new User;   // $user parameter is NOT provided (see constructor)

// Input::isSubmited() - check whether the form was submited (see forum)
// Returns TRUE if it was and FALSE if it was NOT
$form_submited = Input::isSubmited();
if ($form_submited == true) { // true or false
// if form was submited, then:

    $validation = new Validate();

    // check whether new values correspond with validation's rules
    $validation = $validation->check($_POST, [
        'username'  =>  ['required'=>true, 'min'=>2, 'max'=>12],
        'status'      =>  ['required'=>true, 'max'=>255]
    ]); // returns `Validate object`

    // check whether `form's token value` exists in the `$_SESSION[] array`
    if(Token::check(Input::get('token'))) {

        // check whether `$passed property` of `Validate object` is TRUE
        if($validation->passed()) {

            // update data in db's table
            $user->update([
                'username' => Input::get('username'),
                'note'     => Input::get('status')
            ]);
        }
    }
}

// $custom_css = 'style1.css';

$title = 'My profile';

include __DIR__ . '/../templates/nav.html.php';

$output = __DIR__ . '/../templates/editprofile.html.php';

include __DIR__ . '/../templates/layout.html.php';