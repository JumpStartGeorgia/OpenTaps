<center>

  <?php echo isset($alert) ? "<i>".$alert."</i><br />" : ""; ?>

  <form action='<?php echo href("login", TRUE); ?>' method='post' id='loginform'>

	Username:<br />
	<input type='text' autocomplete='off' name='username' /> <br />
	Password:<br />
	<input type='password' name='password' /> <br />
	<input type='submit' value='Log In' style='margin-top:8px;' />

  </form>

</center>
