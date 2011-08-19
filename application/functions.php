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

function db()
{
    return Storage::instance()->db;
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
function has_submenu($menuid)
{
    $sql = "SELECT id FROM menu WHERE parent_id = '".$menuid."'";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute();
    $a = $statement->fetchAll();  
    return (count($a) > 0);
}
function read_submenu()
{
    $sql = "SELECT id,name,short_name,parent_id FROM menu WHERE parent_id != 0 ORDER BY parent_id,id;";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute();
    $items = $statement->fetchAll();
    $submenus = array();
    foreach ($items AS $item)
    	$submenus[$item['parent_id']][] = $item;
    return $submenus;
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
function read_news($limit = false,$from = 0,$news_id = false)
{
    if($news_id)
    {
	$sql = "SELECT * FROM news WHERE id = :news_id ORDER BY published_at DESC";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(':news_id' => $news_id));
    }
    else
    {
	$sql = "SELECT * FROM news ORDER BY published_at DESC" . ($limit ? " LIMIT " . $from . "," . $limit : NULL);
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute();
    }
    return $statement->fetchAll();
}

function add_news($title, $body, $filedata, $tags)
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
	add_tag_connector('news',Storage::instance()->db->lastInsertId(),$tags);
    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/news") . "' />";
    return ($exec) ? $metarefresh : "couldn't insert into database";
}

function update_news($id, $title, $body, $filedata, $tags)
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
	fetch_db("DELETE FROM tag_connector WHERE news_id=$id");
	add_tag_connector('news',$id,$tags);
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
	fetch_db("DELETE FROM tag_connector WHERE news_id=$id");
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
    if($field != "news" && $field != "proj" && $field != "org")
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
    if ( $field != "news" AND $field != "proj" AND $field != "org" )
        exit("incorrect field");

    empty($tag_ids) AND exit("tag ids are empty");

    foreach ( $tag_ids as $tag_id )
    {
        $sql = "INSERT INTO `opentaps`.`tag_connector` (`tag_id`, `".$field."_id`) VALUES (:tag_id, :f_id);";
        $statement = Storage::instance()->db->prepare($sql);
        $exec = $statement->execute(array(':f_id' => $f_id, ':tag_id' => $tag_id));
        if ( !$exec )
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
function upload_files($files_data, $file_destination, $files_names = NULL, $restrictions = NULL)
{
    if (count($files_data) > 0)
    {
        $i = 0;
        foreach ($files_data AS $file)
        {
            $file_size = true;
            $file_name = true;
            $file_type = true;
            if ($restrictions != NULL AND is_array($restrictions) AND count($restrictions) > 0)
            {
                if (array_key_exists('size', $restrictions) AND is_array($restrictions['size']))
                {
                    $sizes = $restrictions['size'];
                    if (is_string($sizes[0]))
                        switch (trim($sizes[0]))
                        {
                            case '=':
                                {
                                    if ($file['size'] != $sizes[1])
                                        $file_size = false;
                                }
                                break;
                            case '>':
                                {
                                    if ($file['size'] <= $sizes[1])
                                        $file_size = false;
                                }
                                break;
                            case '<':
                                {
                                    if ($file['size'] >= $sizes[1])
                                        $file_size = false;
                                }
                                break;
                            case '<=':
                                {
                                    if ($file['size'] > $sizes[1])
                                        $file_size = false;
                                }
                                break;
                            case '>=':
                                {
                                    if ($file['size'] < $sizes[1])
                                        $file_size = false;
                                }
                                break;
                            default:
                                $file_size = true;
                        }
                }
                if (array_key_exists('name', $restrictions) AND is_array($restrictions['name']))
                {
                    $names = $restrictions['name'];
                    if (in_array($file['name'], $names))
                    {
                        $file_name = false;
                    }
                }
                if (array_key_exists('type', $restrictions) AND is_array($restrictions['type']))
                {
                    $types = $restrictions['type'];
                    if (in_array($file['type'], $types))
                    {
                        $file_type = false;
                    }
                }
            }
	
            if ($file_type AND $file_name AND $file_size AND $file['error'] == 0)
            {
            	
            	
               move_uploaded_file($file['tmp_name'],( (substr($file_destination, strlen(trim($file_destination)) - 1) == '/' OR substr($file_destination, strlen(trim($file_destination)) - 1) == '\\') ? trim($file_destination) : trim($file_destination) . '/' ) . basename(( isset($files_names[$i]) AND !empty($files_names[$i]) ) ? trim($files_names[$i]) : trim($file['name']) ) );
               
            }
            $i++;
        }
    }
    else
        return false;
}


function add_place($lon,$lat,$place_name,$region,$raion){
	$sql = "INSERT INTO places (longitude,latitude,name,region_id,raion_id) VALUES(:lon,:lat,:name,:region,:raion)";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':lon' => $lon,
		':lat' => $lat,
		':name' => $place_name,
		':region' => $region,
		':raion' => $raion
	));
}
function edit_place($id,$lon,$lat,$place_name,$region,$raion){
	$sql = "UPDATE places SET longitude=:lon,latitude=:lat,name=:place_name,region_id=:region,raion_id=:raion WHERE id=:id LIMIT 1;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':lon' => $lon,
		':lat' => $lat,
		':place_name' => $place_name,
		':region' => $region,
		':raion' => $raion,
		':id' => $id
	));
}
function delete_place($id){
	$sql = "DELETE FROM places WHERE id=:id LIMIT 1;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
}


