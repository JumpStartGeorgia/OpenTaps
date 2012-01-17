<?php

Slim::get('/temproute/', function()
    {
	$projects = fetch_db("select `unique`
	from projects as kap where
	    (select count(id) from pages_data where lang = 'ka' and owner = 'project' and owner_unique = kap.`unique`) > 0 and
	    (select count(id) from pages_data where lang = 'en' and owner = 'project' and owner_unique = kap.`unique`) = 0 and
	    lang = 'ka'");
	foreach ($projects as &$p)
	{
	    $ds = fetch_db("select * from pages_data where lang = 'ka' and owner = 'project' and owner_unique = " . $p['unique'] . "");

	    foreach ($ds as $d)
	    {
		fetch_db("insert into pages_data(`unique`, lang, `key`, `sort`, sidebar, `value`, owner, owner_unique) values(
				" . generate_unique('pages_data') . ",
				'en',
				'" . $d['key'] . " (en)',
				" . $d['sort'] . ",
				" . $d['sidebar'] . ",
				'" . $d['value'] . "',
				'" . $d['owner'] . "',
				" . $d['owner_unique'] . ")");
	    }
	}
	/*$ps = fetch_db("select `unique`, region_unique as ru, district_unique as du from projects where lang = 'ka' and region_unique != 0 and district_unique != 0;");
	foreach($ps as $p)
	{
	    fetch_db(
		"update projects set region_unique = :ru, district_unique = :du where lang = 'en' and `unique` = :un",
		array(
		    ':ru' => $p['ru'],
		    ':du' => $p['du'],
		    ':un' => $p['unique']
		)
	    );
	}*/
	Storage::instance()->content = 'success';
    }
);

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

Slim::get('/admin/change_visibility/:what/:id/', function($what, $id)
        {
            userloggedin() OR exit("<meta http-equiv='refresh' content='0; url=" . href(NULL, TRUE) . "' />");
            db()->exec("UPDATE `{$what}` SET `hidden` = IF (`hidden` = 1, 0, 1) WHERE `id` = {$id} LIMIT 1;");
            Slim::redirect(href('admin/' . $what, TRUE));
        }
);

Slim::get('/capture(/:url(/:outputFile(/:delay(/:minWidth(/:minHeight)))))',function ($url = null,$outputFile = null,$delay = null,$minWidth = null,$minHeight = null)
	{				
		capture(array(
			'url' => $url,
			'output_file' => $outputFile,
			'delay' => $delay,
			'min-width' => $minWidth,
			'min-height' => $minHeight
		));
	}
);
