<?php
/*=================================================================== Regions Fontpage=============================================*/
Slim::get('/region/:unique/', function($unique){
	Storage::instance()->show_map = FALSE;
	//$unique = get_unique("regions", $id);
	$sql_region_cordinates = "SELECT * FROM region_cordinates WHERE region_unique = '$unique'";

	/*list($values, $names, $real_values) = get_region_chart_data($unique);*/

	$query = "SELECT projects.title,projects.id,projects.`unique` FROM projects
		  LEFT JOIN places ON places.`unique` = projects.place_unique
		  WHERE places.region_unique = :unique AND projects.lang = '" . LANG . "' AND places.lang = '" . LANG . "';";
	$query = db()->prepare($query);
	$query->execute(array(':unique' => $unique));
	$region_projects = $query->fetchAll(PDO::FETCH_ASSOC);

	$sql = "SELECT * FROM pages_data
		WHERE owner = 'region' AND owner_unique = :unique AND lang = '" . LANG . "' AND `sidebar` = :sidebar
		ORDER BY `sort`,`unique`;";
	$side_data = fetch_db($sql, array(':unique' => $unique, ':sidebar' => 1));
	$data = fetch_db($sql, array(':unique' => $unique, ':sidebar' => 0));

    	Storage::instance()->content = template('region', array(
    		'region' => get_region($unique),
    		'region_cordinates' => fetch_db($sql_region_cordinates),
    		'region_budget' => region_total_budget($unique),
    		'projects' => $region_projects,
    		'data' => $data,
    		'side_data' => $side_data
    	));
});




/*========================================================Admin Regions===============================================*/
Slim::get('/admin/regions/', function(){
	$sql_regions = "SELECT * FROM regions WHERE lang = '" . LANG . "'";
    Storage::instance()->content = userloggedin()
    	? template('admin/regions/all_records', array('regions' => fetch_db($sql_regions)))
    	: template('login');
});


Slim::get('/admin/regions/:unique/', function($unique){
    if ($unique != "new")
    {
    	is_numeric($unique) OR Slim::redirect(href('admin/regions', TRUE));
	Storage::instance()->content = userloggedin()
    		? template('admin/regions/edit', array(
    			'region' => get_region($unique),
    			'water_supply' => fetch_db("SELECT * FROM water_supply WHERE region_unique = '{$unique}' LIMIT 1;"),
    			'all_tags' => read_tags(),
    			'data' => read_page_data('region', $unique)
    		  ))
    		: template('login');
    }
    else
    {
	Storage::instance()->content = userloggedin()
		? template('admin/regions/new', array('all_tags' => read_tags()))
		: template('login');
    }

});

Slim::get('/admin/regions/:unique/delete/', function($unique){
     if(userloggedin()) {
     	delete_region($unique) ;
     	Slim::redirect(href('admin/regions', TRUE));
     }
     else Storage::instance()->content = template('login');
});

Slim::post('/admin/regions/create/', function(){
   // empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
   !empty($_POST['record_language']) AND in_array($_POST['record_language'], config('languages')) OR $_POST['record_language'] = LANG;
   if(userloggedin()){
	     add_region(
	        $_POST['record_language'],
        	$_POST['p_name'],
        	$_POST['p_reg_info'],
        	$_POST['p_reg_projects_info'],
        	$_POST['p_city'],
        	$_POST['p_population'],
        	$_POST['p_squares'],
        	$_POST['p_settlement'],
        	$_POST['p_villages'],
        	$_POST['p_districts'],
		$_POST['p_watersupply'],
	        (empty($_POST['data_key']) ? NULL : $_POST['data_key']),
	        (empty($_POST['data_sort']) ? NULL : $_POST['data_sort']),
	        (empty($_POST['data_value']) ? NULL : $_POST['data_value']),
	        (empty($_POST['sidebar']) ? NULL : $_POST['sidebar'])
       	     );
       	     Slim::redirect(href('admin/regions', TRUE));
       	}
	else Storage::instance()->content = template('login');
	
});

Slim::post('/admin/regions/update/:unique/', function($unique){
    empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
    if (userloggedin())
    {
	delete_page_data('region', $unique, LANG);
	if (!empty($_POST['data_key']))
	    add_page_data('region', $unique, $_POST['data_key'], $_POST['data_sort'], $_POST['sidebar'], $_POST['data_value'], LANG);
	update_region(
	    	$unique,
        	$_POST['p_name'],
        	$_POST['p_reg_info'],
        	$_POST['p_reg_projects_info'],
        	$_POST['p_city'],
        	$_POST['p_population'],
        	$_POST['p_squares'],
        	$_POST['p_settlement'],
        	$_POST['p_villages'],
        	$_POST['p_districts'],
		$_POST['p_watersupply']
	);
	Slim::redirect(href('admin/regions', TRUE));
    }
    else Storage::instance()->content = template('login');
});