/*=======================================================Admin Regions 	============================================================*/
function add_region($name,$region_info,$region_projects_info,$city,$population,$squares,$settlement,$villages,$districts)
{
	$sql = "INSERT INTO regions(name,region_info,projects_info,city,population,square_meters,settlement,villages,districts) 
				VALUES(:name,:region_info,:region_projects,:city,:population,:squares,:settlement,:villages,:districts)";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':name' => $name,
		':region_info' => $region_info,
		':region_projects' => $region_projects_info,
		':city' => $city,
		':population' => $population,
		':squares' => $squares,
		':settlement' => $settlement,
		':villages' => $villages,
		':districts' => $districts
	));
	

}

function delete_region($id)
{
	$sql = "DELETE FROM regions WHERE id=:id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));

}

function get_region($id)
{
	$sql = "SELECT * FROM regions WHERE id=:id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function update_region($id,$name,$region_info,$region_projects_info,$city,$population,$squares,$settlement,$villages,$districts)
{
$sql = "UPDATE regions SET name=:name,region_info=:region_info,projects_info=:region_projects,city=:city,population=:population,square_meters=:squares,
			settlement=:settlement,villages=:villages,districts=:districts WHERE id=:id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id,
		':name' => $name,
		':region_info' => $region_info,
		':region_projects' => $region_projects_info,
		':city' => $city,
		':population' => $population,
		':squares' => $squares,
		':settlement' => $settlement,
		':villages' => $villages,
		':districts' => $districts
	));

}



/*===================================================	  Regions Fontpage	===============================*/
function region_total_budget($region_id)
{
	$total_budget = fetch_db("SELECT SUM(budget) AS total_budget FROM projects WHERE region_id = $region_id;");
	$total_budget = number_format($total_budget[0]['total_budget']);
	
	return $total_budget;	
}

//projects


function read_projects($project_id = false)
{
    if($project_id)
    {
        $sql = "SELECT * FROM projects WHERE id = :id";
        $statement = Storage::instance()->db->prepare($sql);
        $statement->execute(array(':id' => $project_id));
        return $statement->fetch(PDO::FETCH_ASSOC);    
    }

    $sql = "SELECT * FROM projects ORDER BY start_at";
    $statement = Storage::instance()->db->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();    
}


