
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