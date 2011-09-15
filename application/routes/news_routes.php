<?php


################################################################ News show routes start

Slim::get('/news/', function()
    {
	$nosp = config('news_on_single_page');

	$query = "  SELECT COUNT(id) AS total FROM news WHERE lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute(array());
	$total = $query->fetch(PDO::FETCH_ASSOC);
	$total = $total['total'];
	$total_pages = ($total <= $nosp) ? 1 : ($total - $total % $nosp) / $nosp;

	$query = "SELECT tags.name,
			 (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_id = tags.id) AS total_tags
		  FROM tag_connector
		  JOIN tags ON tag_connector.tag_id = tags.id
		  JOIN news ON tag_connector.news_id = news.id
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

Slim::get('/news/page/:page/', function($page)
    {
	($page > 0) OR die('invalid page');
	$nosp = config('news_on_single_page');

	$query = "  SELECT COUNT(id) AS total FROM news WHERE lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute(array());
	$total = $query->fetch(PDO::FETCH_ASSOC);
	$total = $total['total'];
	$total_pages = ($total <= $nosp) ? 1 : ($total - $total % $nosp) / $nosp;
	($page > $total_pages) AND die('invalid page');

	$query = "SELECT tags.name,
			 (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_id = tags.id) AS total_tags
		  FROM tag_connector
		  JOIN tags ON tag_connector.tag_id = tags.id
		  JOIN news ON tag_connector.news_id = news.id
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

	$query = "  SELECT COUNT(id) AS total FROM news WHERE type = :type AND lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute(array(':type' => $type));
	$total = $query->fetch(PDO::FETCH_ASSOC);
	$total = $total['total'];
	$total_pages = ($total <= $nosp) ? 1 : ($total - $total % $nosp) / $nosp;

	$query = "SELECT tags.name,
			 (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_id = tags.id) AS total_tags
		  FROM tag_connector
		  JOIN tags ON tag_connector.tag_id = tags.id
		  JOIN news ON tag_connector.news_id = news.id
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

	$query = "  SELECT COUNT(id) AS total FROM news WHERE type = :type AND lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute(array(':type' => $type));
	$total = $query->fetch(PDO::FETCH_ASSOC);
	$total = $total['total'];
	$total_pages = ($total <= $nosp) ? 1 : ($total - $total % $nosp) / $nosp;
	($page > $total_pages) AND die('invalid page');

	$query = "SELECT tags.name,
			 (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_id = tags.id) AS total_tags
		  FROM tag_connector
		  JOIN tags ON tag_connector.tag_id = tags.id
		  JOIN news ON tag_connector.news_id = news.id
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

Slim::get('/admin/news/:id/', function($id){
    Storage::instance()->content = userloggedin()
    	? template('admin/news/edit', array(
                        'news' => read_news(false, 0, $id),
                        'all_tags' => read_tags() ,
                        'news_tags' => read_tag_connector('news',$id),
                        'places' => fetch_db("SELECT * FROM places WHERE lang = '" . LANG . "'")
                       ))
    	: template('login');
});


Slim::get('/admin/news/:id/delete/', function($id)
        {
            if (userloggedin())
                if (delete_news($id))
                    Slim::redirect(href('admin/news'));
                else
                    Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/news") . "\">Back</a>
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
      Storage::instance()->content = add_news( $_POST['n_title'], $_POST['n_body'], $filedata, $_POST['n_category'], $_POST['n_place'], $_POST['p_tags']);
    }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/news/:id/update/', function($id){
    if(userloggedin())
    {
      $filedata = array(
      	  "name" => $_FILES['n_file']['name'],
      	  "type" => $_FILES['n_file']['type'],
      	  "size" => $_FILES['n_file']['size'],
      	  "tmp_name" => $_FILES['n_file']['tmp_name']
      );
      Storage::instance()->content = update_news( $id, $_POST['n_title'], $_POST['n_body'], $filedata , $_POST['n_category'], $_POST['n_place'],$_POST['p_tags']);
    }
    else
	Storage::instance()->content = template('login');
});

################################################################ News admin routes end