function add_project($title, $desc, $budget, $district, $city, $grantee, $sector, $start_at, $end_at, $info, $tag_ids, $org_ids)
{
    $back = "<br /><a href=\"" . href("admin/projects/new") . "\">Back</a>";

    $fields = array();
    $fields[] = ( strlen($title) < 4 ) ? 'title' : NULL;
    $fields[] = ( strlen($desc) < 4 ) ? 'description' : NULL;
    $fields[] = ( strlen($budget) < 4 ) ? 'budget' : NULL;
    $fields[] = ( strlen($district) < 4 ) ? 'district' : NULL;
    $fields[] = ( strlen($city) < 4 ) ? 'city' : NULL;
    $fields[] = ( strlen($grantee) < 4 ) ? 'grantee' : NULL;
    $fields[] = ( strlen($sector) < 4 ) ? 'sector' : NULL;
    $fields[] = ( strlen($start_at) < 4 ) ? 'start_at' : NULL;
    $fields[] = ( strlen($end_at) < 4 ) ? 'end_at' : NULL;
    $fields[] = ( strlen($info) < 4 ) ? 'info' : NULL;

    $f = implode(", ", $fields);

    $fields_new = array();
    foreach ( $fields as $field )
    	if ( $field != NULL )
    		$fields_new[] = $field;

    $fields = $fields_new;

    if ( count($fields) > 0 )
    	return $f . " too short" . $back;

    $sql = "
    	INSERT INTO `opentaps`.`projects` (
    		title,
    		description,
    		budget,
    		district,
    		city,
    		grantee,
    		sector,
    		start_at,
    		end_at,
    		info
    	)
    	VALUES(
    		:title,
    		:description,
    		:budget,
    		:district,
    		:city,
    		:grantee,
    		:sector,
    		:start_at,
    		:end_at,
    		:info
    	);
    ";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
	':title' => $title,
    	':description' => $desc,
    	':budget' => $budget,
    	':district' => $district,
    	':city' => $city,
    	':grantee' => $grantee,
    	':sector' => $sector,
    	':start_at' => $start_at,
    	':end_at' => $end_at,
    	':info' => $info
    ));

    $last_insert_id = Storage::instance()->db->lastInsertId();

    foreach ( $org_ids as $org_id )
    {
	$query = "INSERT INTO `project_organizations` ( project_id, organization_id ) VALUES( :project_id, :organization_id );";
	$query = Storage::instance()->db->prepare($query);
	$query = $query->execute(array(':project_id' => $last_insert_id, ':organization_id' => $org_id));
    }

    if ( !add_tag_connector('proj', $last_insert_id, $tag_ids) )
        return "tag connection error";

    if ( $exec )
    	Slim::redirect(href("admin/projects"));
    else
    	return "couldn't insert record/database error";
    
}

function update_project($id, $title, $desc, $budget, $district, $city, $grantee, $sector, $start_at, $end_at, $info, $tag_ids, $org_ids)
{
    $back = "<br /><a href=\"" . href("admin/projects/".$id) . "\">Back</a>";

    $fields = array();
    $fields[] = ( strlen($title) < 4 ) ? 'title' : NULL;
    $fields[] = ( strlen($desc) < 4 ) ? 'description' : NULL;
    $fields[] = ( strlen($budget) < 4 ) ? 'budget' : NULL;
    $fields[] = ( strlen($district) < 4 ) ? 'district' : NULL;
    $fields[] = ( strlen($city) < 4 ) ? 'city' : NULL;
    $fields[] = ( strlen($grantee) < 4 ) ? 'grantee' : NULL;
    $fields[] = ( strlen($sector) < 4 ) ? 'sector' : NULL;
    $fields[] = ( strlen($start_at) < 4 ) ? 'start_at' : NULL;
    $fields[] = ( strlen($end_at) < 4 ) ? 'end_at' : NULL;
    $fields[] = ( strlen($info) < 4 ) ? 'info' : NULL;

    $fields_new = array();
    foreach ( $fields as $field )
    	if ( $field != NULL )
    		$fields_new[] = $field;

    $fields = $fields_new;

    $f = implode(", ", array_values($fields));

    if ( count($fields) > 0 )
    	return $f . " too short" . $back;

    $sql = "
    	UPDATE
    		`projects`
    	SET
    		title = :title,
    		description = :description,
    		budget = :budget,
    		district = :district,
    		city = :city,
    		grantee = :grantee,
    		sector = :sector,
    		start_at = :start_at,
    		end_at = :end_at,
    		info = :info
    	WHERE
    		`projects`.`id` =:id;
    	DELETE FROM
    		project_organizations
    	WHERE
    		project_id = :id;
    	DELETE FROM
    		tag_connector
    	WHERE
    		proj_id = :id;
    ";
    $statement = Storage::instance()->db->prepare($sql);

    $exec = $statement->execute(array(
    	':id' => $id,
	':title' => $title,
    	':description' => $desc,
    	':budget' => $budget,
    	':district' => $district,
    	':city' => $city,
    	':grantee' => $grantee,
    	':sector' => $sector,
    	':start_at' => $start_at,
    	':end_at' => $end_at,
    	':info' => $info
    ));

    if (!empty($org_ids))
    {
    	$insert_rows = array();
    	$insert_rows_data['proj_id'] = $id;
        foreach ($org_ids AS $org_id)
        {
            $var_org_id = "org_{$org_id}_id";
            $insert_rows[] = "(:{$var_org_id}, :proj_id)";
            $insert_rows_data[$var_org_id] = $org_id;
        }
        $sql = 'INSERT INTO project_organizations (organization_id, project_id) VALUES ' . implode(', ', $insert_rows) . ';';
        $statement = db()->prepare($sql);
	$result = $statement->execute($insert_rows_data);
    }

    if ( !add_tag_connector('proj', $id, $tag_ids) )
        return "tag connection error";

    if ( $exec )
    	Slim::redirect(href("admin/projects"));
    else
    	return "couldn't update record/database error";
}

