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

function href($segments = NULL)
{
    return URL . ltrim($segments, '/') . "/";
}

function authenticate($username, $password)
{
    $sql = "SELECT id, username FROM users WHERE username = :username AND password = :password";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute(array(
        ':username' => $username,
        ':password' => sha1($password)
    ));

    return ($statement->columnCount() == 2) ? $statement->fetch(PDO::FETCH_ASSOC) : FALSE;
    //if executed statement returned two columns - username and password, then this function returns fetched statement
}

function userloggedin()
{
    return (isset($_SESSION['id']) && isset($_SESSION['username']) && !empty($_SESSION['username']));
}

								### MENU MANAGEMENT
function read_menu($parent_id = 0, $lang = null)
{
    $sql = "SELECT id,name,short_name FROM menu WHERE parent_id = :parent_id";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute(array(':parent_id' => $parent_id));
    return $statement->fetchAll();    
}

function add_menu($name, $short_name, $parent_id)
{
    if( strlen($name) < 2 )
	return false;

    $sql = "INSERT INTO  `opentaps`.`menu` (`parent_id`, `name`, `short_name`) VALUES(:parent_id, :name, :short_name)";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':name' => $name,
 	':short_name' => $short_name,
 	':parent_id' => $parent_id
    ));

    return ($exec) ? true : false;
}

function update_menu($id, $name, $short_name, $parent_id)
{
    if( strlen($name) < 2 || !is_numeric($id) )
	return false;

    $sql = "UPDATE `menu` SET  `parent_id` =  :parent_id, `short_name` =  :short_name, `name` =  :name WHERE  `menu`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':id' => $id,
 	':short_name' => $short_name,
 	':name' => $name,
 	':parent_id' => $parent_id
    ));

    return ($exec) ? true : false;
}

function delete_menu($id)
{
    if( !is_numeric($id) )
	return false;

    $sql = "DELETE FROM `opentaps`.`menu` WHERE  `menu`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':id' => $id
    ));

   return ($exec) ? true : false;
}
								### NEWS MANAGEMENT
function read_news($limit = false, $news_id = false)
{
    if($news_id)
    {
	$sql = "SELECT * FROM news WHERE id = :news_id ORDER BY published_at DESC";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(':news_id' => $news_id));
    }
    else
    {
	$sql = ( $limit ) ? "SELECT * FROM news ORDER BY published_at DESC LIMIT ".$limit
	                  : "SELECT * FROM news ORDER BY published_at DESC";
	$arr = ( $limit ) ? array(':limit' => $limit) : null;
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute($arr);
    }
    return $statement->fetchAll();
}

function add_news($title, $body, $filedata)
{
    if( strlen($title) < 3 || strlen($body) < 11 )
	return "either title or body is too short";

    $up = image_upload( $filedata );
    if( substr($up, 0, 8) != "uploads/" && $up != "" )		//return if any errors
        return $up;

    $sql = "INSERT INTO  `opentaps`.`news` (`title`, `body`, `published_at`, `image`) VALUES(:title, :body, :published_at, :image)";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':title' => $title,
 	':body' => $body,
 	':published_at' => date("Y-m-d H:i"),
 	':image' => $up
    ));

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/news") . "' />";
    return ($exec) ? $metarefresh : "couldn't insert into database";
}

function update_news($id, $title, $body, $filedata)
{
    if( strlen($title) < 3 || strlen($body) < 11 || !is_numeric($id) )
	return "either title or body is too short, or invalid id";

    $up = image_upload( $filedata ); 
    if( substr($up, 0, 8) != "uploads/" && $up != "" )			//return if any errors
	return $up;
    elseif( $up == "" )
    {
        $sql = "UPDATE  `opentaps`.`news` SET  `title` =  :title, `body` =  :body WHERE  `news`.`id` =:id";
        $data = array(
            ':id' => $id,
 	    ':title' => $title,
 	    ':body' => $body
        );
    }
    else
    {
        delete_image($id);
        $sql = "UPDATE  `opentaps`.`news` SET  `title` =  :title, `image` =  :image, `body` =  :body WHERE  `news`.`id` =:id";
        $data = array(
            ':id' => $id,
 	    ':title' => $title,
 	    ':body' => $body,
 	    ':image' => $up
        );
    }
    
    $statement = Storage::instance()->db->prepare($sql);
    $exec = $statement->execute($data);

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/news") . "' />";
    return ($exec) ? $metarefresh : "couldn't update record/database error";
}

