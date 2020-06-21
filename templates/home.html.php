<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <a class="navbar-brand" href="#">User Management</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Главная</a>
      </li>
    </ul>

    <ul class="navbar-nav">
      <!-- display the correct link, depending on whether or not the user is logged in -->
      <?php 
      $user = new User;
      // checks whether `$isLoggedIn property` of `User object` is true
      if ($user->isLoggedIn()): ?>
        <li class="nav-item">
          <a href="profile.php" class="nav-link">Профиль</a>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="nav-link">Выйти</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a href="login.php" class="nav-link">Войти</a>
        </li>
        <li class="nav-item">
          <a href="register.php" class="nav-link">Регистрация</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron">
        <h1 class="display-4">Привет, мир!</h1>
        <p class="lead">Это дипломный проект по разработке на PHP. На этой странице список наших пользователей.</p>
        <hr class="my-4">
        <p>Чтобы стать частью нашего проекта вы можете пройти регистрацию.</p>
        <a class="btn btn-primary btn-lg" href="register.php" role="button">Зарегистрироваться</a>
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
              <td><a href="user_profile.html"><?= htmlspecialchars($record->username, ENT_QUOTES, 'UTF-8'); ?></a></td>
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