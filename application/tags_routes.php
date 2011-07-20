<?php
################################################################ tags show routes start

Slim::get('/tags/', function(){
    Storage::instance()->content = template('tags', array('limit' => false));
});

################################################################ tags show routes end

################################################################ tags admin routes start
Slim::get('/admin/tags/', function(){
    if(userloggedin())
       Storage::instance()->content = template('admin/tags/all_records');
});

Slim::get('/admin/tags/new/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/tags/new');
});

Slim::get('/admin/tags/:id/', function($id){
    if(userloggedin())
	Storage::instance()->content = template('admin/tags/edit', array('result' => read_tags($id)));
});

Slim::get('/admin/tags/:id/delete/', function($id){
    if(userloggedin())
	Storage::instance()->content = delete_tag($id);
});

Slim::post('/admin/tags/create/', function(){
    if(userloggedin())
        Storage::instance()->content = add_tag( $_POST['t_name'] );
});

Slim::post('/admin/tags/:id/update/', function($id){
    if(userloggedin())
        Storage::instance()->content = update_tag( $id, $_POST['t_name'] );
});
################################################################ tags admin routes end