function delete_project($id)
{
    if( !is_numeric($id) )
	return "invalid id";

    $sql = "
    		DELETE FROM `projects` WHERE  `projects`.`id` = :id;
    		DELETE FROM tag_connector where proj_id = :id;
		DELETE FROM project_organizations WHERE project_id = :id;
	   ";
    $statement = Storage::instance()->db->prepare($sql);
    $delete = $statement->execute(array(':id' => $id));

    delete_project_data($id);

    if ( $delete )
    	Slim::redirect(href("admin/projects"));
    else
    	return "couldn't delete record/database error";
}

function read_project_data($id)
{
	$query = "SELECT * FROM projects_data WHERE project_id = :id;";
	$query = Storage::instance()->db->prepare($query);
	$query->execute(array(':id' => $id));
	$query = $query->fetchAll();
	empty($query) AND $query = array();
	return $query;
}

function delete_project_data($id)
{
	$sql = "DELETE FROM projects_data WHERE project_id = :id;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(':id' => $id));
}

function add_project_data($project_id, $key, $value)
{
	for ( $i = 0, $c = count($key); $i < $c; $i ++ )
	{
	    if ( !empty($key[$i]) && !empty($value[$i]) )
	    {
		echo $sql = "
		 INSERT INTO `opentaps`.`projects_data` (`key`, `value`, `project_id`) VALUES (:key, :value, :project_id);
		";
		$statement = Storage::instance()->db->prepare($sql);
		$statement->execute(array(':project_id' => $project_id, ':key' => $key[$i], ':value' => $value[$i]));
	    }
	}
}

function get_project_chart_data($id)
{
	//$result = array();
	$v = array();
	$names = array();

	$sql = "
		SELECT
			organizations.name
		FROM 
			`project_organizations`
		INNER JOIN
			`organizations`
		ON
			(`project_organizations`.`organization_id` = `organizations`.`id`)
		WHERE
			project_id = :id;
	";
	$query = db()->prepare($sql);
	$query->execute(array(':id' => $id));

	$results = $query->fetchAll(PDO::FETCH_ASSOC);

	foreach ( $results as $r )
	{
		$v[1][] = 1;
		$names[1][] = str_replace(" ", "+", $r['name']);
	}


	$sql = "
		SELECT
			budget, title
		FROM 
			`projects`
	";
	$query = db()->prepare($sql);
	$query->execute();

	$results = $query->fetchAll(PDO::FETCH_ASSOC);

	$b = FALSE;

	foreach ( $results as $r )
	{
		$i = $v[2][] = (integer) str_replace("$", "", str_replace(",", "", $r['budget']));
		$b OR $b = ( $i > 100 );
		$names[2][] = str_replace(" ", "+", $r['title']);
	}

	if ( $b )
	{
		$max = max($v[2]);
		$depth = 0;
		while ( $max > 100 ):
			$max = $max / 100;
			$depth ++;
		endwhile;
		for ( $i = 0, $n = count($v[2]); $i < $n; $i ++  )
			for ( $j = 0; $j < $depth; $j ++ )
				$v[2][$i] = $v[2][$i] / 100;
	}

	return array($v, $names);
}
/*function down_to_range($n, $range = 100)
{
	if ( $n > $range )
		return down_to_range($n / $range, $range);
	else
		return $n;
}*/






/*================================================	Admin Organizations	============================================*/
function get_organization($id)
{
	$sql = "SELECT * FROM organizations WHERE id=:id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function delete_organization($id){
	$org = get_organization($id);
	$sql = "DELETE FROM organizations WHERE id=:id LIMIT 1;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
	if( file_exists($org['logo']) )
		unlink($org['logo']);
}

