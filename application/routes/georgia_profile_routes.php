<?php

Slim::get('/georgia_profile/', function()
        {
        	Storage::instance()->show_map = FALSE;
        	$pre = "SELECT * FROM georgia_profile WHERE ";
		Storage::instance()->content = template('georgia_profile', array(
			'data' => fetch_db($pre . " main != 1 AND `key` != 'datatype_image' AND lang = '" . LANG . "';"),
			'main_data' => fetch_db($pre . " main = 1 AND lang = '" . LANG . "' LIMIT 1;", NULL, TRUE),
			'content' => fetch_db("SELECT * FROM georgia_profile_content WHERE lang = '" . LANG . "';", NULL, TRUE),
			'image' => fetch_db("SELECT * FROM georgia_profile WHERE lang = '" . LANG . "' AND `key` = 'datatype_image';", NULL, TRUE)
		));
        }
);


Slim::get('/admin/georgia_profile/', function()
        {
		Storage::instance()->content = template('admin/georgia_profile', array(
			'data' => fetch_db("SELECT * FROM georgia_profile WHERE lang = '" . LANG . "' AND `key` != 'datatype_image';"),
			'content' => fetch_db("SELECT * FROM georgia_profile_content WHERE lang = '" . LANG . "';", NULL, TRUE),
			'image' => fetch_db("SELECT * FROM georgia_profile WHERE lang = '" . LANG . "' AND `key` = 'datatype_image';", NULL, TRUE)
		));
        }
);


Slim::post('/admin/georgia_profile/', function()
        {
        	$languages = config('languages');
        	$keys = empty($_POST['data_key']) ? array() : $_POST['data_key'];
        	$values = empty($_POST['data_value']) ? array() : $_POST['data_value'];
        	$main = empty($_POST['data_main']) ? array(NULL) : $_POST['data_main'];
        	$main_inserted = FALSE;
        	fetch_db("DELETE FROM georgia_profile WHERE lang = '" . LANG . "' AND `key` != 'datatype_image';");
        	for ($i = 0, $num = count($keys); $i < $num; $i ++)
        	{
        		$unique = generate_unique("georgia_profile");
       			if (!$main_inserted AND $main[$i] == "yes")
       			{
       				$main_inserted = TRUE;
       				$is_main = 1;
       			}
       			else
       			{
       				$is_main = 0;
       			}
        		//foreach ($languages as $lang)
        		//{
        			$sql = "INSERT INTO georgia_profile(
        					`unique`,
        					`lang`,
        					`key`,
        					`value`,
        					`main`
        				 )
        				 VALUES(
        				 	:unique,
        				 	'" . LANG . "', "./*'{$lang}',*/"
        				 	:key,
        				 	:value,
        				 	:main
        				 );";
        			$query = db()->prepare($sql);
        			$query->execute(array(
        				':key' => $keys[$i],// . ((LANG == $lang) ? NULL : " ({$lang})"),
        				':unique' => $unique,
        				':value' => $values[$i],
        				':main' => $is_main
        			));
        		//}
        	}
        	if (!empty($_POST['content']) AND strlen($_POST['content']) > 1)
        	{
		    fetch_db(
		    	"DELETE FROM georgia_profile_content WHERE lang = '" . LANG . "';
		    	 INSERT INTO georgia_profile_content(`lang`, `value`) VALUES('" . LANG . "', :value)",
		    	array(':value' => $_POST['content']));
        	}
        	if (!empty($_FILES['image']) AND $_FILES['image']['size'] > 0)
        	{
		    $img = fetch_db("SELECT value FROM georgia_profile WHERE `key` = 'datatype_image';", NULL, TRUE);
		    if (file_exists($img['value']))
			unlink($img['value']);
		    fetch_db(
		    	"DELETE FROM georgia_profile WHERE lang = '" . LANG . "' AND `key` = 'datatype_image';
		    	 INSERT INTO georgia_profile(`unique`, `key`, `lang`, `value`) VALUES(:unique, 'datatype_image', '" . LANG . "', :value)",
		    	array(':unique' => generate_unique('georgia_profile'), ':value' => image_upload($_FILES['image']))
		    );
        	}
		Slim::redirect(href('admin/georgia_profile', TRUE));
        }
);

