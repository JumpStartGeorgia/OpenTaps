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


function fetch_db($sql){
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
	$result = $statement->fetchAll();
	if(count($result)!=0) return $result;
	else return array();
}




function add_place($lon,$lat){
	$sql = "INSERT INTO places(longitude,latitude) VALUES('$lon','$lat')";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
	echo "<META HTTP-EQUIV='Refresh' Content='0; URL=".URL."index.php/places'>";
}

function list_places(){
	$results = fetch_db("SELECT * FROM places");
	if(count($results) == 0) echo "<h2>No places</h2>";
	else foreach($results as $result){
		echo "<br /><div id='".$result['id']."' style='background-color:#CCC;border:1px solid #000;width:300px;height:60px;'><p align='left'><font size='2pt'>Longitude:".$result['longitude']."<br />Latitude:".$result['latitude']."</font></p><p align='right'><font size='2pt'><a href='javascript:showedit(".$result['id'].",".$result['longitude'].",".$result['latitude'].");'>edit</a>&nbsp;<a href='?id=".$result['id']."'>delete</a></font></p></div>";
	}
}

function edit_place($id,$lon,$lat){
	$sql = "UPDATE places SET longitude='$lon',latitude='$lat' WHERE id='$id' ";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
	echo "<META HTTP-EQUIV='Refresh' Content='0; URL=".URL."index.php/places'>";
}

function delete_place($id){
	$sql = "DELETE FROM places WHERE id='$id'";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
	echo "<META HTTP-EQUIV='Refresh' Content='0; URL=".URL."index.php/places'>";
}




function list_donors(){
    $i=0;
	$results = fetch_db("SELECT * FROM donors");
	if(count($results) == 0)echo "<h2>No donors</h2>";
	else{
               echo "<table border='0px' style='font-size:9pt;'>
	<tr><td><center></div></center></td><td><center>Donor</center></td><td><center>Description</center></td></tr>";
        foreach($results as $result){
		$i++;
		echo "<tr>
			<td><div style='border:1px solid #000;'>".$i."</div></td>
			<td><div style='border:1px solid #000;'>".$result['don_name']."</div></td>
			<td><div style='border:1px solid #000;'>".$result['don_description']."</div></td>
			<td><div style='border:1px solid #000;'><a href='javascript:show_don_edit(".$result['id'].",&#39;".$result['don_name']."&#39;,&#39;".$result['don_description']."&#39;);'>Edit</a></div></td>
			<td><div style='border:1px solid #000;'><a href='?id=".$result['id']."'>Delete</a></div></td>
		</tr>";	
        }
    echo "</table>";
    }
}


function delete_donor($id){
	$sql = "DELETE FROM donors WHERE id='$id'";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
}

function add_donor($don_name,$don_desc){
	$sql = "INSERT INTO donors(don_name,don_description) VALUES('$don_name','$don_desc')";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
}

function edit_donor($don_id,$don_name,$don_desc){
	$sql = "UPDATE donors SET don_name='$don_name',don_description='$don_desc' WHERE id='$don_id'";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
}

function list_organizations(){
	$i=0;
	$results = fetch_db("SELECT * FROM organizations");
	if(count($results) == 0)echo "<h2>No organizations</h2>";
	else{
      echo " <table border='0px' style='font-size:9pt;'>
	<tr><td><center></div></center></td><td><center>Organization</center></td><td><center>Description</center></td></tr>";
        foreach($results as $result){
		$i++;
		echo "<tr>
			<td><div style='border:1px solid #000;'>".$i."</div></td>
			<td><div style='border:1px solid #000;'>".$result['org_name']."</div></td>
			<td><div style='border:1px solid #000;'>".$result['org_description']."</div></td>
			<td><div style='border:1px solid #000;'><a href='javascript:show_org_edit(".$result['id'].",&#39;".$result['org_name']."&#39;,&#39;".$result['org_description']."&#39;);'>Edit</a></div></td>
			<td><div style='border:1px solid #000;'><a href='?id=".$result['id']."'>Delete</a></div></td>
		</tr>";	
	}
    echo "</table>";
    }
}



function delete_organization($id){
	$sql = "DELETE FROM organizations WHERE id='$id'";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
}

function add_organization($org_name,$org_desc){
	$sql = "INSERT INTO organizations(org_name,org_description) VALUES('$org_name','$org_desc')";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
}

function edit_organization($org_id,$org_name,$org_desc){
	$sql = "UPDATE organizations SET org_name='$org_name',org_description='$org_desc' WHERE id='$org_id'";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
}


