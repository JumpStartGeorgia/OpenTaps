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

function fetch_places(){
	$sql = "SELECT * FROM places";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
	$result = $statement->fetchAll();
	if(count($result) != 0) return $result;
	else return false;
}

function add_place($lon,$lat){
	$sql = "INSERT INTO places(longitude,latitude) VALUES('$lon','$lat')";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
}

function list_places(){
	$results = fetch_places();
	foreach($results as $result){
		echo "<br /><div id='".$result['id']."' style='background-color:#CCC;border:1px solid #000;width:300px;height:60px;'><p align='left'><font size='2pt'>Longitude:".$result['longitude']."<br />Latitude:".$result['latitude']."</font></p><p align='right'><font size='2pt'><a href='javascript:showedit(".$result['id'].",".$result['longitude'].",".$result['latitude'].");'>edit</a>&nbsp;<a href='?id=".$result['id']."'>delete</a></font></p></div>";
	}
}

function delete_place($id){
	$sql = "DELETE FROM places where id='$id'";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
}


function edit_place($id,$lon,$lat){
	$sql = "UPDATE places SET longitude='$lon',latitude='$lat' WHERE id='$id' ";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
}


