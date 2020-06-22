<div class="container">
  <div class="row">
    <div class="col-md-8">
      <h1>Изменить пароль</h1>
      
      <?php if ($form_submited == true):
        if (!$validation->passed()): ?>
          <div class="alert alert-danger">
            <p>Your password was not updated, please check the following:</p>
            <ul>
              <?php foreach ($validation->errors() as $error): ?>
                <li>
                    <?php echo $error; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php else: ?>
          <div class="alert alert-success">Пароль обновлен</div>
        <?php endif; ?>
      <?php endif; ?>
      
      <form class="form" action="" method="post">
        <div class="form-group">
          <label for="current_password">Текущий пароль</label>
          <input type="password" class="form-control" name="current_password" id="current_password">
        </div>

        <div class="form-group">
          <label for="new_password">Новый пароль</label>
          <input type="password" class="form-control" name="new_password" id="new_password">
        </div>

        <div class="form-group">
          <label for="new_password_again">Повторите новый пароль</label>
          <input type="password" class="form-control" name="new_password_again" id="new_password_again">
        </div>

        <div class="form-group">
          <input type="hidden" class="form-control" name="token" value="<?= Token::generate(); ?>">
        </div>

        <div class="form-group">
          <button class="btn btn-warning">Изменить</button>
        </div>
      </form>

    </div>
  </div>
</div>