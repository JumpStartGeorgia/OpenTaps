<?php
/*=================================================================== 	    	Regions Fontpage		=============================================*/
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
