<?php
################################################################ tags show routes start

Slim::get('/tags/', function(){
    Storage::instance()->content = template('tags', array('limit' => false));
});

################################################################ tags show routes end

################################################################ tags admin routes start
Slim::get('/admin/tags/', function(){
    Storage::instance()->content = userloggedin() ? template('admin/tags/all_records') : template('login');
});

Slim::get('/admin/tags/new/', function(){
    Storage::instance()->content = userloggedin() ? template('admin/tags/new') : template('login');
});

Slim::get('/admin/tags/:id/', function($id){
    Storage::instance()->content = userloggedin() ? template('admin/tags/edit', array('result' => read_tags($id))) : template('login');
});

Slim::get('/admin/tags/:id/delete/', function($id){
    Storage::instance()->content = userloggedin() ? delete_tag($id) : template('login');
});

Slim::post('/admin/tags/create/', function(){
    Storage::instance()->content = userloggedin() ? add_tag( $_POST['t_name'] ) : template('login');
});

Slim::post('/admin/tags/:id/update/', function($id){
    Storage::instance()->content = userloggedin() ? update_tag( $id, $_POST['t_name'] ) : template('login');
});
################################################################ tags admin routes end
