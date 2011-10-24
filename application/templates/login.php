<center>

    <?php echo isset($alert) ? "<i>" . $alert . "</i><br />" : ""; ?>

    <form action='<?php echo href("login", TRUE); ?>' method='post' id='loginform'>
        <br />
        <?php echo l('user_name') ?>:<br />
        <input type='text' id="login-username" autocomplete='off' name='username' /> <br />
        <?php echo l('password') ?>:<br />
        <input type='password' name='password' /> <br />
        <input type='submit' value='<?php echo l('login') ?>' style='margin-top:8px;' />

    </form>

</center>
