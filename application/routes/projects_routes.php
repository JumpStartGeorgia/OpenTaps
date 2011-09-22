<?php

################################################################ projects view
Slim::get('/project/:unique/', function($unique)
{
	Storage::instance()->show_map = FALSE;
	$sql = "SELECT budget FROM `projects` WHERE lang = '" . LANG . "'";
	$query = db()->prepare($sql);
	$query->execute();

	list($values, $names, $real_values) = get_project_chart_data($unique);

	$query = "SELECT *,(SELECT count(id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique`) AS total_tags
		  FROM tags
		  LEFT JOIN tag_connector ON `tag_unique` = tags.`unique`
		  LEFT JOIN projects ON projects.`unique` = tag_connector.proj_unique
		  WHERE tags.lang = '" . LANG . "' AND projects.lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute();
	$tags = $query->fetchAll(PDO::FETCH_ASSOC);

    	Storage::instance()->content = template('project', array(
    		'project' => read_projects($unique),
    		'data' => read_project_data($unique),
    		'names' => $names,
    		'values' => $values,
    		'real_values' => $real_values,
    		'tags' => $tags
    	));
});


Slim::get('/export/:type/:data/:name/', function($type, $data, $name)
{
        $name = substr(sha1(uniqid(TRUE) . time() . rand()), 0, 5) . '_' . str_replace(' ', '_', strtolower($name)) . '.' . $type;

	switch ($type)
	{
	    case 'png':
        	$headers = array(
        		'Content-Type' => 'image/png',
        		'Content-Disposition' => 'attachment; filename=' . $name
        	);
        	foreach ($headers AS $key => $value)
		    header("{$key}: {$value}");

		$file = fopen(str_replace(' ', '_', base64_decode($data)), 'r');
		fpassthru($file);
		fclose($file);	        
	        break;
	    case 'csv':
        	$headers = array(
        		'Content-Type' => 'text/csv',
        		'Content-Disposition' => 'attachment; filename=' . $name
        	);
        	foreach ($headers AS $key => $value)
		    header("{$key}: {$value}");

                $data = unserialize(base64_decode($data));

		$list = array();
		$list[0] = $data['names'];
		//foreach ( $data['values'] as $key => $value )
		//	$list[1][] = empty($value['budget']) ? $value : $value['budget'];
		$list[1] = $data['values'];

		$fp = fopen(DIR . 'uploads/' . $name, 'w');

		foreach ($list as $fields)
		    fputcsv($fp, $fields);

		fclose($fp);

		$file = fopen(DIR . 'uploads/' . $name, 'r');
		fpassthru($file);
		fclose($file);

		unlink(DIR . 'uploads/' . $name);

	        break;
	}

	exit;	
}
);


################################################################ projects admin routes start
Slim::get('/admin/projects/', function(){
    Storage::instance()->content = userloggedin()
    	? template('admin/projects/all_records', array('projects' => read_projects()))
    	: template('login');
});

Slim::get('/admin/projects/new/', function(){
    $query = "SELECT * FROM organizations WHERE lang = '" . LANG . "';";
    $orgs = fetch_db($query);
    $regions_query = "SELECT * FROM regions WHERE lang = '" . LANG . "'";
    $regions = fetch_db($regions_query);
    $sql_places = "SELECT * FROM places WHERE lang = '" . LANG . "'";
    Storage::instance()->content = userloggedin()
    	? template('admin/projects/new', array(
    		'all_tags' => read_tags(),
    		'organizations' => $orgs,
                'regions' => $regions,
    		'project_types' => config('project_types'),
                'places' => fetch_db($sql_places)
    	 ))
    	: template('login');
});

