<?php

Slim::get('/', function(){

});

Slim::get('/page/:short_name', function($short_name){
    Storage::instance()->content = $short_name;
});

Slim::get('/login', function(){
    if(!userloggedin())
      Storage::instance()->content = template('login');
});

Slim::post('/login', function(){
    $user = authenticate($_POST['username'], $_POST['password']);
    if($user)
    {
	$_SESSION['id'] = $user['id'];
	$_SESSION['username'] = $user['username'];
	echo "<meta http-equiv='refresh' content='0; url=" . URL . "admin' />";
	//Storage::instance()->content = template('admin', array('alert' => 'Admin logged in successfully'));
    }
    else
    {
	Storage::instance()->content = template('login', array('alert' => 'Incorrect Username/Password'));
    }
});

Slim::get('/admin/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/admin');
});

Slim::get('/admin/:table/', function($table){
    if(userloggedin())
	Storage::instance()->content = template('admin/' . $table . '/all_records', array('table' => $table));
});

Slim::get('/admin/:table/new/', function($table){
    if(userloggedin())
	Storage::instance()->content = template('admin/' . $table . '/new', array('table' => $table));
});

Slim::get('/admin/:table/:id/', function($table, $id){
    if(userloggedin())
	Storage::instance()->content = template('admin/' . $table . '/edit', array('table' => $table, 'id' => $id));
});

Slim::get('/admin/:table/:id/delete/', function($table, $id){
    if(userloggedin())
	Storage::instance()->content = template('admin/' . $table . '/delete', array('table' => $table, 'id' => $id));
});


Slim::post('/admin/:table/create/', function($table){
    if(userloggedin())
	Storage::instance()->content = template('admin/' . $table . '/create', array('table' => $table));
});
Slim::post('/admin/:table/:id/update/', function($table, $id){
    if(userloggedin())
	Storage::instance()->content = template('admin/' . $table . '/update', array('table' => $table, 'id' => $id));
});




Slim::get('/logout', function(){
    session_destroy();
});
