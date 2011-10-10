<?php

Slim::get('/georgia_profile/', function()
        {
        	Storage::instance()->show_map = FALSE;
        	$pre = "SELECT * FROM georgia_profile WHERE ";
		Storage::instance()->content = template('georgia_profile', array(
			'data' => fetch_db($pre . " main != 1 AND lang = '" . LANG . "';"),
			'main_data' => fetch_db($pre . " main = 1 AND lang = '" . LANG . "' LIMIT 1;", NULL, TRUE)
		));
        }
);


Slim::get('/admin/georgia_profile/', function()
        {
		Storage::instance()->content = template('admin/georgia_profile', array(
			'data' => fetch_db("SELECT * FROM georgia_profile WHERE lang = '" . LANG . "';")
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
        	fetch_db("DELETE FROM georgia_profile;");
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
        		foreach ($languages as $lang)
        		{
        			$sql = "INSERT INTO georgia_profile(
        					`unique`,
        					`lang`,
        					`key`,
        					`value`,
        					`main`
        				 )
        				 VALUES(
        				 	:unique,
        				 	'{$lang}',
        				 	:key,
        				 	:value,
        				 	:main
        				 );";
        			$query = db()->prepare($sql);
        			$query->execute(array(
        				':key' => $keys[$i] . ((LANG == $lang) ? NULL : " ({$lang})"),
        				':unique' => $unique,
        				':value' => $values[$i],
        				':main' => $is_main
        			));
        		}
        	}
		Slim::redirect(href('admin/georgia_profile', TRUE));
        }
);

