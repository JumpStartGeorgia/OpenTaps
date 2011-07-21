<?php

function template($view, $vars = array())
{
    ob_start();
    empty($vars) OR extract($vars);
    require_once DIR . 'application/templates/' . $view . '.php';
    return ob_get_clean();

}

function config($item)
{
    return isset(Storage::instance()->config[$item]) ? Storage::instance()->config[$item] : FALSE;
}

function href($uri)
{
	return URL ."index.php/".  trim($uri, '/');
}

function fetch_db($sql)
{
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
	$result = $statement->fetchAll();
	return empty($result) ? array() : $result;
}

function is_admin()
{
	return (isset($_SESSION['username']) AND !empty($_SESSION['username']));
}


//=======================================================================================================================================


//place management actions
function add_place($lon,$lat){
	$sql = "INSERT INTO places(longitude,latitude) VALUES(:lon,:lat)";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':lon' => $lon,
		':lat' => $lat
	));
	Slim::redirect(href('/places'));
}
function list_places(){
	$sql = "SELECT * FROM places";
	$results = fetch_db($sql);
	if(count($results) == 0) echo "<h2>No places</h2>";
	else foreach($results as $result){
		echo "<br /><div id='".$result['id']."' style='background-color:#CCC;border:1px solid #000;width:300px;height:60px;'><p align='left'><font size='2pt'>Longitude:".$result['longitude']."<br />Latitude:".$result['latitude']."</font></p><p align='right'><font size='2pt'><a href='javascript:showedit(".$result['id'].",".$result['longitude'].",".$result['latitude'].");'>edit</a>&nbsp;<a href='?id=".$result['id']."'>delete</a></font></p></div>";
	}
}
function edit_place($id,$lon,$lat){
	$sql = "UPDATE places SET longitude=:lon,latitude=:lat WHERE id=:id ";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':lon' => $lon,
		':lat' => $lat,
		':id' => $id
	));
	Slim::redirect(href('/places'));
}
function delete_place($id){
	$sql = "DELETE FROM places WHERE id=:id LIMIT 1;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
	Slim::redirect(href('/places'));
}



//project management options
function delete_project($id){
	$sql = "DELETE FROM projects WHERE id=:id LIMIT 1;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
}
function delete_project_data($id){
	$sql = "DELETE FROM projects_data WHERE project_id=:id LIMIT 1;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
}
function add_project($name,$desc){
	$sql = "INSERT INTO projects(title,description) VALUES(:title,:desc)";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':title' => $name,
		':desc' => $desc
	));
}
function edit_project($id,$name,$desc){
	$sql = "UPDATE projects SET title=:title,description=:desc WHERE id=:id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':title' => $name,
		':desc' => $desc,
		':id' => $id
	));
}

//donor management actions
function delete_donor($id){
	$sql = "DELETE FROM donors WHERE id=:id LIMIT 1;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
}
function add_donor($don_name,$don_desc){
	$sql = "INSERT INTO donors(don_name,don_description) VALUES(:don_name,:don_desc)";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':don_name' => $don_name,
		':don_desc' => $don_desc
	));
}
function edit_donor($don_id,$don_name,$don_desc){
	$sql = "UPDATE donors SET don_name=:don_name,don_description=:don_desc WHERE id=:don_id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':don_name' => $don_name,
		':don_desc' => $don_desc,
		':don_id' => $don_id
	));
}



//organization management actions
function delete_organization($id){
	$sql = "DELETE FROM organizations WHERE id=:id LIMIT 1;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
}

function add_organization($org_name,$org_desc){
	$sql = "INSERT INTO organizations (org_name,org_description) VALUES(:org_name,:org_desc)";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':org_name' => $org_name,
		':org_desc' => $org_desc
	));
}

function edit_organization($org_id,$org_name,$org_desc){
	$sql = "UPDATE organizations SET org_name=:org_name,org_description=:org_description WHERE id=:id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':org_name' => $org_name,
		':org_description' => $org_desc,
		':id' => $org_id
	));
}


