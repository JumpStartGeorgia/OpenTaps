<?php

Slim::get('/', function(){

});

Slim::get('/page/:short_name', function($short_name){
    Storage::instance()->content = $short_name;
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
	Storage::instance()->content = template('admin', array('alert' => 'Admin logged in successfully'));
    }
    else
    {
	Storage::instance()->content = template('login', array('alert' => 'Incorrect Username/Password'));
    }
});

Slim::get('/admin', function(){
    if(@$_SESSION['id'] && $_SESSION['username'])
        Storage::instance()->content = template('admin');
});

Slim::get('/logout', function(){
    session_destroy();
});
