<?php

$places = fetch_db("SELECT * FROM places");
$js_places = array();
foreach ($places as $place)
	$js_places[] = '[' . $place['id'] . ', ' . $place['longitude'] . ', ' . $place['latitude'] . ']';
Storage::instance()->js_places = $js_places;

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



/*====================================================		region management	======================================*/
Slim::get('/admin/regions/',function(){
	if(userloggedin()){
		$sql_regions = 'SELECT * FROM regions';
		$sql_raions = 'SELECT * FROM raions';
		Storage::instance()->content = template('admin/regions/regions-management',array(
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
			Storage::instance()->content = template('admin/regions/regions-management',array(
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
				
				/*=======	raion id	 ==========*/
				$sql_raion_region_edit = "SELECT * FROM region_raion_data WHERE id='$id' LIMIT 1;";
				$raion_region_edit = fetch_db($sql_raion_region_edit);
				$raion_region_edit = $raion_region_edit[0];
				$raion_region_edit_id = $raion_region_edit['type_id'];
				
				/*=======	rain	==========*/
				$sql_raion_edit = "SELECT * FROM raions WHERE id='$raion_region_edit_id' LIMIT 1;";
				$raion_edit = fetch_db($sql_raion_edit);
				$raion_edit = $raion_edit[0];
				
				/*=======	region	==========*/
				$region_id = $raion_edit['region_id'];
				$sql_region_edit = "SELECT * FROM regions WHERE id='$region_id' LIMIT 1;";
				$region_edit = fetch_db($sql_region_edit);
				$region_edit = $region_edit[0];
				
			Storage::instance()->content = template('admin/regions/region_edit',array(
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
Slim::get('/admin/regions/add/',function(){
	if(userloggedin()){
		$sql_regions = 'SELECT * FROM regions';
		$sql_raions = 'SELECT * FROM raions';
		Storage::instance()->content = template('admin/regions/region_add',array(
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
});

/*=================================================================== 	User Regions Display	=============================================*/
Slim::get('/regions/:region_id',function($region_id){
	$total_budget = region_total_budget($region_id);
	Storage::instance()->content_name = 'regions';
	Storage::instance()->content = template('regions',array(
		'total_budget' => $total_budget	
	));
	
});
