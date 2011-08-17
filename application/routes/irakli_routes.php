<?php

$places = fetch_db("SELECT * FROM places");
$js_places = array();
foreach ($places as $place)
	$js_places[] = '[' . $place['id'] . ', ' . $place['longitude'] . ', ' . $place['latitude'] . ']';
Storage::instance()->js_places = $js_places;
Storage::instance()->show_map = TRUE;
/*======================================	places management 	====================================*/
Slim::get('/admin/places/',function(){
	Slim::redirect(href('/admin/places/add'));
});	
Slim::get('/admin/places/add/',function(){
    if(userloggedin())
    {
		$sql_regions = 'SELECT * FROM regions';
		$sql_raions = 'SELECT * FROM raions';
	Storage::instance()->content = template('places',array(
		'regions' => fetch_db($sql_regions),
		'raions' => fetch_db($sql_raions),
		'places' => 'add'
	));
    }
    else
	Storage::instance()->content = template('login');
});
Slim::post('/admin/places/add/',function(){
    if(userloggedin())
    {
	if(isset($_POST['region']) && !empty($_POST['region']) && isset($_POST['raion']) && !empty($_POST['raion']) && isset($_POST['place_name']) && !empty($_POST['place_name']) && isset($_POST['lon']) && !empty($_POST['lon']) && isset($_POST['lat']) && !empty($_POST['lat'])){
		add_place($_POST['lon'],$_POST['lat'],$_POST['place_name'],$_POST['region'],$_POST['raion']);
	}
	Slim::redirect(href('admin/places/add'));
    }
    else
	Storage::instance()->content = template('login');
	
});
Slim::get('/admin/places/list/',function(){
	if(userloggedin())
	{
		Storage::instance()->content = template('places',array(
			'places' => 'list'
		));
	}
	else Storage::instance()->content = template('login');
});

Slim::get('/admin/places/list/:id/delete/',function($id){
	if(userloggedin()){
		if(isset($id) && !empty($id))
			delete_place($id);
			
		Slim::redirect(href('admin/places/list'));
	}
	else Storage::instance()->content = template('login');	
});
Slim::post('/admin/places/list/',function(){
	if(userloggedin()){
		if(isset($_POST['id']) && !empty($_POST['id']))
			edit_place($_POST['id'],$_POST['lon'],$_POST['lat'],$_POST['place_name'],$_POST['region'],$_POST['raion']);
		Slim::redirect(href('admin/places/list'));
	}
	else Storage::instance()->content = template('login');
});
Slim::get('/admin/places/list/:id/edit/',function($id){
	if(userloggedin()){
		if(isset($id) && !empty($id)){
			$sql = "SELECT * FROM places WHERE id=$id";
			$sql_regions = 'SELECT * FROM regions';
			$sql_raions = 'SELECT * FROM raions';
			$result = fetch_db($sql);
			Storage::instance()->content = template('places',array(
				'id' => $id,
				'places' => 'edit',
				'place_name' => $result[0]['name'],
				'place_lon' => $result[0]['longitude'],
				'place_lat' => $result[0]['latitude'],
				'regions' => fetch_db($sql_regions),
				'raions' => fetch_db($sql_raions)
			));
		}
	}
	else Storage::instance()->content = template('login');	
});

