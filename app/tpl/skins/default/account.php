<?php $template->form->outputError(); ?>
<form method="post" action="account">
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
<input type="text" name="acc_motto" value="{motto}" />
<input type="email" name="acc_email" value="{email}" />
<input type="password" name="acc_old_password" placeholder="Current Password" />
<input type="password" name="acc_new_password" placeholder="New Password" />
<button type="submit" name="account">Save</button>
</form>
<p><a href="me">Back</a></p>
