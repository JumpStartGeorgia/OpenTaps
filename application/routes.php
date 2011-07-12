<?php

Slim::get('/', function(){
    //echo 'Hello World';
});

Slim::get('/login', function(){
    Storage::instance()->content = template('login', array(
        'text' => 'Lorem ipsum dolor sit amet.'
    ));
});