/*====================================================		region management	======================================*/
/*Slim::get('/admin/regions/',function(){
	if(userloggedin()){
		$sql_regions = 'SELECT * FROM regions';
		$sql_raions = 'SELECT * FROM raions';
		Storage::instance()->content = template('admin/regions/all_records',array(
			'regions' => fetch_db($sql_regions),
			'raions' => fetch_db($sql_raions)
		));		
	}
	else Storage::instance()->content = template('login');
});

Slim::post('/admin/regions/',function(){
	if(userloggedin()){
		$sql_regions = 'SELECT * FROM regions';
		$sql_raions = 'SELECT * FROM raions';
		if(isset($_POST['region']) AND !empty($_POST['region']) AND isset($_POST['raion']) AND !empty($_POST['raion'])){
			$type_id = $_POST['raion'];
			$type_region_id = $_POST['region'];
			$sql_raion_data = "SELECT * FROM region_raion_data WHERE type='raion' AND type_id='$type_id'"; 
			Storage::instance()->content = template('regions',array(
				'raion_data' => fetch_db($sql_raion_data),
				'regions' => fetch_db($sql_regions),
				'raions' => fetch_db($sql_raions),
				'raion_id' => $type_id,
				'region_id' => $type_region_id
			));
		}
		else{
			Storage::instance()->content = template('regions-management',array(
				'regions' => fetch_db($sql_regions),
				'raions' => fetch_db($sql_raions),
				'raion_id' => (isset($_POST['raion']) AND !empty($_POST['raion'])) ? $_POST['raion'] : NULL,
				'region_id' => (isset($_POST['region']) AND !empty($_POST['region'])) ? $_POST['region'] : NULL
			));
		}
		
	}
	else Storage::instance()->content = template('login');
});

Slim::get('/admin/regions/:id/delete/',function($id){
	if(userloggedin()){
		if(isset($id) AND !empty($id))
			delete_region_raion_data($id);
		Slim::redirect(href('admin/regions'));
	}
	else Storage::instance()->content = template('login');
});
Slim::get('/admin/regions/:id/edit/',function($id){
	if(userloggedin()){
		if(isset($id) AND !empty($id)){
				$sql_regions = 'SELECT * FROM regions';
				$sql_raions = 'SELECT * FROM raions';
				
				/*=======	raion id	 ==========*\/
				$sql_raion_region_edit = "SELECT * FROM region_raion_data WHERE id='$id' LIMIT 1;";
				$raion_region_edit = fetch_db($sql_raion_region_edit);
				$raion_region_edit = $raion_region_edit[0];
				$raion_region_edit_id = $raion_region_edit['type_id'];
				
				/*=======	rain	==========*\/
				$sql_raion_edit = "SELECT * FROM raions WHERE id='$raion_region_edit_id' LIMIT 1;";
				$raion_edit = fetch_db($sql_raion_edit);
				$raion_edit = $raion_edit[0];
				
				/*=======	region	==========*\/
				$region_id = $raion_edit['region_id'];
				$sql_region_edit = "SELECT * FROM regions WHERE id='$region_id' LIMIT 1;";
				$region_edit = fetch_db($sql_region_edit);
				$region_edit = $region_edit[0];
				
			Storage::instance()->content = template('region_edit',array(
				'regions' => fetch_db($sql_regions),
				'raions' => fetch_db($sql_raions),
				'region_edit_id' => $region_edit['id'],
				'raion_edit_id' => $raion_edit['id'],
				'edit_parameter' => $raion_region_edit['field_name'],
				'edit_value' => $raion_region_edit['field_value'],
				'edit_id' => $raion_region_edit['id']
			));
		}
	}
	else Storage::instance()->content = template('login');
});
Slim::post('/admin/regions/:id/edit',function(){
	if(userloggedin()){
		if(isset($_POST['id']) AND !empty($_POST['id'])  AND isset($_POST['parameter_name']) AND !empty($_POST['parameter_name']) AND isset($_POST['value_name']) AND !empty($_POST['value_name']))
			if(isset($_POST['raion']) AND !empty($_POST['raion'])){
				edit_region_raion_data($_POST['id'],'raion',$_POST['raion'],$_POST['parameter_name'],$_POST['value_name']);
			}
			else if(isset($_POST['region']) AND !empty($_POST['region']) AND empty($_POST['raion'])){
				edit_region_raion_data($_POST['id'],'region',$_POST['region'],$_POST['parameter_name'],$_POST['value_name']);
			}
		Slim::redirect(href('admin/regions'));
	}
	else Storage::instance()->content = template('login');
});
Slim::get('/admin/regions/add',function(){
	if(userloggedin()){
		$sql_regions = 'SELECT * FROM regions';
		$sql_raions = 'SELECT * FROM raions';
		Storage::instance()->content = template('region_add',array(
			'regions' => fetch_db($sql_regions),
			'raions' => fetch_db($sql_raions)
		));
	}
	else Storage::instance()->content = template('login');
});
Slim::post('/admin/regions/add/',function(){
	if(userloggedin()){
		if(isset($_POST['parameter_name']) AND !empty($_POST['parameter_name']) AND isset($_POST['value_name']) AND !empty($_POST['value_name'])){
			$parameter = $_POST['parameter_name'];
			$value = $_POST['value_name'];
			$region = ( isset($_POST['region']) AND !empty($_POST['region']) ) ? $_POST['region'] : NULL;
			$raion =  ( isset($_POST['raion']) AND !empty($_POST['raion']) ) ? $_POST['raion'] : NULL;
			if($raion != NULL) add_region_raion_data('raion',$raion,$parameter,$value);
			else if($region != NULL AND $raion == NULL) add_region_raion_data('region',$region,$parameter,$value);
			Slim::redirect(href('admin/regions'));
		}
	}
	else Storage::instance()->content = template('login');
});*/




################################################################ projects view
Slim::get('/region/:id/', function($id){
	Storage::instance()->show_map = FALSE;
	$sql_region_cordinates = "SELECT * FROM region_cordinates WHERE region_id='$id'";
    	Storage::instance()->content = template('region', array(
    		'region' => get_region($id),
    		'region_cordinates' => fetch_db($sql_region_cordinates),
    		'region_budget' => region_total_budget($id)
    	));
});




