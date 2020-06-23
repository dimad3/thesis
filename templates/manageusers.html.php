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
              <a href="editprofile.php?id=<?= $record->id ?>" class="btn btn-warning">Редактировать</a>
              <a href="#" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
              
              <?php if ($record->groupid != 2): ?>
                <a href="#" class="btn btn-success">Назначить администратором</a>
              <?php else: ?>
                <a href="#" class="btn btn-danger">Разжаловать</a>
              <?php endif; ?>              
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>  
