<div class="container">
  <div class="col-md-12">
    <h1>Пользователи</h1>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Имя</th>
          <th>Email</th>
          <th>Действия</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($records as $record): ?>
          <tr>
            <td><?= $record->id; ?></td>
            <td><?= htmlspecialchars($record->username, ENT_QUOTES, 'UTF-8'); ?></a></td>
            <td><?= htmlspecialchars($record->email, ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <a href="userprofile.php?id=<?= $record->id ?>" class="btn btn-info">Посмотреть</a>
              
              <?php if ($user->hasPermissions('admin')): ?>
                <a href="editprofile.php?id=<?= $record->id ?>" class="btn btn-warning">Редактировать</a>
                <?php if ($record->groupid != 2): ?>
                  <a href="deleteuser.php?id=<?= $record->id ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
                <?php endif; ?>
                <?php if ($record->groupid == 1): ?>
                  <a href="#" class="btn btn-success">Назначить модератором</a>
                <?php endif; ?>
                <?php if ($record->groupid == 3): ?>
                  <a href="#" class="btn btn-danger">Разжаловать модератора</a>
                <?php endif; ?>
              <?php endif; ?>
              
              <?php if ($user->hasPermissions('moderator')): ?>
                <?php if ($user->hasPermissions('admin') == false): ?>
                  <?php if ($record->groupid != 2): ?>
                    <a href="editprofile.php?id=<?= $record->id ?>" class="btn btn-warning">Редактировать</a>
                  <?php endif; ?>
                  <?php if ($record->groupid == 1): ?>
                    <a href="deleteuser.php?id=<?= $record->id ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>  