/*========================================================		Admin Regions		===============================================*/
Slim::get('/admin/regions/', function(){
	$sql_regions = 'SELECT * FROM regions';
    Storage::instance()->content = userloggedin()
    	? template('admin/regions/all_records', array('regions' => fetch_db($sql_regions)))
    	: template('login');
});

Slim::get('/admin/regions/new/', function(){
    Storage::instance()->content = userloggedin() ? template('admin/regions/new', array('all_tags' => read_tags())) : template('login');
});

Slim::get('/admin/regions/:id/', function($id){
    Storage::instance()->content = userloggedin()
    	? template('admin/regions/edit', array(
    			'region' => get_region($id),
    			'all_tags' => read_tags()
    			))
    	: template('login');
});

Slim::get('/admin/regions/:id/delete/', function($id){
     if(userloggedin()) {
     	delete_region($id) ;
     	Slim::redirect(href('admin/regions'));
     }
     else Storage::instance()->content = template('login');
});

Slim::post('/admin/regions/create/', function(){
   // empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
   if(userloggedin()){
	     add_region(
        	$_POST['p_name'],
        	$_POST['p_reg_info'],
        	$_POST['p_reg_projects_info'],
        	$_POST['p_city'],
        	$_POST['p_population'],
        	$_POST['p_squares'],
        	$_POST['p_settlement'],
        	$_POST['p_villages'],
        	$_POST['p_districts']
       	     );
       	     Slim::redirect(href('admin/regions'));
       	}
	else Storage::instance()->content = template('login');
	
});

Slim::post('/admin/regions/:id/update/', function($id){
    empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
   if(userloggedin()){
	     update_region(
	    	$id,
        	$_POST['p_name'],
        	$_POST['p_reg_info'],
        	$_POST['p_reg_projects_info'],
        	$_POST['p_city'],
        	$_POST['p_population'],
        	$_POST['p_squares'],
        	$_POST['p_settlement'],
        	$_POST['p_villages'],
        	$_POST['p_districts']
       	     );
       	     Slim::redirect(href('admin/regions'));
       	     }
	   else Storage::instance()->content = template('login');
});









/*=================================================================== 	User Regions Display	=============================================*/
Slim::get('/regions/:region_id',function($region_id){
	$total_budget = region_total_budget($region_id);
	Storage::instance()->content_name = 'regions';
	Storage::instance()->content = template('regions',array(
		'total_budget' => $total_budget	
	));
	
});

/*====================================================================	donors	===========================================================*/
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


/*=====================================================		Admin Organizations	  ==================================================*/
Slim::get('/admin/organizations/', function(){
	$sql_organizations = 'SELECT * FROM organizations';
    Storage::instance()->content = userloggedin()
    	? template('admin/organizations/all_records', array('organizations' => fetch_db($sql_organizations)))
    	: template('login');
});

Slim::get('/admin/organizations/new/', function(){
    Storage::instance()->content = userloggedin() ? template('admin/organizations/new', array('all_tags' => read_tags())) : template('login');
});

Slim::get('/admin/organizations/:id/', function($id){
    Storage::instance()->content = userloggedin()
    	? template('admin/organizations/edit', array(
    			'organization' => get_organization($id),
    			'all_tags' => read_tags()
    			))
    	: template('login');
});

Slim::get('/admin/organizations/:id/delete/', function($id){
     if(userloggedin()) {
     	delete_organization($id) ;
     	Slim::redirect(href('admin/organizations'));
     }
     else Storage::instance()->content = template('login');
});

Slim::post('/admin/organizations/create/', function(){
   // empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
   if(userloggedin()){
	     add_organization(
        	$_POST['p_name'],
        	$_POST['p_org_info'],
        	$_POST['p_org_projects_info'],
        	$_POST['p_city_town'],
        	$_POST['p_district'],
        	$_POST['p_grante'],
        	/*$_POST['p_donors'],*/
        	$_POST['p_sector']
       	     );
       	     Slim::redirect(href('admin/organizations'));
       	}
	else Storage::instance()->content = template('login');
	
});

Slim::post('/admin/organizations/:id/update/', function($id){
    empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
   if(userloggedin()){
	     update_region(
	    	$id,
        	$_POST['p_name'],
        	$_POST['p_reg_info'],
        	$_POST['p_reg_projects_info'],
        	$_POST['p_city'],
        	$_POST['p_population'],
        	$_POST['p_squares'],
        	$_POST['p_settlement'],
        	$_POST['p_villages'],
        	$_POST['p_districts']
       	     );
       	     Slim::redirect(href('admin/organizations'));
       	     }
	   else Storage::instance()->content = template('login');
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
