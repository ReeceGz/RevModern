<?php $template->form->outputError(); ?>
<form method="post" action="login">
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
<input type="text" name="log_username" placeholder="Username" />
<input type="password" name="log_password" placeholder="Password" />
<button type="submit" name="login">Login</button>
</form>
<p><a href="register">Register</a> | <a href="forgot">Forgot password?</a></p>
