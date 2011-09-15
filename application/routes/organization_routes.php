<?php

/*============================================================		Organizations Fontpage		====================================================*/
/*Slim::get('/organizations/organization/:id/',function($id){
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
});*/
Slim::get('/organization/:id/',function($id){
	Storage::instance()->show_map = FALSE;
	/*$sql = "SELECT budget FROM `projects`";
	$query = db()->prepare($sql);
	$query->execute();*/

	list($values, $names, $real_values) = get_organization_chart_data($id);
	$query = "SELECT *,(SELECT count(id) FROM tag_connector WHERE tag_connector.tag_id = tags.id) AS total_tags
		  FROM tags WHERE tags.lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute();
	$tags = $query->fetchAll(PDO::FETCH_ASSOC);


    	Storage::instance()->content = template('organization', array(
    		'organization' => get_organization($id),
    		'organization_budget' => organization_total_budget($id),
    		'values' => $values,
    		'names' => $names,
    		'real_values' => $real_values,
    		'tags' => $tags,
		'projects' => get_organization_projects($id)
    	));
    	
});


/*=====================================================	Admin Organizations	  ==================================================*/
Slim::get('/admin/organizations/', function(){
	$sql_organizations = "SELECT * FROM organizations WHERE lang = '" . LANG . "'";
    Storage::instance()->content = userloggedin()
    	? template('admin/organizations/all_records', array('organizations' => fetch_db($sql_organizations)))
    	: template('login');
});

Slim::get('/admin/organizations/new/', function(){
    Storage::instance()->content = userloggedin()
    	? template('admin/organizations/new', array('all_tags' => read_tags()))
    	: template('login');
});

Slim::get('/admin/organizations/:id/', function($id){
    Storage::instance()->content = userloggedin()
    	? template('admin/organizations/edit', array(
    			'organization' => get_organization($id),
    			'all_tags' => read_tags(),
    			'org_tags' => read_tag_connector('org',$id)
    			))
    	: template('login');
});

Slim::get('/admin/organizations/:id/delete/', function($id){
     if(userloggedin()) {
     	delete_organization($id) ;
     	fetch_db("DELETE FROM tag_connector WHERE org_id = $id");
     	Slim::redirect(href('admin/organizations'));
     }
     else Storage::instance()->content = template('login');
});

Slim::post('/admin/organizations/create/', function(){
    empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
   if(userloggedin()){
	     add_organization(
        	$_POST['p_name'],
        	$_POST['p_org_info'],
        	$_POST['p_org_projects_info'],
        	$_POST['p_city_town'],
        	$_POST['p_district'],
        	$_POST['p_grante'],
        	/*$_POST['p_donors'],*/
        	$_POST['p_sector'],
        	$_POST['p_tags'],
        	$_FILES     	
       	     );
       	     Slim::redirect(href('admin/organizations'));
       	}
	else Storage::instance()->content = template('login');
	
});

Slim::post('/admin/organizations/:id/update/', function($id){
    empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
   if(userloggedin()){
	     edit_organization(
	    	$id,
        	$_POST['p_name'],
        	$_POST['p_org_info'],
        	$_POST['p_org_projects_info'],
        	$_POST['p_city_town'],
        	$_POST['p_district'],
        	$_POST['p_grante'],
        	$_POST['p_sector'],
        	$_FILES
       	     );
       	     fetch_db("DELETE FROM tag_connector WHERE org_id = $id");
       	     add_tag_connector('org',$id,$_POST['p_tags']);
       	     Slim::redirect(href('admin/organizations'));
       	     }
	   else Storage::instance()->content = template('login');
});