function add_organization($name,$description,$projects_info,$city_town,$district,$grante,$sector,$tags,$file)
{
		if(count($file) > 0)
	if( count($file) > 0 AND $file['p_logo']['error'] == 0 ){
		$logo_destination = DIR.'uploads/organization_photos/';
		$logo_name = mt_rand(0,100000000).time().$file['p_logo']['name'];
		upload_files($file,$logo_destination,array(
			$logo_name
		));
		$logo = $logo_destination.$logo_name;
	}
	else{
		$logo = NULL;
	}

	
	$sql = "INSERT INTO organizations (name,description,district,city_town,grante,sector,projects_info,logo) 
					VALUES(:name,:description,:projects_info,:city_town,:district,:grante,:sector,:logo)";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':name' => $name,
		':description' => $description,
		':projects_info' => $projects_info,
		':city_town' => $city_town,
		':district' => $district,
		':grante' => $grante,
		':sector' => $sector,
		':logo' => $logo
	));
	
	add_tag_connector('org',Storage::instance()->db->lastInsertId(),$tags);
}

function edit_organization($id,$name,$info,$projects_info,$city_town,$district,$grante,$sector,$file){
	$org = get_organization($id);
	if( count($file) > 0 AND $file['p_logo']['error'] == 0 ){	
		$logo_destination = DIR.'uploads/organization_photos/';
		$logo_name = mt_rand(0,100000000).time().$file['p_logo']['name'];
		upload_files($file,$logo_destination,array(
			$logo_name
		));
		$logo = $logo_destination.$logo_name;
		if( file_exists($org['logo']) )
			($org['logo']);
	}
	else{
		
		$logo = $org['logo'];
	}
	
	
	$sql = "UPDATE organizations SET name=:name,description=:info,district=:district,city_town=:city_town,
					grante=:grante,sector=:sector,projects_info=:projects_info,logo=:logo WHERE id=:id LIMIT 1;";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':name' => $name,
		':info' => $info,
		':district' => $district,
		':city_town' => $city_town,
		':grante' => $grante,
		':sector' => $sector,
		':projects_info' => $projects_info,
		':id' => $id,
		':logo' => $logo
	));
}

/*===================================================	  Organizations Fontpage	===============================*/
function organization_total_budget($organization_id)
{
	/*$sql = "
		SELECT
			projects.budget
		FROM 
			`project_organizations`
		INNER JOIN
			`projects`
		ON
			(`project_organizations`.`organization_id` = `organizations`.`id`)
		WHERE
			organization_id = :id;
	";
	$query = db()->prepare($sql);
	$query->execute(array(':id' => $organization_id));
	$results = $query->fetchAll(PDO::FETCH_ASSOC);*/
	return 0;
}

function get_organization_chart_data($id)
{
	//$result = array();
	$v = array();
	$names = array();

	$sql = "
		SELECT
			projects.title,
			projects.budget
		FROM 
			`project_organizations`
		INNER JOIN
			`projects`
		ON
			(`project_organizations`.`project_id` = `projects`.`id`)
		WHERE
			organization_id = :id;
	";
	$query = db()->prepare($sql);
	$query->execute(array(':id' => $id));

	$results = $query->fetchAll(PDO::FETCH_ASSOC);

	$b = FALSE;

	foreach ( $results as $r )
	{
		$i = $v[1][] = str_replace("$", "", str_replace(",", "", $r['budget']));
		$b OR $b = ( $i > 100 );
		$names[1][] = str_replace(" ", "+", $r['title']);
	}

	if ( $b )
	{
		$max = max($v[1]);
		$depth = 0;
		while ( $max > 100 ):
			$max = $max / 100;
			$depth ++;
		endwhile;
		for ( $i = 0, $n = count($v[1]); $i < $n; $i ++  )
			for ( $j = 0; $j < $depth; $j ++ )
				$v[1][$i] = $v[1][$i] / 100;
	}

	/*$sql = "
		SELECT
			budget, title
		FROM 
			`projects`
	";
	$query = db()->prepare($sql);
	$query->execute();

	$results = $query->fetchAll(PDO::FETCH_ASSOC);

	*/

	return array($v, $names);
}
