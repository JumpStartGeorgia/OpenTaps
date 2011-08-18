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

function add_news($title, $body, $filedata,$tags)
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

function update_news($id, $title, $body, $filedata,$tags)
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
    if($field != "news" && $field != "proj" && $field != "org")
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


//place management actions
/*function add_place($lon,$lat){
	$sql = "INSERT INTO places(longitude,latitude) VALUES(:lon,:lat)";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':lon' => $lon,
		':lat' => $lat
	));
	Slim::redirect(href('/places'));
}*/
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


/*===================================================	region and raion data management	===============================*\/
function delete_region_raion_data($id)
{
	$sql = "DELETE FROM region_raion_data WHERE id=:id LIMIT 1;";	
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':id' => $id
	));
}
function add_region_raion_data($type,$type_id,$parameter,$value)
{
	$sql = "INSERT INTO region_raion_data(type,type_id,field_name,field_value) VALUES(:type,:type_id,:parameter,:value)";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':type' => $type,
		':type_id' => $type_id,
		':parameter' => $parameter,
		':value' => $value
	));
}

function edit_region_raion_data($id,$type,$type_id,$parameter,$value)
{
	$sql = "UPDATE region_raion_data SET type=:type,type_id=:type_id,field_name=:field_name,field_value=:field_value WHERE id=:id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(
		':type' => $type,
		':type_id' => $type_id,
		':field_name' => $parameter,
		':field_value' => $value,
		':id' => $id
	));
}*/


/*=======================================================	Admin Regions 	============================================================*/
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
			settlement=:settlement,villages=:villages,districts=:districts";
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
	unlink($org['logo']);
}

function add_organization($name,$description,$projects_info,$city_town,$district,$grante,$sector,$tags,$file){
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
		unlink($org['logo']);
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



/*===================================================	  Regions Fontpage	===============================*/
function region_total_budget($region_id)
{
	$total_budget = fetch_db("SELECT SUM(budget) AS total_budget FROM projects WHERE region_id = $region_id;");
	$total_budget = number_format($total_budget[0]['total_budget']);
	
	return $total_budget;	
}
/*===================================================	  Organizations Fontpage	===============================*/
function organization_total_budget($organization_id)
{
	//$total_budget = fetch_db("SELECT SUM()")
	return 0;
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