Slim::get('/admin/projects/:unique/', function($unique){
    if (userloggedin())
    {
	$query = "SELECT * FROM organizations WHERE lang = '" . LANG . "';";
	$orgs = fetch_db($query);

	$query = "SELECT organization_unique FROM project_organizations WHERE project_unique = :unique";
	$query = Storage::instance()->db->prepare($query);
	//$unique = get_unique("projects", $id);
	$query->execute(array(':unique' => $unique));
	$result = $query->fetchAll();
	$this_orgs = array();
	foreach($result as $s)
		$this_orgs[] = $s['organization_unique'];

	$regions_query = "SELECT * FROM regions WHERE lang = '" . LANG . "'";
	$regions = fetch_db($regions_query);

	$sql_places = "SELECT * FROM places WHERE lang = '" . LANG . "'";
	$places = fetch_db($sql_places);
	Storage::instance()->content = template('admin/projects/edit', array
	(
		'project' =>  read_projects($unique),
		'all_tags' => read_tags(),
		'this_tags' => read_tag_connector('proj', $unique),
		'this_orgs' => $this_orgs,
		'organizations' => $orgs,
        	'regions' => $regions,
        	'places' => $places,
		'project_types' => config('project_types')
	));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/projects/:unique/delete/', function($unique){
    Storage::instance()->content = (userloggedin()) ? delete_project($unique) : template('login');
});

Slim::post('/admin/projects/create/', function(){
    empty($_POST['p_tag_uniques']) AND $_POST['p_tag_uniques'] = array();
    empty($_POST['p_orgs']) AND $_POST['p_orgs'] = array();
    Storage::instance()->content = userloggedin()
	    ? add_project(
        	$_POST['p_title'],
        	$_POST['p_desc'],
        	$_POST['p_budget'],
		/*$_POST['p_region'],*/
		$_POST['p_place'],
        	$_POST['p_city'],
        	$_POST['p_grantee'],
        	$_POST['p_sector'],
        	$_POST['p_start_at'],
        	$_POST['p_end_at'],
        	$_POST['p_info'],
        	$_POST['p_tag_uniques'],
        	$_POST['p_tag_names'],
        	$_POST['p_orgs'],
        	$_POST['p_type']
       	     )
	   : template('login');
});

Slim::post('/admin/projects/:unique/update/', function($unique){
    empty($_POST['p_tag_uniques']) AND $_POST['p_tag_uniques'] = array();
    empty($_POST['p_orgs']) AND $_POST['p_orgs'] = array(NULL);
    Storage::instance()->content = userloggedin()
	    ? update_project(
	    	$unique,
        	$_POST['p_title'],
        	$_POST['p_desc'],
        	$_POST['p_budget'],
/*        	$_POST['p_region'],*/
		$_POST['p_place'],
        	$_POST['p_city'],
        	$_POST['p_grantee'],
        	$_POST['p_sector'],
        	$_POST['p_start_at'],
        	$_POST['p_end_at'],
        	$_POST['p_info'],
        	$_POST['p_tag_uniques'],
        	$_POST['p_tag_names'],
        	$_POST['p_orgs'],
        	$_POST['p_type']
       	     )
	   : template('login');
});


Slim::get('/admin/project-tags/:unique/',function($unique){
    if(userloggedin())
    {
	$sql = "SELECT tag_unique FROM tag_connector WHERE proj_unique = :unique;";
        $statement = Storage::instance()->db->prepare($sql);
        //$unique = get_unique("projects", $id);
        $statement->execute(array(':unique' => $unique));
        $r = $statement->fetchAll();
        $tags = array();
        foreach($r as $res)
        {
          $tags[] = $res['tag_unique'];
        }
        //if(empty($tags)) $rags = array();
        Storage::instance()->content = template('admin/projects/project-tags', array(
            'all_tags' => read_tags(),
            'this_tags' => $tags,
            'unique' => $unique
        ));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/project-tags/:unique/update/',function($unique){
    if(userloggedin())
    {
	$sql = "DELETE FROM tag_connector where proj_unique = :unique;";
        $statement = Storage::instance()->db->prepare($sql);
        //$unique = get_unique("projects", $unique);
        $delete = $statement->execute(array(':unique' => $unique));
        add_tag_connector('proj', $unique, $_POST['p_tags']);
        Slim::redirect(href('admin/projects', TRUE));
    }
    else
	Storage::instance()->content = template('login');
});


Slim::get('/admin/project-data/:unique/',function($unique){
    if(userloggedin())
    {
	$r = read_project_data($unique);
        empty($r) AND $r = array(array('key' => NULL, 'value' => NULL, 'project_unique' => $unique, 'id' => NULL));
        Storage::instance()->content = template('admin/projects/edit_data', array('data' => $r, 'project_unique' => $unique));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/project-data/:unique/new/',function($unique){
    if(userloggedin())
        Storage::instance()->content = template('admin/projects/new_data', array('unique' => $unique));
    else
	Storage::instance()->content = template('login');
});
Slim::post('/admin/project-data/:unique/create/',function($unique){
    if(userloggedin())
    {
    	empty($_POST['sidebar']) AND $_POST['sidebar'] = array(FALSE);
	add_project_data($unique, $_POST['project_key'], $_POST['project_sort'], $_POST['sidebar'], $_POST['project_value']);
        Slim::redirect(href('admin/projects', TRUE));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/project-data/:unique/update/',function($unique){
    if(userloggedin())
    { print_r($_POST['sidebar']);die;
	delete_project_data($unique);
	empty($_POST['sidebar']) AND $_POST['sidebar'] = array(FALSE);
        add_project_data($unique, $_POST['project_key'], $_POST['project_sort'], $_POST['sidebar'], $_POST['project_value']);
        Slim::redirect(href('admin/projects', TRUE));
    }
    else
	Storage::instance()->content = template('login');
});
