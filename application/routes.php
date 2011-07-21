<?php

$places = fetch_db("SELECT * FROM places");
$js_places = array();
foreach ($places as $place)
	$js_places[] = '[' . $place['id'] . ', ' . $place['longitude'] . ', ' . $place['latitude'] . ']';
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

Slim::get('/donors',function(){
	$sql = "SELECT * FROM donors;";
	$results = fetch_db($sql);
	return Storage::instance()->content = template('donors', array(
		'donors' => $results
	));
});

Slim::get('/donor/:id', function($id){
	$sql = "SELECT * FROM donors WHERE id = '$id' LIMIT 1;";
	$result = fetch_db($sql);
	return Storage::instance()->content = template('donor', array(
		'donor' => $result[0]
	));
});

Slim::get('/donor/:id/delete', function($id){
	$sql = "DELETE FROM donors WHERE id = {$id} LIMIT 1;";
	Storage::instance()->db->exec($sql);
	Slim::redirect('donors');
});

Slim::get('/organization/:id',function($id){
	$sql = "SELECT * FROM organizations WHERE id='$id' LIMIT 1;";
	$result = fetch_db($sql);
	return Storage::instance()->content = template('organization',array(
		'organization' => $result[0]
	));
});

Slim::get('/organizations',function(){
	$sql = "SELECT * FROM organizations";
	$results = fetch_db($sql); 
        Storage::instance()->content = template('organizations',array(
        	'organizations' => $results
        ));
});

Slim::get('/orgmanagement',function(){
	$sql = "SELECT * FROM organizations";
	$results = fetch_db($sql);
	Storage::instance()->content = template('orgmanagement',array(
		'organizations' => $results
	));
});
Slim::get('/orgmanagement/:id/delete',function($id){
	if(isset($id)) delete_organization($id);
	Slim::redirect(href('orgmanagement'));
});

Slim::post('/orgmanagement',function(){
	if(isset($_POST['org_name']) && isset($_POST['org_desc']) && !isset($_POST['org_id'])  ):
			add_organization($_POST['org_name'],$_POST['org_desc']);
	elseif(isset($_POST['org_name']) && isset($_POST['org_desc']) && isset($_POST['org_id']) ):
			edit_organization($_POST['org_id'],$_POST['org_name'],$_POST['org_desc']);
	endif;
	Slim::redirect('orgmanagement');
	
});

Slim::post('/donmanagement',function(){
            if(isset($_POST['don_name']) && isset($_POST['don_desc']) && !isset($_POST['don_id']))
			add_donor($_POST['don_name'],$_POST['don_desc']);
	   else if(isset($_POST['don_name']) && isset($_POST['don_desc']) && isset($_POST['don_id']))
			edit_donor($_POST['don_id'],$_POST['don_name'],$_POST['don_desc']);
		
	
	Storage::instance()->content = template('donmanagement');
});
Slim::get('/donmanagement',function(){
        	if(isset($_GET['id'])){
		if(strlen($_GET['id'])!=0){
			if(is_numeric($_GET['id'])){
				delete_donor($_GET['id']);
			}
		}
    	}
	unset($_GET['id']);
        Storage::instance()->content = template('donmanagement');
});



