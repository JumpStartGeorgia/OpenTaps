<?php

$places = fetch_db("SELECT * FROM places");
$js_places = array();
foreach ($places as $place)
	$js_places[] = '[' . $place['id'] . ', ' . $place['longitude'] . ', ' . $place['latitude'] . ']';
Storage::instance()->js_places = $js_places;

//places management
Slim::get('/admin/places/',function(){
    if(userloggedin())
    {
	if(isset($_GET['id'])){
		if(strlen($_GET['id'])!=0){
			if(is_numeric($_GET['id'])){
				delete_place($_GET['id']);
			}
		}	
	}
	Storage::instance()->content = template('places');
    }
    else
	Storage::instance()->content = template('login');
});	
Slim::post('/admin/places/',function(){
    if(userloggedin())
    {
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
    }
    else
	Storage::instance()->content = template('login');
	
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
Slim::get('/admin/orgmanagement/',function(){
    if(userloggedin())
    {
	$sql = "SELECT * FROM organizations";
	$results = fetch_db($sql);
	Storage::instance()->content = template('orgmanagement',array(
		'organizations' => $results
	));
    }
    else
	Storage::instance()->content = template('login');
});
Slim::get('/admin/orgmanagement/:id/delete/',function($id){
    if(userloggedin())
    {
	if(isset($id)) delete_organization($id);
	Slim::redirect(href('admin/orgmanagement'));
    }
    else
	Storage::instance()->content = template('login');
});
Slim::post('/admin/orgmanagement/',function(){
    if(userloggedin())
    {
	if(isset($_POST['org_name']) && isset($_POST['org_desc']) && !isset($_POST['org_id'])  )
			add_organization($_POST['org_name'],$_POST['org_desc']);
	elseif(isset($_POST['org_name']) && isset($_POST['org_desc']) && isset($_POST['org_id']) )
			edit_organization($_POST['org_id'],$_POST['org_name'],$_POST['org_desc']);
	Slim::redirect(href('admin/orgmanagement'));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/orgmanagement-new/:id/',function($id){
    if(userloggedin())
    {
	$sql = "SELECT tag_id FROM tag_connector WHERE org_id = :id";
        $statement = Storage::instance()->db->prepare($sql);
        $statement->execute(array(':id' => $id));
        $r = $statement->fetchAll();
        $tags = array();
        foreach($r as $res)
        {
          $tags[] = $res['tag_id'];
        }
        //if(empty($tags)) $rags = array();
        Storage::instance()->content = template('orgmanagement-new', array(
            'all_tags' => read_tags(),
            'this_tags' => $tags,
            'id' => $id
        ));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/orgmanagement-new/:id/update/',function($id){
    if(userloggedin())
    {
	$sql = "DELETE FROM tag_connector where org_id = :id";
        $statement = Storage::instance()->db->prepare($sql);
        $delete = $statement->execute(array(':id' => $id));
        add_tag_connector('org', $id, $_POST['o_tags']);
        Slim::redirect(href('admin/orgmanagement'));
    }
    else
	Storage::instance()->content = template('login');
});

################################################################ donors admin routes start
Slim::get('/admin/donors/', function(){
    Storage::instance()->content = userloggedin() ? template('admin/donors/all_records') : template('login');
});

Slim::get('/admin/donors/new/', function(){
    Storage::instance()->content = userloggedin() ? template('admin/donors/new', array('all_tags' => read_tags())) : template('login');
});

Slim::get('/admin/donors/:id/', function($id){
    Storage::instance()->content = userloggedin()
    	? template('admin/donors/edit', array(
    			'donors' => read_donors($id),
    			'all_tags' => read_tags(),
    			'this_tags' => read_tag_connector('don', $id)
    			))
    	: template('login');
});

Slim::get('/admin/donors/:id/delete/', function($id){
    if(userloggedin())
      if( delete_donors($id) )
	Slim::redirect(href('admin/donors'));
      else
	Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/donors") . "\">Back</a>
	";
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/donors/create/', function(){
    if(userloggedin())
        Storage::instance()->content = add_donors( $_POST['d_name'], $_POST['d_desc'], $_POST['d_tags'] );
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/donors/:id/update/', function($id){
    if(userloggedin())
        Storage::instance()->content = update_donors( $id, $_POST['d_name'], $_POST['d_desc'], $_POST['d_tags'] );
    else
	Storage::instance()->content = template('login');
});
################################################################ donors admin routes end

//project management
Slim::get('/admin/projmanagement/',function(){
    if(userloggedin())
    {
	$sql = "SELECT * FROM projects";
	$results = fetch_db($sql);
	Storage::instance()->content = template('projectmanagement',array(
		'projects' => $results
	));
    }
    else
	Storage::instance()->content = template('login');
});
Slim::get('/admin/projmanagement/:id/edit/',function($id){
    if(userloggedin())
    {
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
    }
    else
	Storage::instance()->content = template('login');
});
Slim::get('/admin/projmanagement/:id/delete/',function($id){
    if(userloggedin())
    {
	if(isset($id)){
		delete_project($id);
		delete_project_data($id);
	}
	Slim::redirect(href('admin/projmanagement'));
    }
    else
	Storage::instance()->content = template('login');
});
Slim::post('/admin/projmanagement/',function(){	
    if(userloggedin())
    {
		if(isset($_POST['proj_name']) && isset($_POST['proj_desc']) && !isset($_POST['proj_id']))
			add_project($_POST['proj_name'],$_POST['proj_desc']);		
		else if(isset($_POST['proj_name']) && isset($_POST['proj_desc']) && isset($_POST['proj_id']))
			edit_project($_POST['proj_id'],$_POST['proj_name'],$_POST['proj_desc']);
		Slim::redirect(href('admin/projmanagement'));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/projmanagement-new/:id/',function($id){
    if(userloggedin())
    {
	$sql = "SELECT tag_id FROM tag_connector WHERE proj_id = :id";
        $statement = Storage::instance()->db->prepare($sql);
        $statement->execute(array(':id' => $id));
        $r = $statement->fetchAll();
        $tags = array();
        foreach($r as $res)
        {
          $tags[] = $res['tag_id'];
        }
        //if(empty($tags)) $rags = array();
        Storage::instance()->content = template('projmanagement-new', array(
            'all_tags' => read_tags(),
            'this_tags' => $tags,
            'id' => $id
        ));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/projmanagement-new/:id/update/',function($id){
    if(userloggedin())
    {
	$sql = "DELETE FROM tag_connector where proj_id = :id";
        $statement = Storage::instance()->db->prepare($sql);
        $delete = $statement->execute(array(':id' => $id));
        add_tag_connector('proj', $id, $_POST['p_tags']);
        Slim::redirect(href('admin/projmanagement'));
    }
    else
	Storage::instance()->content = template('login');
});
