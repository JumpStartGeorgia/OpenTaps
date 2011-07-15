<?php

$places = fetch_db("SELECT * FROM places");
$js_places = array();
foreach ($places as $place)
	$js_places[] = '[' . $place['id'] . ', ' . $place['longitude'] . ', ' . $place['latitude'] . ']';
	print_r($js_places);
Storage::instance()->js_places = $js_places;

Slim::get("/",function(){

});

Slim::get('/login', function(){
    Storage::instance()->content = template('login', array(
        'text' => 'Lorem ipsum dolor sit amet.'
    ));
});

Slim::get('/places',function(){
	if(isset($_GET['id'])){
		if(strlen($_GET['id'])!=0){
			if(is_numeric($_GET['id'])){
				delete_place($_GET['id']);
			}
		}	
	}
	Storage::instance()->content = template('places');
});	
Slim::post('/places',function(){
	
	if(isset($_POST['lon']) && isset($_POST['lat'])){
		if(strlen($_POST['lon'])!=0 && strlen($_POST['lat'])!=0){
			if(is_numeric($_POST['lon']) && is_numeric($_POST['lat'])){
				add_place($_POST['lon'],$_POST['lat']);
			}
		}
		
	}
	else if(isset($_POST['lon_edit']) && isset($_POST['lat_edit']) && isset($_POST['id_edit'])){
		if(strlen($_POST['lon_edit'])!=0 && strlen($_POST['lat_edit'])!=0 && strlen($_POST['id_edit'])!=0){
			if(is_numeric($_POST['id_edit']) && is_numeric($_POST['lon_edit']) && is_numeric($_POST['lat_edit'])){
				edit_place($_POST['id_edit'],$_POST['lon_edit'],$_POST['lat_edit']);
			}
		}
	}
	Storage::instance()->content = template('places');
	
});

Slim::get('/orgmanagement',function(){
	if(isset($_GET['id'])){
		if(strlen($_GET['id'])!=0){
			if(is_numeric($_GET['id'])){
				delete_organization($_GET['id']);
			}
		}
	}
	unset($_GET['id']);
	Storage::instance()->content = template('orgmanagement');
});
Slim::post('/orgmanagement',function(){
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
	
});