function delete_news($id)
{
    if( !is_numeric($id) )
	return false;

    delete_image($id);

    $sql = "DELETE FROM `opentaps`.`news` WHERE  `news`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':id' => $id
    ));

   return ($exec) ? true : false;
}

function image_upload($filedata)
{
    if($filedata['size'] > 0)
       if( ($filedata['type'] == "image/jpeg" || $filedata['type'] == "image/pjpeg" ||
            $filedata['type'] == "image/gif"  || $filedata['type'] == "image/png")  && $filedata['size'] / 1024 < 2049 )
       {
           $path = "uploads/";
           $name = mt_rand(0,1000) . $filedata['name'];
           if( file_exists($path . $name) )
               $name = mt_rand(0,99999) . $name;
           $upload = move_uploaded_file($filedata["tmp_name"], $path . $name);
           if( !$upload )
               return "file is valid but upload failed";
           return $path . $name;
       }
       else
           return "uploaded file is not an image or file size exceeds 2MB";
    else
        return "";
}
function delete_image($news_id)
{
    $sql = "SELECT image FROM news WHERE id = :news_id";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute(array(':news_id' => $news_id));
    $image = $statement->fetch(PDO::FETCH_ASSOC);
    if( file_exists($image['image']) )
        unlink($image['image']);
}
function view_image($news_id)
{
    $sql = "SELECT image FROM news WHERE id = :news_id";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute(array(':news_id' => $news_id));
    $image = $statement->fetch(PDO::FETCH_ASSOC);
    return ( file_exists($image['image']) ) ? URL . $image['image'] : false;
}


								### TAGS MANAGEMENT
function read_tags($tag_id = false)
{
    if($tag_id)
    {
        $sql = "SELECT * FROM tags WHERE id = :id";
        $statement = Storage::instance()->db->prepare($sql);
        $statement->execute(array(':id' => $tag_id));
        return $statement->fetch(PDO::FETCH_ASSOC);    
    }

    $sql = "SELECT * FROM tags";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();    
}

function read_tag_connector($field, $id)
{
    if($field != "don" && $field != "proj" && $field != "org")
        return array();

    $sql = "SELECT tag_id FROM tag_connector WHERE ".$field."_id = ".$id;
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute();
    $r = $statement->fetchAll();
    $result = array();
    foreach($r as $s)
    {
        $result[] = $s['tag_id'];
    }
    return $result;
}
function add_tag_connector($field, $f_id, $tag_ids)
{
    if($field != "don" && $field != "proj" && $field != "org")
        return false;

    foreach($tag_ids as $tag_id)
    {
        $sql = "INSERT INTO  `opentaps`.`tag_connector` (`".$field."_id`, `tag_id`) VALUES(:f_id, :tag_id)";
        $statement = Storage::instance()->db->prepare($sql);
        $exec = $statement->execute(array(
 	    ':f_id' => $f_id,
 	    ':tag_id' => $tag_id
        ));
        if(!$exec)
            return false;
    }

    return true;
}

function add_tag($name)
{
    $back = "<br /><a href=\"" . href("admin/tags/new") . "\">Back</a>";

    if( strlen($name) < 2 )
	return "name too short".$back;

    $sql = "INSERT INTO  `opentaps`.`tags` (`name`) VALUES(:name)";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':name' => $name
    ));

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/tags") . "' />";
    return ($exec) ? $metarefresh : "couldn't insert into database".$back;
}

function update_tag($id, $name)
{
    $back = "<br /><a href=\"" . href("admin/tags/".$id) . "\">Back</a>";

    if( strlen($name) < 2 || !is_numeric($id) )
	return "name too short or invalid id" . $back;

    $sql = "UPDATE `tags` SET  `name` =  :name WHERE  `tags`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
        ':id' => $id,
 	':name' => $name
    ));

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/tags") . "' />";
    return ($exec) ? $metarefresh : "couldn't update record/database error" . $back;
}

function delete_tag($id)
{
    if( !is_numeric($id) )
	return "invalid id";

    $sql = "DELETE FROM `opentaps`.`tags` WHERE  `tags`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':id' => $id
    ));

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/tags") . "' />";
    return ($exec) ? $metarefresh : "couldn't delete record/database error";
}


						################################ IRAKLI'S FUNCTIONS
function fetch_db($sql)
{
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
	$result = $statement->fetchAll();
	return empty($result) ? array() : $result;
}

