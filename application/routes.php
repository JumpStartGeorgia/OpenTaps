<?php

$places = fetch_db("SELECT * FROM places");
$js_places = array();
foreach ($places as $place)
	$js_places[] = '[' . $place['id'] . ', ' . $place['longitude'] . ', ' . $place['latitude'] . ']';
Storage::instance()->js_places = $js_places;

Slim::get("/",function(){

});

Slim::get('/login/', function(){
    Storage::instance()->content = template('login', array(
        'text' => 'Lorem ipsum dolor sit amet.'
    ));
});

//places management
Slim::get('/places/',function(){
	if(isset($_GET['id'])){
		if(strlen($_GET['id'])!=0){
			if(is_numeric($_GET['id'])){
				delete_place($_GET['id']);
			}
		}	
	}
	Storage::instance()->content = template('places');
});	
Slim::post('/places/',function(){
	
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

//donors
Slim::get('/donors/',function(){
	$sql = "SELECT * FROM donors;";
	$results = fetch_db($sql);
	return Storage::instance()->content = template('donors', array(
		'donors' => $results
	));
});
Slim::get('/donors/donor/:id/', function($id){
	$sql = "SELECT * FROM donors WHERE id = '$id' LIMIT 1;";
	$result = fetch_db($sql);
	return Storage::instance()->content = template('donor', array(
		'donor' => $result[0]
	));
});

//organizations 
Slim::get('/organizations/organization/:id/',function($id){
	$sql = "SELECT * FROM organizations WHERE id='$id' LIMIT 1;";
	$result = fetch_db($sql);
	return Storage::instance()->content = template('organization',array(
		'organization' => $result[0]
	));
});
Slim::get('/organizations/',function(){
	$sql = "SELECT * FROM organizations";
	$results = fetch_db($sql); 
        Storage::instance()->content = template('organizations',array(
        	'organizations' => $results
        ));
});

//organization management
Slim::get('/orgmanagement/',function(){
	$sql = "SELECT * FROM organizations";
	$results = fetch_db($sql);
	Storage::instance()->content = template('orgmanagement',array(
		'organizations' => $results
	));
});
Slim::get('/orgmanagement/:id/delete/',function($id){
	if(isset($id)) delete_organization($id);
	Slim::redirect(href('/orgmanagement'));
});
Slim::post('/orgmanagement/',function(){
	if(isset($_POST['org_name']) && isset($_POST['org_desc']) && !isset($_POST['org_id'])  )
			add_organization($_POST['org_name'],$_POST['org_desc']);
	elseif(isset($_POST['org_name']) && isset($_POST['org_desc']) && isset($_POST['org_id']) )
			edit_organization($_POST['org_id'],$_POST['org_name'],$_POST['org_desc']);
	Slim::redirect(href('/orgmanagement'));
	
});

//donor management
Slim::post('/donmanagement/',function(){
            if(isset($_POST['don_name']) && isset($_POST['don_desc']) && !isset($_POST['don_id']))
			add_donor($_POST['don_name'],$_POST['don_desc']);
	    else if(isset($_POST['don_name']) && isset($_POST['don_desc']) && isset($_POST['don_id']))
			edit_donor($_POST['don_id'],$_POST['don_name'],$_POST['don_desc']);
	  Slim::redirect(href('/donmanagement'));
});
Slim::get('/donmanagement/',function(){
	$sql = "SELECT * FROM donors";
	$results = fetch_db($sql);
	Storage::instance()->content = template('donmanagement',array(
		'donors' => $results
	));
});
Slim::get('/donmanagement/:id/delete/',function($id){
	if(isset($id)) delete_donor($id);
	Slim::redirect(href('/donmanagement'));
});

//project management
Slim::get('/projmanagement/',function(){
	$sql = "SELECT * FROM projects";
	$results = fetch_db($sql);
	Storage::instance()->content = template('projectmanagement',array(
		'projects' => $results
	));
});
Slim::get('/projmanagement/:id/edit/',function($id){
	$sql = "SELECT * FROM projects";
	$sql1 = "SELECT * FROM projects WHERE id='$id'";
	$results = fetch_db($sql);
	$result = fetch_db($sql1);
	if(isset($id)) Storage::instance()->content = template('projectmanagement',array(
		'id' => $result[0]['id'],
		'proj_name' => $result[0]['title'],
		'proj_desc' => $result[0]['description'],
		'projects' => $results
	));
});
Slim::get('/projmanagement/:id/delete/',function($id){
	if(isset($id)){
		delete_project($id);
		delete_project_data($id);
	}
	Slim::redirect(href('/projmanagement'));
});
Slim::post('/projmanagement/',function(){	
		if(isset($_POST['proj_name']) && isset($_POST['proj_desc']) && !isset($_POST['proj_id']))
			add_project($_POST['proj_name'],$_POST['proj_desc']);		
		else if(isset($_POST['proj_name']) && isset($_POST['proj_desc']) && isset($_POST['proj_id']))
			edit_project($_POST['proj_id'],$_POST['proj_name'],$_POST['proj_desc']);
		Slim::redirect(href('/projmanagement'));
});



