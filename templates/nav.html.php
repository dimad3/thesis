<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <?php $user = new User; ?>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Главная</a>
      </li>
      
      <?php if ($user->isLoggedIn() && $user->hasPermissions('admin')): ?>
        <li class="nav-item">
          <a class="nav-link" href="manageusers.php">Управление пользователями</a>
        </li>
      <?php endif; ?>
    </ul>

    <ul class="navbar-nav">
      <!-- display the correct link, depending on whether or not the user is logged in -->
      <?php if ($user->isLoggedIn()): ?>
        <li class="nav-item">
          <a href="editprofile.php" class="nav-link"><?= $user->data()->username ?> профиль</a>
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