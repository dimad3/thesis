<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1>Данные пользователя</h1>
      <table class="table">
        <thead>
          <th>ID</th>
          <th>Имя</th>
          <th>Дата регистрации</th>
          <th>Статус</th>
        </thead>

        <tbody>
          <tr>
              <td><?= $record['id']; ?></td>
              <td><?= htmlspecialchars($record['username'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php 
                $date = new DateTime($record['registerdate']);
                echo $date->format('d/m/Y');
              ?></td>
              <td><?= htmlspecialchars($record['note'], ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>
        
          <tr>
            <td>2</td>
            <td>Джон</td>
            <td>25/02/2025</td>
            <td>Привет! Я новый пользователь вашего проекта, хочу перейти на уровень 3!</td>
          </tr>
        </tbody>
      </table>


    </div>
  </div>
</div>