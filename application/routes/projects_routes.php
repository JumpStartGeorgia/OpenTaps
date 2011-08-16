<?php

################################################################ projects view
Slim::get('/project/:id/', function($id){
	Storage::instance()->show_map = FALSE;
    	Storage::instance()->content = template('project', array('project' => read_projects($id), 'data' => read_project_data($id)));
});




################################################################ projects admin routes start
Slim::get('/admin/projects/', function(){
    Storage::instance()->content = userloggedin()
    	? template('admin/projects/all_records', array('projects' => read_projects()))
    	: template('login');
});

Slim::get('/admin/projects/new/', function(){
    $query = "SELECT * FROM organizations;";
    $orgs = fetch_db($query);
    Storage::instance()->content = userloggedin()
    	? template('admin/projects/new', array('all_tags' => read_tags(), 'organizations' => $orgs))
    	: template('login');
});

Slim::get('/admin/projects/:id/', function($id){
    if ( userloggedin() )
    {
	$query = "SELECT * FROM organizations;";
	$orgs = fetch_db($query);

	$query = "SELECT organization_id FROM project_organizations WHERE project_id = :id";
	$query = Storage::instance()->db->prepare($query);
	$query->execute(array(':id' => $id));
	$result = $query->fetchAll();
	$this_orgs = array();
	foreach($result as $s)
		$this_orgs[] = $s['organization_id'];
	
	Storage::instance()->content = template('admin/projects/edit', array
	(
		'project' => read_projects($id),
		'all_tags' => read_tags(),
		'this_tags' => read_tag_connector('proj', $id),
		'this_orgs' => $this_orgs,
		'organizations' => $orgs
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
        	$_POST['p_district'],
        	$_POST['p_city'],
        	$_POST['p_grantee'],
        	$_POST['p_sector'],
        	$_POST['p_start_at'],
        	$_POST['p_end_at'],
        	$_POST['p_info'],
        	$_POST['p_tags'],
        	$_POST['p_orgs']
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
        	$_POST['p_district'],
        	$_POST['p_city'],
        	$_POST['p_grantee'],
        	$_POST['p_sector'],
        	$_POST['p_start_at'],
        	$_POST['p_end_at'],
        	$_POST['p_info'],
        	$_POST['p_tags'],
        	$_POST['p_orgs']
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
	$sql = "SELECT * FROM projects_data WHERE project_id = :id ORDER BY id;";
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
