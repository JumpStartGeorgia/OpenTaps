<?php

################################################################ IRAKLI's routes START
$places = fetch_db("SELECT * FROM places");
$js_places = array();
foreach ($places as $place)
	$js_places[] = '[' . $place['id'] . ', ' . $place['longitude'] . ', ' . $place['latitude'] . ']';
Storage::instance()->js_places = $js_places;

Slim::get('/admin/places/',function(){
    if(userloggedin())
    {
	if(isset($_GET['id']) && strlen($_GET['id'])!=0 && is_numeric($_GET['id']))
		delete_place($_GET['id']);

	Storage::instance()->content = template('places');
    }
});	
Slim::post('/admin/places/',function(){
    if(userloggedin())
    {
      if(isset($_POST['lon']) && isset($_POST['lat']))
	if(is_numeric($_POST['lon']) && is_numeric($_POST['lat']))
		add_place($_POST['lon'],$_POST['lat']);
	elseif( is_numeric($_POST['id_edit']) && is_numeric($_POST['lon_edit']) && is_numeric($_POST['lat_edit']) )
		edit_place($_POST['id_edit'],$_POST['lon_edit'],$_POST['lat_edit']);
	Storage::instance()->content = template('places');
    }	
});

Slim::get('/admin/orgmanagement/',function(){
    if(userloggedin())
    {
	if( isset($_GET['id']) && strlen($_GET['id'])!=0 && is_numeric($_GET['id']) )
		delete_organization($_GET['id']);
	unset($_GET['id']);
	Storage::instance()->content = template('orgmanagement');
    }
});
Slim::post('/admin/orgmanagement/',function(){
    if(userloggedin())
    {
	if(isset($_POST['org_name']) && isset($_POST['org_desc']) && !isset($_POST['org_id'])){
		if(strlen($_POST['org_name'])!=0 && strlen($_POST['org_desc'])!=0){
			add_organization($_POST['org_name'],$_POST['org_desc']);
		}
	}
	else if(isset($_POST['org_name']) && isset($_POST['org_desc']) && isset($_POST['org_id'])){
		if(strlen($_POST['org_name'])!=0 && strlen($_POST['org_desc'])!=0 && strlen($_POST['org_id'])!=0){
			if(is_numeric($_POST['org_id'])){
				edit_organization($_POST['org_id'],$_POST['org_name'],$_POST['org_desc']);
			}
		}
	}
	
	Storage::instance()->content = template('orgmanagement');
    }	
});

################################################################ IRAKLI END

Slim::get('/', function(){

});

Slim::get('/page/:short_name', function($short_name){
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

Slim::get('/logout', function(){
    session_destroy();
});
################################################################ Login routes end



Slim::get('/admin/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/admin');
    else
	Storage::instance()->content = template('login');
});
