<div class="container">
  <div class="row">
    <div class="col-md-8">
    
    <h1>Профиль пользователя <?= $user->data()->username;?></h1>
      
      <?php if ($form_submited == true):
        if (!$validation->passed()): ?>
          <div class="alert alert-danger">
            <p>Your profile was not updated, please check the following:</p>
            <ul>
              <?php foreach ($validation->errors() as $error): ?>
                <li>
                    <?php echo $error; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php else: ?>
          <div class="alert alert-success">Профиль обновлен</div>
        <?php endif; ?>
      <?php endif; ?>
      
      <form class="form" action="" method="post">
        <div class="form-group">
          <label for="username">Имя</label>
          <input type="text" class="form-control" name="username" 
          value="<?= $user->data()->username;?>" id="username">
        </div>
        
        <div class="form-group">
          <label for="status">Статус</label>
          <input type="text" class="form-control" name="status" 
          value="<?= $user->data()->note;?>" id="status" >
        </div>
        
        <?php if (!isset($user1)): ?>     
          <div class="form-group">
            <a href="changepassword.php">Изменить пароль</a>
          </div>
        <?php endif; ?>

        <div class="form-group">
          <input type="hidden" class="form-control" name="token" value="<?= Token::generate();?>">
        </div>

        <div class="form-group">
          <button class="btn btn-warning">Обновить</button> <!-- type="submit" --> 
        </div>
      </form>
    </div>
  </div>
</div>
