<?php
################################################################ News show routes start

Slim::get('/news/', function(){
    Storage::instance()->content = template('news', array('news_all' => read_news(FALSE)));
});



################################################################ News show routes end

################################################################ News admin routes start
Slim::get('/admin/news/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/news/all_records');
});

Slim::get('/admin/news/new/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/news/new');
});

Slim::get('/admin/news/:id/', function($id){
    if(userloggedin())
	Storage::instance()->content = template('admin/news/edit', array('news' => read_news(false, $id)));
});

Slim::get('/admin/news/:id/delete/', function($id){
    if(userloggedin())
      if( delete_news($id) )
	Storage::instance()->content = "
		<meta http-equiv='refresh' content='0; url=" . href("admin/news") . "' />
	";
      else
	Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/news") . "\">Back</a>
	";
});

Slim::post('/admin/news/create/', function(){
    if(userloggedin())
    {
      $filedata = array(
      	  "name" => $_FILES['n_file']['name'],
      	  "type" => $_FILES['n_file']['type'],
      	  "size" => $_FILES['n_file']['size'],
      	  "tmp_name" => $_FILES['n_file']['tmp_name']
      );
      Storage::instance()->content = add_news( $_POST['n_title'], $_POST['n_body'], $filedata );
    }
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
      Storage::instance()->content = update_news( $id, $_POST['n_title'], $_POST['n_body'], $filedata );
    }
});
################################################################ News admin routes end
