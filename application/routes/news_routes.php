<?php

################################################################ News show routes start

Slim::get('/news/', function()
        {
            Storage::instance()->content = template('news', array('news_all' => read_news(FALSE)));
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
<<<<<<< HEAD
        {
            if (!userloggedin())
            {
                Storage::instance()->content = template('login');
                exit;
            }
            Storage::instance()->content = template('admin/news/new', array(
                'all_tags' => read_tags()
                    ));
        }
);

Slim::get('/admin/news/:id/', function($id)
        {
            Storage::instance()->content = userloggedin() ? template('admin/news/edit', array('news' => read_news(false, $id), 'all_tags' => read_tags(), 'news_tags' => read_tag_connector('news', $id))) : template('login');
        }
);
=======
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
);

Slim::get('/admin/news/:id/', function($id){
    Storage::instance()->content = userloggedin()
    	? template('admin/news/edit', array(
                        'news' => read_news(false, 0, $id),
                        'all_tags' => read_tags() ,
                        'news_tags' => read_tag_connector('news',$id),
                        'places' => fetch_db('SELECT * FROM places')
                       ))
    	: template('login');
});
>>>>>>> live-ika

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

<<<<<<< HEAD
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
);

Slim::post('/admin/news/:id/update/', function($id)
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
);
=======
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
>>>>>>> live-ika
################################################################ News admin routes end
