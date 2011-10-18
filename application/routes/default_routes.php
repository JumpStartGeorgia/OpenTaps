<?php
Slim::get('/', function()
        {

        }
);

Slim::get('/page/:short_name/', function($short_name)
        {
		Storage::instance()->content = template('menu_text', array('menu' => get_menu($short_name)));
        }
);

Slim::get('/login/', function()
        {
            if (!userloggedin())
                Storage::instance()->content = template('login');
        }
);

Slim::post('/login/', function()
        {
            $user = authenticate($_POST['username'], $_POST['password']);
            if ($user)
            {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo "<meta http-equiv='refresh' content='0; url=" . href("admin", TRUE) . "' />";
            }
            else
                Storage::instance()->content = template('login', array('alert' => 'Incorrect Username/Password'));
        }
);

Slim::get('/logout/', function()
        {
            if (userloggedin())
                unset($_SESSION['id'], $_SESSION['username']);
            echo "<meta http-equiv='refresh' content='0; url=" . href(NULL, TRUE) . "' />";
        }
)->name('logout');


Slim::get('/admin/', function()
        {
            if (userloggedin())
                Storage::instance()->content = template('admin/admin');
            else
                Storage::instance()->content = template('login');
        }
);
