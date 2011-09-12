<?php

/*$places = fetch_db("SELECT * FROM places");
$js_places = array();
foreach ($places as $place)
	$js_places[] = '[' . $place['id'] . ', ' . $place['longitude'] . ', ' . $place['latitude'] . ',' . $place['project_id'] . ',' . $place['pollution_id'] .']';
Storage::instance()->js_places = $js_places;*/

$news = fetch_db("SELECT n.*,p.longitude,p.latitude FROM news n INNER JOIN places p ON n.place_id = p.id");
foreach( $news as $new )
    $js_news[] = '[' . $new['id'] . ',' . $new['longitude'] . ',' . $new['latitude'] .',"' . $new['title'] . '", new Date("' . $new['published_at'] . '") ]';
Storage::instance()->js_news = $js_news;

$projects = fetch_db("SELECT p.*,pl.longitude,pl.latitude FROM projects p INNER JOIN places pl ON p.place_id = pl.id");
$js_projects[] = '[ new Date("' . date('Y-m-d') . '") ]';
foreach($projects as $project)
	$js_projects[] = '[' . $project['id'] . ', new Date("' . $project['start_at'] . '") , new Date("' . $project['end_at'] . '") , "'. $project['title'] .'", "'. $project['grantee'] .'", "'. $project['budget'] .'", "'. $project['city'] .'","'. $project['type'] .'","'.$project['longitude'] .'","'.$project['latitude'] .'"]';
Storage::instance()->js_projects = $js_projects;

$years_sql = "
    SELECT DISTINCT
        YEAR(start_at) AS start,
        YEAR(end_at) AS end
    FROM
        projects
    ORDER BY
        start_at,
        end_at
    ;
";
$years_res = fetch_db($years_sql);
$years_storage = array();
foreach ($years_res AS $years)
{
    foreach (range($years['start'], $years['end']) AS $year)
        $years_storage[] = $year;
}
Storage::instance()->js_years = array_unique($years_storage);

$types_tmp = array();
$type_img = array('Water Pollution' => 'water-pollution.gif','Sewage' => 'sewage.gif','Water Supply' => 'water-supply.gif','Irrigation' => 'irrigation.gif','Water Quality' => 'water-quality.gif','Water Accidents' => 'water-accidents.gif');
foreach( config('project_types') as $type ){
	if(isset($type_img[$type])){
		$types_tmp[] = array($type,$type_img[$type]);
	}
	else{
		$types_tmp[] = array($type);
	}
}
$types = $types_tmp;
unset($types_tmp);
Storage::instance()->js_types = $types;



/*=====================================================	donors===========================================================*/
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

require_once DIR.'application/routes/organization_routes.php';

require_once DIR.'application/routes/users_routes.php';

require_once DIR.'application/routes/places_routes.php';

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
