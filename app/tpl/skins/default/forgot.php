<?php $template->form->outputError(); ?>
<form method="post" action="forgot">
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
<input type="text" name="for_username" placeholder="Username" />
<input type="password" name="for_password" placeholder="New Password" />
<input type="text" name="for_key" placeholder="Secret Key" />
<button type="submit" name="forgot">Submit</button>
</form>
<p><a href="index">Back</a></p>
