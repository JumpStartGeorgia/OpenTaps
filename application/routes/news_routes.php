<?php


################################################################ News show routes start

Slim::get('/news/', function()
    {
	$nosp = config('news_on_single_page');

	$query = " SELECT COUNT(id) AS total FROM news WHERE lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute(array());
	$total = $query->fetch(PDO::FETCH_ASSOC);
	$total = $total['total'];
	$total_pages = ($total % $nosp == 0) ? $total / $nosp : ($total + ($nosp - $total % $nosp)) / $nosp;

	$query = "SELECT DISTINCT tags.id,
			 tags.name,
			 (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique`)
			 AS total_tags
		  FROM tag_connector
		  JOIN tags ON tag_connector.tag_unique = tags.`unique`
		  JOIN news ON tag_connector.news_unique = news.`unique`
		  WHERE tags.lang = '" . LANG . "' AND news.lang = '" . LANG . "';";
	$query = db()->prepare($query);
	$query->execute();
	$tags = $query->fetchAll(PDO::FETCH_ASSOC);

	Storage::instance()->content = template('news', array(
		'news_all' => read_news_one_page(0, $nosp),
    		'current_page' => 1,
    		'total_pages' => $total_pages,
    		'this_type' => NULL,
    		'tags' => $tags
	));
    }
);

Slim::get('/news/:unique/', function($unique)
    {
	$sql = "SELECT * FROM pages_data
		WHERE owner = 'news' AND owner_unique = :unique AND lang = '" . LANG . "' AND `sidebar` = :sidebar
		ORDER BY `sort`,`unique`;";

        Storage::instance()->content = template('news_single', array(
        	'news' => read_news(FALSE, 0, $unique),
        	'data' => fetch_db($sql, array(':unique' => $unique, ':sidebar' => 0)),
        	'side_data' => fetch_db($sql, array(':unique' => $unique, ':sidebar' => 1))
        ));
    }
);

Slim::get('/news/page/:page/', function($page)
    {
	($page > 0) OR die('invalid page');
	$nosp = config('news_on_single_page');

	$query = "  SELECT COUNT(id) AS total FROM news WHERE lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute(array());
	$total = $query->fetch(PDO::FETCH_ASSOC);
	$total = $total['total'];
	$total_pages = ($total % $nosp == 0) ? $total / $nosp : ($total + ($nosp - $total % $nosp)) / $nosp;
	($page > $total_pages) AND die('invalid page');

	$query = "SELECT DISTINCT tags.id,
			 tags.name,
			 (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique`)
			 AS total_tags
		  FROM tag_connector
		  JOIN tags ON tag_connector.tag_unique = tags.`unique`
		  JOIN news ON tag_connector.news_unique = news.`unique`
		  WHERE tags.lang = '" . LANG . "' AND news.lang = '" . LANG . "';";
	$query = db()->prepare($query);
	$query->execute();
	$tags = $query->fetchAll(PDO::FETCH_ASSOC);

	Storage::instance()->content = template('news', array(
		'news_all' => read_news_one_page(($nosp * $page - $nosp), $nosp),
    		'current_page' => $page,
    		'total_pages' => $total_pages,
    		'this_type' => NULL,
    		'tags' => $tags
	));
    }
);

Slim::get('/news/type/:type/', function($type)
    {
	in_array($type, config('news_types')) OR die('invalid news type');

	$nosp = config('news_on_single_page');

	$query = "  SELECT COUNT(id) AS total FROM news WHERE category = :type AND lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute(array(':type' => $type));
	$total = $query->fetch(PDO::FETCH_ASSOC);
	$total = $total['total'];
	$total_pages = ($total % $nosp == 0) ? $total / $nosp : ($total + ($nosp - $total % $nosp)) / $nosp;

	$query = "SELECT DISTINCT tags.id,tags.name,
			 (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique`)
			 AS total_tags
		  FROM tag_connector
		  JOIN tags ON tag_connector.tag_unique = tags.`unique`
		  JOIN news ON tag_connector.news_unique = news.`unique`
		  WHERE news.category = :type AND tags.lang = '" . LANG . "' AND news.lang = '" . LANG . "';";
	$query = db()->prepare($query);
	$query->execute(array(':type' => $type));
	$tags = $query->fetchAll(PDO::FETCH_ASSOC);

	Storage::instance()->content = template('news', array(
		'news_all' => read_news_one_page(0, $nosp, $type),
    		'current_page' => 1,
    		'total_pages' => $total_pages,
    		'this_type' => $type,
    		'tags' => $tags
	));
    }
);

Slim::get('/news/type/:type/:page/', function($type, $page)
    {
	($page > 0) OR die('invalid page');
	in_array($type, config('news_types')) OR die('invalid news type');

	$nosp = config('news_on_single_page');

	$query = "  SELECT COUNT(id) AS total FROM news WHERE category = :type AND lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute(array(':type' => $type));
	$total = $query->fetch(PDO::FETCH_ASSOC);
	$total = $total['total'];
	$total_pages = ($total % $nosp == 0) ? $total / $nosp : ($total + ($nosp - $total % $nosp)) / $nosp;
	($page > $total_pages) AND die('invalid page');

	$query = "SELECT DISTINCT tags.id,tags.name,
			 (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique`)
			 AS total_tags
		  FROM tag_connector
		  JOIN tags ON tag_connector.tag_unique = tags.`unique`
		  JOIN news ON tag_connector.news_unique = news.`unique`
		  WHERE news.category = :type AND tags.lang = '" . LANG . "' AND news.lang = '" . LANG . "';";
	$query = db()->prepare($query);
	$query->execute(array(':type' => $type));
	$tags = $query->fetchAll(PDO::FETCH_ASSOC);

	Storage::instance()->content = template('news', array(
		'news_all' => read_news_one_page(($nosp * $page - $nosp), $nosp, $type),
    		'current_page' => $page,
    		'total_pages' => $total_pages,
    		'this_type' => $type,
    		'tags' => $tags
	));
    }
);

