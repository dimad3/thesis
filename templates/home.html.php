<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron">
        <h1 class="display-4">Привет, мир!</h1>
        <p class="lead">Это дипломный проект по разработке на PHP. На этой странице список наших пользователей.</p>
        
        <?php if (!$user->isLoggedIn()): ?>
          <hr class="my-4">
          <p>Чтобы стать частью нашего проекта вы можете пройти регистрацию.</p>
          <a class="btn btn-primary btn-lg" href="register.php" role="button">Зарегистрироваться</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h1>Пользователи</h1>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Дата</th>
          </tr>
        </thead>

        <tbody>

        <?php foreach ($records as $record): ?>
          <tr>
              <td><?= $record->id; ?></td>
              <td><a href="userprofile.php?id=<?= $record->id ?>"><?= htmlspecialchars($record->username, ENT_QUOTES, 'UTF-8'); ?></a></td>
              <td><?= htmlspecialchars($record->email, ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php 
                $date = new DateTime($record->registerdate);
                echo $date->format('d/m/Y');
              ?></td>
          </tr>
        <?php endforeach; ?>
        
        </tbody>
      </table>
    </div>
  </div>
</div>