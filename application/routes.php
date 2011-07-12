<?php

Slim::get('/', function(){

});

Slim::get('/login', function(){
    if(!isset($_SESSION['username']))
    Storage::instance()->content = template('login');
});

Slim::post('/login', function(){
    $user = authenticate($_POST['username'], $_POST['password']);
    if($user)
    {
	$_SESSION['id'] = $user['id'];
	$_SESSION['username'] = $user['username'];
    }
    else
    {
	Storage::instance()->content = template('login', array('alert' => 'Incorrect Username/Password'));
    }
});

Slim::get('/logout', function(){
    session_destroy();
});
