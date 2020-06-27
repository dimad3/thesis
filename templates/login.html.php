<form class="form-signin" action='' method='post'>
  <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
	      

  <?php if ($form_submited == true): ?>
    <?php if (!$validation->passed()): ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach ($validation->errors() as $error): ?>
            <li>
                <?php echo $error; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php else: ?>
      <?php if (!$user->isLoggedIn()): ?>
        <div class="alert alert-danger">
          Логин или пароль неверны
        </div>
      <?php endif; ?>
    <?php endif; ?>
  <?php endif; ?>
  
  <div class="form-group">
    <input type="email" class="form-control" name="email" value="<?php echo Input::get('email')?>"
    id="email" placeholder="Email">
  </div>
  
  <div class="form-group">
    <input type="password" class="form-control" name="password" id="password" placeholder="Пароль">
  </div>

  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" name="remember" id="remember"> Запомнить меня <!-- if isset checkbox returns `on` -->
    </label>
  </div>
  
  <div class="form-group">
    <input type="hidden" class="form-control" name="token" value="<?php echo Token::generate();?>">
  </div>

  <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
</form>