function add_place($lon,$lat){
	$sql = "INSERT INTO places(longitude,latitude) VALUES('$lon','$lat')";
	$statement = Storage::instance()->db->prepare($sql);
	$exec = $statement->execute();
	echo "<META HTTP-EQUIV='Refresh' Content='0; URL=".URL."places'>";
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
	$sql = "UPDATE places SET longitude='$lon',latitude='$lat' WHERE id='$id' ";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
	echo "<META HTTP-EQUIV='Refresh' Content='0; URL=".URL."places'>";
}

function delete_place($id){
	$sql = "DELETE FROM places WHERE id='$id'";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
	echo "<META HTTP-EQUIV='Refresh' Content='0; URL=".URL."places'>";
}


function list_organizations(){
	$i=0;
	$results = fetch_db("SELECT * FROM organizations");
	if(count($results) == 0)echo "<h2>No organizations</h2>";
	else foreach($results as $result){
		$i++;
		echo "<tr>
			<td><div style='border:1px solid #000;'>".$i."</div></td>
			<td><div style='border:1px solid #000;'>".$result['org_name']."</div></td>
			<td><div style='border:1px solid #000;'>".$result['org_description']."</div></td>
			<td><div style='border:1px solid #000;'><a href='javascript:show_org_edit(".$result['id'].",&#39;".$result['org_name']."&#39;,&#39;".$result['org_description']."&#39;);'>Edit</a></div></td>
			<td><div style='border:1px solid #000;'><a href='?id=".$result['id']."'>Delete</a></div></td>
		</tr>";	
	}
}

function delete_from_db($table,$id){
	$sql = "DELETE * FROM :table WHERE id=:id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':table' => $table,
		':id' => $id
	));
}

function add_to_db($table,$table_fields,$values){
	$sql = "INSERT INTO :table(:table_fields[0])";
}


function show_organization($id){
    $sql = "SELECT * FROM organizations WHERE id='$id'";
    $results = fetch_db();
    foreach($results as $result){
        echo "<div><center><h2>".$result['org_name']."</h2></center></div>";
        echo "<div><blockquote>".$result['org_description']."</blockquote></div>";
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



//donors

function read_donors($donors_id = false)
{
    if($donors_id)
    {
        $sql = "SELECT * FROM donors WHERE id = :id";
        $statement = Storage::instance()->db->prepare($sql);
        $statement->execute(array(':id' => $donors_id));
        return $statement->fetch(PDO::FETCH_ASSOC);    
    }

    $sql = "SELECT * FROM donors";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();    
}


function add_donors($name, $descr, $tag_ids)
{
    $back = "<br /><a href=\"" . href("admin/donors/new") . "\">Back</a>";

    if( strlen($name) < 2 )
	return "name too short".$back;

    $sql = "INSERT INTO  `opentaps`.`donors` (`don_name`, `don_desc`) VALUES(:name, :descr)";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
 	':name' => $name,
 	':descr' => $descr
    ));

    if(!add_tag_connector('don', Storage::instance()->db->lastInsertId(), $tag_ids))
        return "tag connection error";

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/donors") . "' />";
    return ($exec) ? $metarefresh : "couldn't insert into database".$back;
}

function update_donors($id, $name, $descr, $tag_ids)
{
    $back = "<br /><a href=\"" . href("admin/donors/".$id) . "\">Back</a>";

    if( strlen($name) < 2 || !is_numeric($id) )
	return "name too short or invalid id" . $back;

    $sql = "UPDATE `donors` SET  `don_name` =  :name, `don_desc` =  :descr WHERE  `donors`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
        ':id' => $id,
 	':name' => $name,
 	':descr' => $descr
    ));

    $sql = "DELETE FROM tag_connector where don_id = :id";
    $statement = Storage::instance()->db->prepare($sql);

    $delete = $statement->execute(array(':id' => $id));

    if(!add_tag_connector('don', $id, $tag_ids) OR !$delete)
        return "tag connection error";

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/donors") . "' />";
    return ($exec) ? $metarefresh : "couldn't update record/database error" . $back;
}

function delete_donors($id)
{
    if( !is_numeric($id) )
	return "invalid id";

    $sql = "DELETE FROM `opentaps`.`donors` WHERE  `donors`.`id` =:id";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(':id' => $id));

    $sql = "DELETE FROM tag_connector where don_id = :id";
    $statement = Storage::instance()->db->prepare($sql);
    $delete = $statement->execute(array(':id' => $id));

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/donors") . "' />";
    return ($exec) ? $metarefresh : "couldn't delete record/database error";
}
