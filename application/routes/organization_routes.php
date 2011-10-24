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
Slim::get('/organization/:unique/',function($unique){
	Storage::instance()->show_map = FALSE;

	$query = "SELECT tags.*,(SELECT count(id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique`) AS total_tags
		  FROM tags
		  LEFT JOIN tag_connector ON `tag_unique` = tags.`unique`
		  LEFT JOIN organizations ON `org_unique` = organizations.`unique`
		  WHERE organizations.`unique` = :unique
		  AND tags.lang = '" . LANG . "'
		  AND organizations.lang = '" . LANG . "';";
	$query = db()->prepare($query);
	$query->execute(array(':unique' => $unique));
	$tags = $query->fetchAll(PDO::FETCH_ASSOC);

	$sql = "SELECT * FROM pages_data
		WHERE owner = 'organization' AND owner_unique = :unique AND lang = '" . LANG . "' AND `sidebar` = :sidebar
		ORDER BY `sort`,`unique`;";
	$side_data = fetch_db($sql, array(':unique' => $unique, ':sidebar' => 1));
	$data = fetch_db($sql, array(':unique' => $unique, ':sidebar' => 0));

    	Storage::instance()->content = template('organization', array(
    		'organization' => get_organization($unique, TRUE),
    		'organization_budget' => organization_total_budget($unique),
    		'data' => $data,
    		'side_data' => $side_data,
    		'tags' => $tags,
		'projects' => get_organization_projects($unique),
		'count' => count_organization_project_types($unique)
	));
    	
});


/*=====================================================	Admin Organizations	  ==================================================*/
Slim::get('/admin/organizations/', function(){
	$sql_organizations = "SELECT * FROM organizations WHERE lang = '" . LANG . "'";
    Storage::instance()->content = userloggedin()
    	? template('admin/organizations/all_records', array('organizations' => fetch_db($sql_organizations)))
    	: template('login');
});

Slim::get('/admin/organizations/:unique/', function($unique){
if ($unique == "new")
{
    Storage::instance()->content = userloggedin()
    	? template('admin/organizations/new', array('all_tags' => read_tags()))
    	: template('login');
}
else
{
    is_numeric($unique) OR Slim::redirect(href('admin/organizations', TRUE));
    Storage::instance()->content = userloggedin()
    	? template('admin/organizations/edit', array(
    			'organization' => get_organization($unique),
    			'all_tags' => read_tags(),
    			'org_tags' => read_tag_connector('org', $unique),
			'data' => read_page_data('organization', $unique)
    			))
    	: template('login');
}
});

Slim::get('/admin/organizations/:unique/delete/', function($unique){
     if(userloggedin()) {
     	delete_organization($unique) ;
     	fetch_db("DELETE FROM tag_connector WHERE org_unique = $unique");
     	Slim::redirect(href('admin/organizations', TRUE));
     }
     else Storage::instance()->content = template('login');
});

Slim::post('/admin/organizations/create/', function()
{
    empty($_POST['p_tag_uniques']) AND $_POST['p_tag_uniques'] = array();
    !empty($_POST['record_language']) AND in_array($_POST['record_language'], config('languages')) OR $_POST['record_language'] = LANG;

    if(userloggedin())
    {
	add_organization(
	    $_POST['record_language'],
	    $_POST['p_name'],
	    $_POST['p_type'],
	    $_POST['p_org_info'],
	    $_POST['p_org_projects_info'],
	    $_POST['p_city_town'],
	    $_POST['p_district'],
	    $_POST['p_grante'],
	    /*$_POST['p_donors'],*/
	    $_POST['p_sector'],
	    $_POST['p_tag_uniques'],
	    $_POST['p_tag_names'],
	    (empty($_FILES['p_logo']) ? FALSE : $_FILES['p_logo']),
	    (empty($_POST['data_key']) ? NULL : $_POST['data_key']),
	    (empty($_POST['data_sort']) ? NULL : $_POST['data_sort']),
	    (empty($_POST['data_value']) ? NULL : $_POST['data_value']),
	    (empty($_POST['sidebar']) ? NULL : $_POST['sidebar'])
	);
	Slim::redirect(href('admin/organizations', TRUE));
    }
    else
    {
	Storage::instance()->content = template('login');
    }
	
});

Slim::post('/admin/organizations/update/:unique/', function($unique)
{
    empty($_POST['p_tag_uniques']) AND $_POST['p_tag_uniques'] = array();
    if(userloggedin())
    {
	delete_page_data('organization', $unique);

	empty($_POST['sidebar']) AND $_POST['sidebar'] = NULL;
	empty($_FILES['p_logo']) OR $_FILES['p_logo']['delete'] = (bool)(!empty($_POST['delete_logo']) AND $_POST['delete_logo'] == "yes");

	if (!empty($_POST['data_key']))
	{
	    add_page_data('organization',$unique, $_POST['data_key'], $_POST['data_sort'], $_POST['sidebar'], $_POST['data_value']);
	}

	edit_organization(
	    $unique,
	    $_POST['p_name'],
	    $_POST['p_type'],
	    $_POST['p_org_info'],
	    $_POST['p_org_projects_info'],
	    $_POST['p_city_town'],
	    $_POST['p_district'],
	    $_POST['p_grante'],
	    $_POST['p_sector'],
	    (empty($_FILES['p_logo']) ? FALSE : $_FILES['p_logo']),
	    $_POST['p_tag_uniques'],
	    $_POST['p_tag_names']
	);

	Slim::redirect(href('admin/organizations', TRUE));
    }
    else
    	Storage::instance()->content = template('login');
});

