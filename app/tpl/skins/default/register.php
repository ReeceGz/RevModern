<?php $template->form->outputError(); ?>
<form method="post" action="register">
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
<input type="text" name="reg_username" placeholder="Username" />
<input type="password" name="reg_password" placeholder="Password" />
<input type="password" name="reg_rep_password" placeholder="Repeat Password" />
<input type="email" name="reg_email" placeholder="Email" />
<button type="submit" name="register">Register</button>
</form>
<p><a href="index">Back</a></p>
