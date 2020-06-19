<?php
 $css = 'style1.css';  // ok
// $css = 'css/style.css'; // ok
// $css = __DIR__ . '/../css/style.css';  // BUG ???
$title = 'Register';

include __DIR__ . '/../templates/layout.html.php';

require_once 'init.php';

// L#8
// Input::isSubmited() - check whether the form was submited (see forum)
// Returns TRUE if it was and FALSE if it was NOT
if (Input::isSubmited()) { // true or false
    
  // L#9 05:10 - get a VALUE of a form's field after the form was submited
  // 'token' - the name of the form's field from which to get the VALUE
  $fieldValue = Input::get('token');  // true or false

  // check whether `form's token value` exists in the `$_SESSION[] array`
  $tokenExists = Token::check($fieldValue); // true or false
  
  if ($tokenExists == true) { // L#9 
  
    $validation = new Validate();

    $validation = $validation->check(
        $_POST,
        [
            'username' => [                 // field name
                'required'  => true,
                'min'       => 3,
                'max'       => 12,
                'unique'    => 'users'      // the name of the table
            ],
            
            'email' =>  [                   // 'email'field name
                'required'  =>  true,
                'email'     =>  true,       // 'email' rule name
                'unique'    =>  'users'     // the name of the table
            ],

            'password' => [                 // field name
                'required'  => true,
                'min'       => 3
            ],

            'password_again' => [           // field name
                'required'  => true,
                'matches'   => 'password'   // the name of the field to compare with
            ]
        ]
    );

    // $validation = Validate object
    // check whether `$passed property` of `Validate object` is TRUE
    if ($validation->passed()) {
        
        $user = new User;
        
        // insert datta in db
        $user = $user->create([
            // set fields and its values to be inserted in db
            'username' => Input::get('username'),
            'email' =>    Input::get('email'),
            /*
            password    Required. The user's password (string)
            algo        Required. A password algorithm constant denoting the algorithm 
                        to use when hashing the password.
            options     Optional. An associative array containing options.
                        See the password algorithm constants for documentation on 
                        the supported options for each algorithm. 
            Returns the hashed password (as string), or FALSE on failure */
            'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT)
        ]);
        
        // unset($_POST); // delete $_POST from Superglobals
        $_POST = array();

        // set new element in the $_SESSION[] array
        Session::flash('success', 'register success');
        // echo 'passed';
        // header('location: test.php');
    } else {
        foreach($validation->errors() as $error) {
            // $validation->errors() - ARRAY - `$errors property` of `Validate object`
            // $error - VALUE of each error
            echo $error . '</br>';
        }
    }
  }

}
?>

<body class="text-center">
  <form class="form-signin" action='' method='post'>
    <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>

    <div class="alert alert-danger">
      <ul>
        <li>Ошибка валидации 1</li>
        <li>Ошибка валидации 2</li>
        <li>Ошибка валидации 3</li>
      </ul>
    </div>
    

    <div class="alert alert-success">
      <?php 
          // display a flash msg
          echo Session::flash('success'); 
      ?>
    </div>

    <div class="alert alert-info">
      Информация
    </div>

    <div class="form-group">
      <input type="email" class="form-control" id="email" placeholder="Email"
      name="email" value='<?php echo Input::get('email')?>'>
    </div>

    <div class="form-group">
      <input type="text" class="form-control" id="email" placeholder="Ваше имя"
      name='username' value='<?php echo Input::get('username') ?>'>
    </div>

    <div class="form-group">
      <input type="password" class="form-control" id="password" placeholder="Пароль" name='password'>
    </div>
    
    <div class="form-group">
      <input type="password" class="form-control" id="password" placeholder="Повторите пароль" name='password_again'>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" name='acceptrules'> Согласен со всеми правилами
      </label>
    </div>
    
    <div class="form-group">
      <input type='text' class="form-control" name='token' value=
      '<?php 
          // call generate method` on Token object` and set new token value to this field
          echo Token::generate();
      ?>'>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
  </form>
</body>
</html>