################################################################ News show routes end
################################################################ News admin routes start
Slim::get('/admin/news/', function()
        {
            Storage::instance()->content = userloggedin() ? template('admin/news/all_records') : template('login');
        }
);

Slim::get('/admin/news/new/', function()
        {
            if (!userloggedin())
            {
                Storage::instance()->content = template('login');
                exit;
            }
            Storage::instance()->content = template('admin/news/new', array(
		'all_tags' => read_tags(),
		'places' => fetch_db("SELECT * FROM places WHERE lang = '" . LANG . "'")
            ));
        }
);

/*Slim::get('/admin/news/:id/', function($id)
        {
            Storage::instance()->content = userloggedin() ? template('admin/news/edit', array('news' => read_news(false, $id), 'all_tags' => read_tags(), 'news_tags' => read_tag_connector('news', $id))) : template('login');
        }
);

{
	if (!userloggedin())
	{
		Storage::instance()->content = template('login');
		exit;
	}
    Storage::instance()->content =  template('admin/news/new',array(
        'places' => fetch_db('SELECT * FROM places'),
        'all_tags' => read_tags()
    ));
}
);*/

Slim::get('/admin/news/:unique/', function($unique)
{
    Storage::instance()->content = userloggedin()
    	? template('admin/news/edit', array(
                        'news' => read_news(false, 0, $unique),
                        'all_tags' => read_tags() ,
                        'news_tags' => read_tag_connector('news', $unique),
                        'places' => fetch_db("SELECT * FROM places WHERE lang = '" . LANG . "'"),
			'data' => read_page_data('news', $unique)
                       ))
    	: template('login');
});


Slim::get('/admin/news/:unique/delete/', function($unique)
        {
            if (userloggedin())
                if (delete_news($unique))
                    Slim::redirect(href('admin/news', TRUE));
                else
                    Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/news", TRUE) . "\">Back</a>
	";
            else
                Storage::instance()->content = template('login');
        }
);

/*
Slim::post('/admin/news/create/', function()
        {
            if (userloggedin())
            {
                $filedata = array(
                    "name" => $_FILES['n_file']['name'],
                    "type" => $_FILES['n_file']['type'],
                    "size" => $_FILES['n_file']['size'],
                    "tmp_name" => $_FILES['n_file']['tmp_name']
                );
                Storage::instance()->content = add_news($_POST['n_title'], $_POST['n_body'], $filedata, $_POST['p_tags']);
            }
            else
                Storage::instance()->content = template('login');
        }
        );*/

/*Slim::post('/admin/news/:id/update/', function($id)
        {
            if (userloggedin())
            {
                $filedata = array(
                    "name" => $_FILES['n_file']['name'],
                    "type" => $_FILES['n_file']['type'],
                    "size" => $_FILES['n_file']['size'],
                    "tmp_name" => $_FILES['n_file']['tmp_name']
                );
                Storage::instance()->content = update_news($id, $_POST['n_title'], $_POST['n_body'], $filedata, $_POST['p_tags']);
            }
            else
                Storage::instance()->content = template('login');
        }
);*/

Slim::post('/admin/news/create/', function(){
    if(userloggedin())
    {
	    $filedata = array(
	    "name" => $_FILES['n_file']['name'],
	    "type" => $_FILES['n_file']['type'],
	    "size" => $_FILES['n_file']['size'],
	    "tmp_name" => $_FILES['n_file']['tmp_name']
	);
	empty($_POST['p_tag_uniques']) AND $_POST['p_tag_uniques'] = array();
	!empty($_POST['record_language']) AND in_array($_POST['record_language'], config('languages')) OR $_POST['record_language'] = LANG;
	Storage::instance()->content = add_news(
		$_POST['record_language'],
		$_POST['n_title'],
		(empty($_POST['n_show_in_slider']) ? 0 : 1),
		$_POST['n_body'],
		$filedata,
		$_POST['n_category'],
		$_POST['n_place'],
		$_POST['p_tag_uniques'],
		$_POST['p_tag_names'],
        	empty($_POST['data_key']) ? NULL : $_POST['data_key'],
        	empty($_POST['data_sort']) ? NULL : $_POST['data_sort'],
        	empty($_POST['data_value']) ? NULL : $_POST['data_value'],
        	empty($_POST['sidebar']) ? NULL : $_POST['sidebar']
	);
    }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/news/:unique/update/', function($unique){
    if(userloggedin())
    {
	delete_page_data('news', $unique);
	if (!empty($_POST['data_key']))
	    add_page_data('news',$unique, $_POST['data_key'], $_POST['data_sort'], $_POST['sidebar'], $_POST['data_value']);
	$filedata = array(
	    "name" => $_FILES['n_file']['name'],
	    "type" => $_FILES['n_file']['type'],
	    "size" => $_FILES['n_file']['size'],
	    "tmp_name" => $_FILES['n_file']['tmp_name']
	);
	empty($_POST['p_tag_uniques']) AND $_POST['p_tag_uniques'] = array();
	Storage::instance()->content = update_news(
		$unique,
		$_POST['n_title'],
		(empty($_POST['n_show_in_slider']) ? 0 : 1),
		$_POST['n_body'],
		$filedata,
		$_POST['n_category'],
		$_POST['n_place'],
		$_POST['p_tag_uniques'],
		$_POST['p_tag_names']);
    }
    else
	Storage::instance()->content = template('login');
});

################################################################ News admin routes end


