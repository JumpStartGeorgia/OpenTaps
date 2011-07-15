<?php
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
    {
	Storage::instance()->content = template('admin/news/edit', array('id' => $id, 'news' => read_news(1, $id)));
    }
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
      if( add_news($_POST['n_title'], $_POST['n_body']) )
	  Storage::instance()->content = "
		<meta http-equiv='refresh' content='0; url=" . href("admin/news") . "' />
	  ";
      else
	  Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/news") . "\">Back</a>
	  ";
});

Slim::post('/admin/news/:id/update/', function($id){
    if(userloggedin())
      if( update_news($id, $_POST['n_title'], $_POST['n_body']) )
	  Storage::instance()->content = "
		<meta http-equiv='refresh' content='0; url=" . href("admin/news") . "' />
	  ";
      else
	  Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/news") . "\">Back</a>
	  ";
});
################################################################ News admin routes end
