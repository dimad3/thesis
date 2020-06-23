<?php
require_once 'init.php';

$user = new User;   // $user parameter is NOT provided (see constructor)

if ($user->isLoggedIn()) {

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

                if ($user->hasPermissions('admin') && !empty($_GET)) {
                    // update data in db's table for user profile (2nd argument is provided)
                    $user->update(
                        ['username' => Input::get('username'),
                        'note'     => Input::get('status')
                        ],
                        $_GET['id']
                    );
                } else {
                    // update data in db's table for admin profile (2nd argument is NOT provided)
                    $user->update([
                        'username' => Input::get('username'),
                        'note'     => Input::get('status')
                    ]);
                }
            }
        }
    }

    // $custom_css = 'style1.css';

    $title = 'Edit profile';

    include __DIR__ . '/../templates/nav.html.php';

    // prepare user objects to be used in 'editprofile.html.php'
    if ($user->hasPermissions('admin') && !empty($_GET)) {
        $user1 = $user;                 // $user1 is admin
        $user = new User($_GET['id']);  // $user2 is user to be edited
    }

    $output = __DIR__ . '/../templates/editprofile.html.php';

    include __DIR__ . '/../templates/layout.html.php';
} else {
    Redirect::to(404);
}
