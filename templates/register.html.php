<form class="form-signin" action='' method='post'>
	<img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
	<h1 class="h3 mb-3 font-weight-normal">Registration</h1>
	<div class="alert alert-info">
		User's data
	</div>
	
	<?php if ($form_submited && $rulesaccepted): ?>
		<?php if (!$validation->passed()): ?>
			<div class="alert alert-danger">
				<p>Your account could not be created, please check the following:</p>
				<ul>
					<?php foreach ($validation->errors() as $error): ?>
						<li>
							<?php echo $error; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	<?php elseif($form_submited && !$rulesaccepted): ?>
		<div class="alert alert-danger">
			<?php echo Session::flash('acceptrules_off'); ?>
		</div>
	<?php endif; ?>
	
	<div class="form-group">
		<input type="email" class="form-control" id="email" placeholder="Email"
		name="email" value='<?php echo Input::get('email')?>'>
	</div>

	<div class="form-group">
		<input type="text" class="form-control" id="email" placeholder="Ваше имя"
		name='username' value='<?php echo Input::get('username') ?>'>
	</div>

	<div class="form-group">
		<input type="password" class="form-control" id="password" placeholder="Пароль" 
		name='password' value='<?php echo Input::get('password') ?>'>
	</div>
	
	<div class="form-group">
		<input type="password" class="form-control" id="password" placeholder="Повторите пароль" 
		name='password_again' value='<?php echo Input::get('password_again') ?>'>
	</div>

	<div class="checkbox mb-3">
		<label>
			<input type="checkbox" name='rulesaccepted'> Согласен со всеми правилами
		</label>
	</div>
	
	<div class="form-group">
		<input type='hidden' class="form-control" name='token' value=
		'<?php 
				// call generate method` on Token object` and set new token value to this field
				echo Token::generate();
		?>'>
	</div>

	<button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
</form>