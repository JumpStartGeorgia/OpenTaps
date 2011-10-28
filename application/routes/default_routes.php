<?php

Slim::get('/', function()
        {

        }
);

Slim::get('/page/:short_name/', function($short_name)
        {
            Storage::instance()->content = template('menu_text', array('menu' => get_menu($short_name)));
        }
)->name('static-page');

Slim::get('/login/', function()
        {
            if (!userloggedin())
                Storage::instance()->content = template('login');
        }
);

Slim::get('/login/incorrect/', function()
        {
            if (!userloggedin())
                Storage::instance()->content = template('login', array('alert' => 'Incorrect Username/Password'));
        }
);

Slim::post('/login/', function()
        {
            $user = authenticate($_POST['username'], $_POST['password']);
            if ($user)
            {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                Slim::redirect(href("admin", TRUE));
            }
            else
                Slim::redirect(href("login/incorrect", TRUE));
        }
);

Slim::get('/logout/', function()
        {
            if (userloggedin())
                unset($_SESSION['id'], $_SESSION['username']);
            exit("<meta http-equiv='refresh' content='0; url=" . href(NULL, TRUE) . "' />");
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

Slim::get('/admin/change_visibility/:what/:id', function($what, $id)
        {
            userloggedin() OR exit("<meta http-equiv='refresh' content='0; url=" . href(NULL, TRUE) . "' />");
            db()->exec("UPDATE `{$what}` SET `hidden` = IF (`hidden` = 1, 0, 1) WHERE `id` = {$id} LIMIT 1;");
            exit('<meta http-equiv="refresh" content="0; url=' . href() . 'admin/' . $what . '?lang=' . LANG . '" />');
        }
);
