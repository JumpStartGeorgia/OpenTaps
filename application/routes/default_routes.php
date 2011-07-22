<?php
Slim::get('/', function(){

});

Slim::get('/page/:short_name/', function($short_name){
    Storage::instance()->content = $short_name;
});
################################################################ Login routes start
Slim::get('/login/', function(){
    if(!userloggedin())
	Storage::instance()->content = template('login');
});

Slim::post('/login/', function(){
    $user = authenticate($_POST['username'], $_POST['password']);
    if($user)
    {
	$_SESSION['id'] = $user['id'];
	$_SESSION['username'] = $user['username'];
	echo "<meta http-equiv='refresh' content='0; url=" . URL . "admin' />";
    }
    else
	Storage::instance()->content = template('login', array('alert' => 'Incorrect Username/Password'));
});

Slim::get('/logout/', function(){
    session_destroy();
});
################################################################ Login routes end

Slim::get('/admin/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/admin');
    else
	Storage::instance()->content = template('login');
});
