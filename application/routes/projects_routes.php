<?php

################################################################ projects view
Slim::get('/project/:id/', function($id){
	Storage::instance()->show_map = FALSE;
	$sql = "SELECT budget FROM `projects` WHERE lang = '" . LANG . "'";
	$query = db()->prepare($sql);
	$query->execute();

	list($values, $names, $real_values) = get_project_chart_data($id);

	$query = "SELECT *,(SELECT count(id) FROM tag_connector WHERE tag_connector.tag_id = tags.id) AS total_tags
		  FROM tags WHERE tags.lang = '" . LANG . "'";
	$query = db()->prepare($query);
	$query->execute();
	$tags = $query->fetchAll(PDO::FETCH_ASSOC);

    	Storage::instance()->content = template('project', array(
    		'project' => read_projects($id),
    		'data' => read_project_data($id),
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

Slim::get('/admin/projects/:id/', function($id){
    if ( userloggedin() )
    {
	$query = "SELECT * FROM organizations WHERE lang = '" . LANG . "';";
	$orgs = fetch_db($query);

	$query = "SELECT organization_id FROM project_organizations WHERE project_id = :id";
	$query = Storage::instance()->db->prepare($query);
	$query->execute(array(':id' => $id));
	$result = $query->fetchAll();
	$this_orgs = array();
	foreach($result as $s)
		$this_orgs[] = $s['organization_id'];


	$regions_query = "SELECT * FROM regions WHERE lang = '" . LANG . "'";
	$regions = fetch_db($regions_query);

	$sql_places = "SELECT * FROM places WHERE lang = '" . LANG . "'";
	$places = fetch_db($sql_places);
	Storage::instance()->content = template('admin/projects/edit', array
	(
		'project' =>  read_projects($id),
		'all_tags' => read_tags(),
		'this_tags' => read_tag_connector('proj', $id),
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

Slim::get('/admin/projects/:id/delete/', function($id){
    Storage::instance()->content = (userloggedin()) ? delete_project($id) : template('login');
});

Slim::post('/admin/projects/create/', function(){
    empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
    empty($_POST['p_orgs']) AND $_POST['p_orgs'] = array();
    Storage::instance()->content = userloggedin()
	    ? add_project(
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
        	$_POST['p_tags'],
        	$_POST['p_orgs'],
        	$_POST['p_type']
       	     )
	   : template('login');
});

Slim::post('/admin/projects/:id/update/', function($id){
    empty($_POST['p_tags']) AND $_POST['p_tags'] = array();
    empty($_POST['p_orgs']) AND $_POST['p_orgs'] = array(NULL);
    Storage::instance()->content = userloggedin()
	    ? update_project(
	    	$id,
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
        	$_POST['p_tags'],
        	$_POST['p_orgs'],
        	$_POST['p_type']
       	     )
	   : template('login');
});


Slim::get('/admin/project-tags/:id/',function($id){
    if(userloggedin())
    {
	$sql = "SELECT tag_id FROM tag_connector WHERE proj_id = :id;";
        $statement = Storage::instance()->db->prepare($sql);
        $statement->execute(array(':id' => $id));
        $r = $statement->fetchAll();
        $tags = array();
        foreach($r as $res)
        {
          $tags[] = $res['tag_id'];
        }
        //if(empty($tags)) $rags = array();
        Storage::instance()->content = template('admin/projects/project-tags', array(
            'all_tags' => read_tags(),
            'this_tags' => $tags,
            'id' => $id
        ));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/project-tags/:id/update/',function($id){
    if(userloggedin())
    {
	$sql = "DELETE FROM tag_connector where proj_id = :id;";
        $statement = Storage::instance()->db->prepare($sql);
        $delete = $statement->execute(array(':id' => $id));
        add_tag_connector('proj', $id, $_POST['p_tags']);
        Slim::redirect(href('admin/projects'));
    }
    else
	Storage::instance()->content = template('login');
});


Slim::get('/admin/project-data/:id/',function($id){
    if(userloggedin())
    {
	$sql = "SELECT * FROM projects_data WHERE project_id = :id AND lang = '" . LANG . "' ORDER BY id;";
        $statement = Storage::instance()->db->prepare($sql);
        $statement->execute(array(':id' => $id));
        $r = $statement->fetchAll();
        empty($r) AND $r = array(array('key' => NULL, 'value' => NULL, 'project_id' => $id, 'id' => NULL));
        Storage::instance()->content = template('admin/projects/edit_data', array('data' => $r));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/project-data/:id/new/',function($id){
    if(userloggedin())
        Storage::instance()->content = template('admin/projects/new_data', array('id' => $id));
    else
	Storage::instance()->content = template('login');
});
Slim::post('/admin/project-data/:id/create/',function($id){
    if(userloggedin())
    {
	add_project_data($id, $_POST['project_key'], $_POST['project_value']);
        Slim::redirect(href('admin/projects'));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/project-data/:id/update/',function($id){
    if(userloggedin())
    {
	//print_r($_POST);exit;
	delete_project_data($id);

        add_project_data($id, $_POST['project_key'], $_POST['project_value']);
        Slim::redirect(href('admin/projects'));
    }
    else
	Storage::instance()->content = template('login');
});
