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

function href($segments = NULL, $language = FALSE, $hash = NULL)
{
    $href = URL . (empty($segments) ? NULL : trim($segments, '/') . '/');
    $language AND $href .= '?lang=' . LANG;
    $hashhref = NULL;
    empty($hash) OR $hashhref = ((substr($hash, 0, 1) == "#") ? $hash : "#" . $hash);
    return $href . $hashhref;
}

function db()
{
    return Storage::instance()->db;
}


function authenticate($username, $password)
{
    $sql = "SELECT id, username FROM users WHERE username = :username AND password = :password";
    $statement = db()->prepare($sql);
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

function generate_unique($table)
{
	$table = htmlspecialchars(str_replace(";", "", $table));
	$query = "SELECT `unique` from `" . $table . "` ORDER BY `unique` DESC LIMIT 0,1";
	$query = db()->prepare($query);
	$query->execute();
	$query = $query->fetch(PDO::FETCH_ASSOC);
	if (empty($query) OR empty($query['unique']))
		return 1;
	return ($query['unique'] + 1);
}
function get_unique($table, $id)
{
//	$table = htmlspecialchars(str_replace(";", "", $table));
	$query = db()->prepare("SELECT `unique` from `" . $table . "` WHERE id = :id LIMIT 1;");
	$query->execute(array(':id' => $id));
	$result = $query->fetch(PDO::FETCH_ASSOC);
	if (empty($result) OR empty($result['unique']))
		return FALSE;
	return $result['unique'];
}

								### MENU MANAGEMENT
function read_menu($parent_unique = 0, $lang = null, $readhidden = FALSE)
{
    $sql = "SELECT id,name,short_name,`unique` FROM menu WHERE parent_unique = :parent_unique AND lang = '" . LANG . "'
    	   " . ($readhidden ? NULL : " AND hide = '-1' ") . ";";
    $statement = db()->prepare($sql);
    $statement->execute(array(':parent_unique' => $parent_unique));
    return $statement->fetchAll();    
}

function has_submenu($menuunique)
{
    $sql = "SELECT id,`unique` FROM menu WHERE parent_unique = ':menuunique' AND lang = '" . LANG . "'";
    $statement = db()->prepare($sql);
    $statement->execute(array(':menuunique' => $menuunique));
    $a = $statement->fetchAll();  
    return (count($a) > 0);
}
function read_submenu()
{
    $sql = "SELECT id,`unique`,name,short_name,parent_unique FROM menu WHERE parent_unique != 0 AND lang = '" . LANG . "' ORDER BY parent_unique,`unique`;";
    $statement = db()->prepare($sql);
    $statement->execute();
    $items = $statement->fetchAll();
    $submenus = array();
    foreach ($items AS $item)
    	$submenus[$item['parent_unique']][] = $item;
    return $submenus;
}

function get_menu($short_name)
{
    $sql = "SELECT * FROM menu WHERE short_name = :short_name AND lang = '" . LANG . "' LIMIT 1;";
    $stmt = db()->prepare($sql);
    $stmt->execute(array(
            ':short_name' => $short_name
         ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return empty($result) ? array() : $result;
}

function add_menu($name, $short_name, $parent_unique, $title, $text, $hide, $footer)
{
    if( strlen($name) < 2 )
	return false;

    $languages = config('languages');
    $unique = generate_unique("menu");
    foreach ($languages as $lang)
    {
	    $sql = "INSERT INTO  `opentaps`.`menu` (`parent_unique`, `name`, `short_name`, title, text, hide, footer, lang, `unique`)
	    	    VALUES(:parent_unique, :name, :short_name, :title, :text, :hide, :footer, :lang, :unique)";
	    $statement = db()->prepare($sql);

	    $exec = $statement->execute(array(
	 	':name' => $name . ((LANG == $lang) ? NULL : " ({$lang})"),
	 	':short_name' => $short_name,
	 	':parent_unique' => $parent_unique,
	        ':title' => $title,
    	        ':text' => $text,
	        ':hide' => $hide,
	        ':footer' => $footer,
	        ':lang' => $lang,
	        ':unique' => $unique
	    ));

	    $success = (bool)$exec;
    }

    return $success;
}

function update_menu($unique, $name, $short_name, $parent_unique, $title, $text, $hide, $footer)
{
    if( strlen($name) < 2 || !is_numeric($unique) )
	return false;

    $sql = "UPDATE `menu` SET  `parent_unique` =  :parent_unique, `short_name` =  :short_name, `name` =  :name, title=:title, text=:text, hide=:hide, footer=:footer  WHERE  `menu`.`unique` = :unique AND lang = '" . LANG . "'";
    $statement = db()->prepare($sql);

    $exec = $statement->execute(array(
 	':unique' => $unique,
 	':short_name' => $short_name,
 	':name' => $name,
 	':parent_unique' => $parent_unique,
        ':title' => $title,
        ':text' => $text,
        ':hide' => $hide,
        ':footer' => $footer
    ));

    return ($exec) ? true : false;
}

function delete_menu($unique)
{
    if (!is_numeric($unique))
	return false;

    $sql = "DELETE FROM `opentaps`.`menu` WHERE  `menu`.`unique` = :unique;";
    $statement = db()->prepare($sql);

    $exec = $statement->execute(array(':unique' => $unique));

    return ($exec) ? true : false;
}
								### NEWS MANAGEMENT
function read_news($limit = false, $from = 0, $news_unique = false)
{
    if($news_unique)
    {
	$sql = "SELECT * FROM news WHERE `unique` = :news_unique AND lang = '" . LANG . "' ORDER BY published_at DESC";
	$statement = db()->prepare($sql);
	$statement->execute(array(':news_unique' => $news_unique));
    }
    else
    {
	$sql = "SELECT * FROM news WHERE lang = '" . LANG . "'
		ORDER BY published_at DESC" . ($limit ? " LIMIT " . $from . "," . $limit : NULL);
	$statement = db()->prepare($sql);
	$statement->execute();
    }
    return $statement->fetchAll();
}

function read_news_one_page($from, $limit, $type = FALSE)
{
    $sql = "SELECT * FROM news " . ($type ? "WHERE category = :type AND lang = '" . LANG . "'" : "WHERE lang = '" . LANG . "'") . "
    	    ORDER BY published_at DESC LIMIT " . $from . ", " . $limit . "";
    $statement = db()->prepare($sql);
    $data = $type ? array(':type' => $type) : NULL;
    $statement->execute($data);

    return $statement->fetchAll();
}

function add_news($title, $body, $filedata, $category, $place, $tags, $tag_names, $data_key = NULL, $data_sort = NULL, $data_value = NULL, $sidebar = NULL)
{
    if( strlen($title) < 3 || strlen($body) < 11 )
	return "either title or body is too short";

    $up = image_upload( $filedata );
    if( substr($up, 0, 8) != "uploads/" && $up != "" )		//return if any errors
        return $up;

    $languages = config('languages');
    $unique = generate_unique("news");
    foreach ($languages as $lang)
    {
	    $sql = "INSERT INTO  `opentaps`.`news` (`title`, `body`, `published_at`, `image`, category, place_unique, lang, `unique`)
		    VALUES(:title, :body, :published_at, :image, :category, :place, :lang, :unique)";
	    $statement = db()->prepare($sql);

	    $exec = $statement->execute(array(
	 	':title' => $title . ((LANG == $lang) ? NULL : " ({$lang})"),
	 	':body' => $body,
	 	':published_at' => date("Y-m-d H:i"),
	 	':image' => $up,
	        ':category' => $category,
	        ':place' => $place,
	        ':lang' => $lang,
	        ':unique' => $unique
	    ));
	    $success = (bool)$exec;

    }

    add_tag_connector('news', $unique, $tags, $tag_names);

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/news", TRUE) . "' />";
    if ($success)
    {
	if (!empty($data_key))
	    add_page_data('news', $unique, $data_key, $data_sort, $sidebar, $data_value);
	return $metarefresh;
    }
    else
	return "couldn't insert into database";
}

function update_news($unique, $title, $body, $filedata, $category, $place, $tags, $tag_names)
{
    if (strlen($title) < 3 || strlen($body) < 11 || !is_numeric($unique))
	return "either title or body is too short, or invalid id";

    $up = image_upload($filedata); 
    if (substr($up, 0, 8) != "uploads/" && $up != "")			//return if any errors
	return $up;
    elseif ($up == "")
    {
        $sql = "UPDATE  `opentaps`.`news` SET  `title` =  :title, `body` = :body, category = :category, place_unique = :place WHERE  `news`.`unique` = :unique AND news.lang = '" . LANG . "'";
        $data = array(
            ':unique' => $unique,
     	    ':title' =>$title,
            ':body' => $body,
            ':category' => $category,
            ':place' => $place
        );
    }
    else
    {
        delete_image($unique);
        $sql = "UPDATE  `opentaps`.`news` SET  `title` =  :title, `image` =  :image, `body` =  :body, category = :category, place_unique = :place WHERE  `news`.`unique` = :unique AND news.lang = '" . LANG . "'";
        $data = array(
            ':unique' => $unique,
     	    ':title' => $title,
            ':body' => $body,
            ':image' => $up,
            ':category' => $category,
            ':place' => $place
        );
    }
    
    $statement = db()->prepare($sql);
    $exec = $statement->execute($data);
    //$unique = get_unique("news", $id);
    fetch_db("DELETE FROM tag_connector WHERE news_unique = $unique");
    if (!empty($tags) OR !empty($tag_names))
    	add_tag_connector('news', $unique, $tags, $tag_names);
    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/news", TRUE) . "' />";
    return ($exec) ? $metarefresh : "couldn't update record/database error";
}

function delete_news($unique)
{
    if( !is_numeric($unique) )
	return false;

    delete_image($unique);

    //$unique = get_unique("news", $id);
    //print_r(get_uniques_ids("news", $unique));die;
    $sql = "DELETE FROM `opentaps`.`news` WHERE  `news`.`unique` = :unique;
    	    DELETE FROM pages_data WHERE owner = 'news' AND owner_unique = :unique;";
    $statement = db()->prepare($sql);

    $exec = $statement->execute(array(':unique' => $unique));
    fetch_db("DELETE FROM tag_connector WHERE news_unique = '$unique'");
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
function delete_image($news_unique)
{
    $sql = "SELECT image FROM news WHERE `unique` = :news_unique LIMIT 1";
    $statement = db()->prepare($sql);
    $statement->execute(array(':news_unique' => $news_unique));
    $image = $statement->fetch(PDO::FETCH_ASSOC);
    if( file_exists($image['image']) )
        unlink($image['image']);
}
function view_image($news_unique)
{
    $sql = "SELECT image FROM news WHERE `unique` = :news_unique AND lang = '" . LANG . "'";
    $statement = db()->prepare($sql);
    $statement->execute(array(':news_unique' => $news_unique));
    $image = $statement->fetch(PDO::FETCH_ASSOC);
    return ( file_exists($image['image']) ) ? URL . $image['image'] : false;
}


								### TAGS MANAGEMENT
function read_tags($tag_unique = false)
{
    if($tag_unique)
    {
        $sql = "SELECT * FROM tags WHERE `unique` = :unique AND lang = '" . LANG . "' LIMIT 1";
        $statement = db()->prepare($sql);
        $statement->execute(array(':unique' => $tag_unique));
        return $statement->fetch(PDO::FETCH_ASSOC);    
    }

    $sql = "SELECT * FROM tags WHERE lang = '" . LANG . "'";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();    
}

function read_tag_connector($field, $unique)
{
    if($field != "news" && $field != "proj" && $field != "org")
        return array();

    $sql = "SELECT tag_unique FROM tag_connector WHERE " . $field . "_unique = '" . $unique . "'";
    $statement = db()->prepare($sql);
    $statement->execute();
    $r = $statement->fetchAll();
    $result = array();
    foreach($r as $s)
    {
        $result[] = $s['tag_unique'];
    }
    return $result;
}

function add_tag_connector($field, $f_unique, $tag_uniques, $tag_names = NULL)
{
    if ( $field != "news" AND $field != "proj" AND $field != "org" )
        exit("incorrect field");

    empty($tag_uniques) AND empty($tag_names) AND exit("tags are empty");

    if (!empty($tag_names) AND strlen(trim($tag_names)) > 1)
    {
    	if (strpos($tag_names, ',') !== FALSE)
    		$tag_names = explode(',', $tag_names);
    	else
    		$tag_names = array($tag_names);

    	foreach ($tag_names as $tag_name)
    	{
    		$tag_name = trim(htmlspecialchars($tag_name));
    		if ($tag_name == '')
    			continue;
		$query = db()->prepare("SELECT `unique`, id FROM tags WHERE name = :name LIMIT 1");
		$query->execute(array(':name' => $tag_name));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		$success = TRUE;
		if (empty($result))
		{
			if (add_tag($tag_name, FALSE) == TRUE)
			{
				$stmt = db()->prepare("SELECT `unique` FROM tags WHERE name = :name LIMIT 1");
				$stmt->execute(array(':name' => $tag_name));
				$inserted_unique = $stmt->fetch(PDO::FETCH_ASSOC);
				$result['unique'] = $inserted_unique['unique'];
				$success = TRUE;
			}
			else
				$succes = FALSE;
		}
		$success AND !in_array($result['unique'], $tag_uniques) AND $tag_uniques[] = $result['unique'];
	}
    }

    foreach ($tag_uniques as $tag_unique)
    {
        $sql = "INSERT INTO `opentaps`.`tag_connector` (`tag_unique`, `" . $field . "_unique`) VALUES (:tag_unique, :f_unique);";
        $data = array(':f_unique' => $f_unique, ':tag_unique' => $tag_unique);
        $statement = db()->prepare($sql);
        $exec = $statement->execute($data);
        if (!$exec)
            return false;
    }

    return true;
}

function add_tag($name, $redirect = TRUE)
{
    $back = "<br /><a href=\"" . href("admin/tags/new", TRUE) . "\">Back</a>";

    if( strlen($name) < 2 )
	return "name too short" . $back;

    $languages = config('languages');
    $unique = generate_unique("tags");
    foreach ($languages as $lang)
    {
    	$sql = "INSERT INTO  `opentaps`.`tags` (`name`, lang, `unique`) VALUES(:name, :lang, :unique)";
    	$statement = db()->prepare($sql);

    	$exec = $statement->execute(array(
 		':name' => $name . ((LANG == $lang) ? NULL : " ({$lang})"),
 		':lang' => $lang,
	        ':unique' => $unique
    	));
    	$success = (bool)$exec;
    }

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/tags", TRUE) . "' />";
   if ($success)
   	return $redirect ? $metarefresh : TRUE;
   else
	return "couldn't insert into database" . $back;
}

function update_tag($unique, $name)
{
    $back = "<br /><a href=\"" . href("admin/tags/".$unique, TRUE) . "\">Back</a>";

    if( strlen($name) < 2 || !is_numeric($unique) )
	return "name too short or invalid id" . $back;

    $sql = "UPDATE `tags` SET  `name` =  :name WHERE  `tags`.`unique` = :unique AND lang = '" . LANG . "'";
    $statement = db()->prepare($sql);

    $exec = $statement->execute(array(
        ':unique' => $unique,
 	':name' => $name
    ));

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/tags", TRUE) . "' />";
    return ($exec) ? $metarefresh : "couldn't update record/database error" . $back;
}

function delete_tag($unique)
{
    if( !is_numeric($unique) )
	return "invalid id";

    $sql = "DELETE FROM `opentaps`.`tags` WHERE  `tags`.`unique` = :unique";
    $statement = db()->prepare($sql);

    $exec = $statement->execute(array(':unique' => $unique));

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/tags", TRUE) . "' />";
    return ($exec) ? $metarefresh : "couldn't delete record/database error";
}


						################################ IRAKLI'S FUNCTIONS
function fetch_db($sql, $data = NULL)
{
	$statement = db()->prepare($sql);
	$statement->execute($data);
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


function add_place($post){
    $languages = config('languages');
    $unique = generate_unique("places");
    foreach ($languages as $lang)
    {
	$sql = "INSERT INTO places (longitude,latitude,name,region_unique,raion_unique,project_unique,pollution_unique, lang, `unique`)
		VALUES(:lon,:lat,:name,:region,:raion,:project,:pollution, :lang, :unique)";
	$statement = db()->prepare($sql);
	$statement->execute(array(
		':lon' => $post['pl_longitude'],
		':lat' => $post['pl_latitude'],
		':name' => $post['pl_name'] . ((LANG == $lang) ? NULL : " ({$lang})"),
		':region' => isset($post['pl_region']) ? $post['pl_region'] : 0,
		':raion' => 0,
		':project' => 0,
		':pollution' => 0,
		':lang' => $lang,
	        ':unique' => $unique
	));
    }
}
function edit_place($unique,$post)
{
	$sql = "UPDATE places SET
			longitude = :lon,
			latitude = :lat,
			name = :place_name,
			region_unique = :region,
			raion_unique = :raion,
			project_unique = :project,
			pollution_unique = :pollution
		WHERE
			`unique` = :unique
		AND
			lang = '" . LANG . "'
		LIMIT 1;";
	$statement = db()->prepare($sql);
	$statement->execute(array(
		':lon' => $post['pl_longitude'],
		':lat' => $post['pl_latitude'],
		':place_name' => $post['pl_name'],
		':region' => isset($post['pl_region']) ? $post['pl_region'] : 0,
		':raion' => 0,
        	':project' => 0,
        	':pollution' => 0,
		':unique' => $unique
	));
}
function delete_place($unique)
{
	$sql = "DELETE FROM places WHERE `unique` = :unique;";
	$statement = db()->prepare($sql);
	$statement->execute(array(':unique' => $unique));
}


/*=======================================================Admin Regions 	============================================================*/
function add_region($name,$region_info,$region_projects_info,$city,$population,$squares,$settlement,$villages,$districts,$water_supply, $data_key = NULL, $data_sort = NULL, $data_value = NULL, $sidebar = NULL)
{
    $languages = config('languages');
    $unique = generate_unique("regions");
    foreach ($languages as $lang)
    {
	$sql = "INSERT INTO regions(name,region_info,projects_info,city,population,square_meters,settlement,villages,districts, lang, `unique`)
		VALUES(:name,:region_info,:region_projects,:city,:population,:squares,:settlement,:villages,:districts, :lang, :unique)";
	$statement = db()->prepare($sql);
	$exec = $statement->execute(array(
		':name' => $name . ((LANG == $lang) ? NULL : " ({$lang})"),
		':region_info' => $region_info,
		':region_projects' => $region_projects_info,
		':city' => $city,
		':population' => $population,
		':squares' => $squares,
		':settlement' => $settlement,
		':villages' => $villages,
		':districts' => $districts,
		':lang' => $lang,
	        ':unique' => $unique
	));

    }

    //$lastid = Storage::instance()->db->lastInsertId();
    $sql = "INSERT INTO water_supply (text, region_unique)
                        VALUE(:text, :region_unique)";
    $stmt = Storage::instance()->db->prepare($sql);
    $stmt->execute(array(
		':text' => $water_supply,
		':region_unique' => $unique
    ));

    if ($exec AND !empty($data_key))
	add_page_data('region', $unique, $data_key, $data_sort, $sidebar, $data_value);


}

function delete_region($unique)
{
	$sql = "DELETE FROM regions WHERE `unique` = :unique;
		DELETE FROM pages_data WHERE owner = 'region' AND owner_unique = :unique;";
	$statement = db()->prepare($sql);
	$statement->execute(array(':unique' => $unique));
}

function get_region($unique)
{
	$sql = "SELECT * FROM regions WHERE `unique` = :unique AND lang = '" . LANG . "' LIMIT 1";
	$statement = db()->prepare($sql);
	$statement->execute(array(
		':unique' => $unique
	));
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function update_region($unique,$name,$region_info,$region_projects_info,$city,$population,$squares,$settlement,$villages,$districts,$water_supply)
{
	$sql = "UPDATE regions SET
			name = :name,
			region_info = :region_info,
			projects_info = :region_projects,
			city = :city,
			population = :population,
			square_meters = :squares,
			settlement = :settlement,
			villages = :villages,
			districts = :districts
		WHERE `unique` = :unique AND lang = '" . LANG . "'";
	$statement = db()->prepare($sql);
	$statement->execute(array(
		':unique' => $unique,
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

    $sql = "UPDATE water_supply SET text = :text WHERE region_unique = :region_unique AND lang = '" . LANG . "' LIMIT 1;";
    $stmt = Storage::instance()->db->prepare($sql);
    $stmt->execute(array(
                       ':text' => $water_supply,
                       ':region_unique' => $unique
    ));
}



/*===================================================	  Regions Fontpage	===============================*/
function region_total_budget($region_unique)
{
	$total_budget = fetch_db("
				SELECT SUM(budget) AS total_budget FROM projects
				LEFT JOIN places ON projects.place_unique = places.`unique`
				WHERE places.region_unique = $region_unique
			");
	$total_budget = number_format($total_budget[0]['total_budget']);

	return $total_budget;	
}




/*===========================   Users Admin     ============================*/
function delete_user($id)
{
    $sql = "DELETE FROM users WHERE id = :id LIMIT 1;";
    $stmt = db()->prepare($sql);
    $stmt->execute(array(
           ':id' => $id
    ));
}

function add_user($post)
{
    if( isset($post['u_name']) && isset($post['u_pass']) ){
        $sql = "INSERT INTO users(username,password) VALUES(:username,:password)";
        $stmt = db()->prepare($sql);
        $stmt->execute(array(
                           ':username' => $post['u_name'],
                           ':password' => hash('sha1',$post['u_pass'])
                           ));
    }
}

function get_user($id)
{
    $sql = "SELECT * FROM users WHERE id = :id LIMIT 1;";
    $stmt = db()->prepare($sql);
    $stmt->execute(array(
                        ':id' => $id
                       ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return empty($result) ? array() : $result;
}

function update_user($id,$post)
{
    if( isset($post['u_name']) ){
    $sql = "UPDATE users SET username = :username, password = :password WHERE id = :id";
    $stmt = db()->prepare($sql);
    $stmt->execute(array(
                       ':username' => $post['u_name'],
                       ':password' => hash('sha1',$post['u_pass']),
                       ':id' => $id 
                       ));
    }
}


//projects


function read_projects($project_unique = false)
{
    if($project_unique)
    {
        $sql = "
        SELECT
            p.*,
            pl.longitude,
            pl.latitude,
            r.name AS region_name,
            r.`unique` AS region_unique
        FROM projects AS p
        LEFT JOIN places AS pl
            ON p.place_unique = pl.`unique` AND p.lang = pl.lang
        LEFT JOIN regions AS r
            ON pl.region_unique = r.`unique` AND pl.lang = r.lang
        WHERE p.`unique` = :unique AND p.lang = '" . LANG . "'
        ;";
        $statement = db()->prepare($sql);
        $statement->execute(array(':unique' => $project_unique));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return empty($result) ? array() : $result;
    }

    $sql = "SELECT * FROM projects WHERE lang = '" . LANG . "' ORDER BY start_at";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();    
}


function add_project($title, $desc, $budget, $place_unique, $city, $grantee, $sector, $start_at, $end_at, $info, $tag_uniques, $tag_names, $org_uniques, $type, $project_key = NULL, $project_sort = NULL, $project_value = NULL, $sidebar = NULL)
{
    $back = "<br /><a href=\"" . href("admin/projects/new", TRUE) . "\">Back</a>";

    $fields = array();
    (strlen($title) < 4) AND $fields[] = 'title';
  /*$fields[] = (strlen($desc) < 4) ? 'description' : NULL;
    $fields[] = (strlen($budget) < 4) ? 'budget' : NULL;
    $fields[] = (strlen($city) < 4) ? 'city' : NULL;
    $fields[] = (strlen($grantee) < 4) ? 'grantee' : NULL;
    $fields[] = (strlen($sector) < 4) ? 'sector' : NULL;
    $fields[] = (strlen($start_at) < 4) ? 'start_at' : NULL;
    $fields[] = (strlen($end_at) < 4) ? 'end_at' : NULL;
    $fields[] = (strlen($info) < 4) ? 'info' : NULL;*/

    $f = implode(", ", $fields);

    $fields_new = array();
    foreach ( $fields as $field )
    	if ($field != NULL)
    		$fields_new[] = $field;

    $fields = $fields_new;

    if (count($fields) > 0)
    	return $f . " too short" . $back;


    $languages = config('languages');
    $unique = generate_unique("projects");
    foreach ($languages as $lang)
    {
	    $sql = "
	    	INSERT INTO `opentaps`.`projects` (
	    		title,
	    		description,
	    		budget,
	    		region_unique,
	    		city,
	    		grantee,
	    		sector,
	    		start_at,
	    		end_at,
	    		info,
	    		type,
		        place_unique,
		        lang,
		        `unique`
	    	)
	    	VALUES(
	    		:title,
	    		:description,
	    		:budget,
	    		:region_unique,
	    		:city,
	    		:grantee,
	    		:sector,
	    		:start_at,
	    		:end_at,
	    		:info,
	    		:type,
		        :place_unique,
		        :lang,
		        :unique
	    	);
	    ";

	    $statement = db()->prepare($sql);

	    $exec = $statement->execute(array(
	    	':title' => $title . ((LANG == $lang) ? NULL : " ({$lang})"),
	    	':description' => $desc,
	    	':budget' => $budget,
	    	':region_unique' => 0,//$region_id,
	    	':city' => $city,
	    	':grantee' => $grantee,
	    	':sector' => $sector,
	    	':start_at' => $start_at,
	    	':end_at' => $end_at,
	    	':info' => $info,
	    	':type' => $type,
		':place_unique' => $place_unique,
		':lang' => $lang,
	        ':unique' => $unique
	    ));
	    $success = (bool)$exec;

	    //$last_insert_id = db()->lastInsertId();

	    foreach ($org_uniques as $org_unique)
	    {
		$query = "INSERT INTO `project_organizations` ( project_unique, organization_unique ) VALUES( :project_unique, :organization_unique );";
		$query = db()->prepare($query);
		$query = $query->execute(array(':project_unique' => $unique, ':organization_unique' => $org_unique));
	    }


	    if (!empty($tag_uniques) OR !empty($tag_names))
		if (!add_tag_connector('proj', $unique, $tag_uniques, $tag_names))
		    return "tag connection error";
    }

    if ($success)
    {
        if (!empty($project_key))
        	add_page_data('project', $unique, $project_key, $project_sort, $sidebar, $project_value);
    	Slim::redirect(href("admin/projects", TRUE));
    }
    else
    	return "couldn't insert record/database error";
    
}

function update_project($unique, $title, $desc, $budget, $place_unique, $city, $grantee, $sector, $start_at, $end_at, $info, $tag_uniques, $tag_names, $org_ids, $type)
{
    $back = "<br /><a href=\"" . href("admin/projects/" . $unique, TRUE) . "\">Back</a>";

    $fields = array();
    (strlen($title) < 4) AND $fields[] = 'title';
  /*$fields[] = (strlen($desc) < 4) ? 'description' : NULL;
    $fields[] = (strlen($budget) < 4) ? 'budget' : NULL;
    $fields[] = (strlen($city) < 4) ? 'city' : NULL;
    $fields[] = (strlen($grantee) < 4) ? 'grantee' : NULL;
    $fields[] = (strlen($sector) < 4) ? 'sector' : NULL;
    $fields[] = (strlen($start_at) < 4) ? 'start_at' : NULL;
    $fields[] = (strlen($end_at) < 4) ? 'end_at' : NULL;
    $fields[] = (strlen($info) < 4) ? 'info' : NULL;*/

    $fields_new = array();
    foreach ($fields as $field)
    	if ($field != NULL)
    		$fields_new[] = $field;

    $fields = $fields_new;

    $f = implode(", ", array_values($fields));

    if (count($fields) > 0)
    	return $f . " too short" . $back;

    $sql = "
    	UPDATE
    		`projects`
    	SET
    		title = :title,
    		description = :description,
    		budget = :budget,
		region_unique = :region_unique,
    		city = :city,
    		grantee = :grantee,
    		sector = :sector,
    		start_at = :start_at,
    		end_at = :end_at,
    		info = :info,
    		type = :type,
		place_unique = :place_unique
    	WHERE
    		`projects`.`unique` = :unique;
    	AND
    		projects.lang = '" . LANG . "'
    	DELETE FROM
    		tag_connector
    	WHERE
    		proj_unique = :unique;
    	DELETE FROM
    		project_organizations
    	WHERE
    		project_unique = :unique;
    ";
    $statement = db()->prepare($sql);

    //$unique = get_unique("projects", $id);
    $exec = $statement->execute(array(
    	':unique' => $unique,
    	':title' => $title,
    	':description' => $desc,
    	':budget' => $budget,
    	':region_unique' => 0,//$region_id,
    	':city' => $city,
    	':grantee' => $grantee,
    	':sector' => $sector,
    	':start_at' => $start_at,
    	':end_at' => $end_at,
    	':info' => $info,
    	':type' => $type,
    	':unique' => $unique,
        ':place_unique' => $place_unique
    ));

    //fetch_db("DELETE FROM project_organizations WHERE project_unique = '" . $unique . "';");

    if (!empty($org_ids))
    {
        $sql = "INSERT INTO project_organizations (project_unique, organization_unique) VALUES(:project, :organization);";        
        $query = db()->prepare($sql);
    	foreach ($org_ids AS $org_unique)
    	{
            //fb(array(':project' => $unique, ':organization' => $org_unique));
            db()->prepare($sql)->execute(array(':project' => $unique, ':organization' => $org_unique));
    	}
    }

//    $unique = get_unique("projects", $id);
    fetch_db("DELETE FROM tag_connector WHERE proj_unique = $unique");
    if (!empty($tag_uniques) OR !empty($tag_names))
    	add_tag_connector('proj', $unique, $tag_uniques, $tag_names);

    Slim::redirect(href("admin/projects", TRUE));
}

function delete_project($unique)
{
    if (!is_numeric($unique))
	return "invalid id";

    //$unique = get_unique("projects", $id);
    $sql = "
    		DELETE FROM `projects` WHERE  `projects`.`unique` = '" . $unique . "';
    		DELETE FROM tag_connector WHERE proj_unique = :unique;
		DELETE FROM project_organizations WHERE project_unique = :unique;
		DELETE FROM pages_data WHERE owner = 'project' AND owner_unique = :unique;
	   ";
    $statement = db()->prepare($sql);
    $delete = $statement->execute(array(':unique' => $unique));

    //delete_project_data($id);

    if ($delete)
    	Slim::redirect(href("admin/projects", TRUE));
    else
    	return "couldn't delete record/database error";
}

/*==========================================================================================================*/
function read_page_data($owner, $unique)
{
	$query = "SELECT * FROM pages_data
		  WHERE owner = :owner AND owner_unique = :unique AND lang = '" . LANG . "'
		  ORDER BY `sort`,`unique`;";
	$query = db()->prepare($query);
	$query->execute(array(':unique' => $unique, ':owner' => $owner));
	$query = $query->fetchAll();
	empty($query) AND $query = array();
	return $query;
}

function delete_page_data($owner, $unique)
{
	$sql = "DELETE FROM pages_data WHERE owner = :owner AND owner_unique = :unique;";
	$statement = db()->prepare($sql);
	$statement->execute(array(':unique' => $unique, ':owner' => $owner));
}

function add_page_data($owner, $owner_unique, $key, $sort, $sidebar, $value)
{
	$languages = config('languages');
	for ( $i = 0, $c = count($key); $i < $c; $i ++ )
	{
	    if (!empty($key[$i]) AND !empty($value[$i]))
	    {
   		$unique = generate_unique("pages_data");
    		foreach ($languages as $lang)
    		{
			$sql = "
			 INSERT INTO `opentaps`.`pages_data` (`key`, `value`, `owner`, owner_unique, `sort`, `sidebar`, lang, `unique`)
			 VALUES (:key, :value, :owner, :owner_unique, :sort, :sidebar, :lang, :unique);
			";
			$statement = db()->prepare($sql);
			$data = array(
				':owner' => $owner,
				':owner_unique' => $owner_unique,
				':key' => $key[$i] . ((LANG == $lang) ? NULL : " ({$lang})"),
				':value' => $value[$i],
				':sort' => $sort[$i],
				':sidebar' => ((!empty($sidebar[$i]) AND $sidebar[$i] == "checked") ? 1 : 0),
				':lang' => $lang,
	       			':unique' => $unique
			);
			$statement->execute($data);
		}
	    }
	}
}
/*==========================================================================================================*/

function word_limiter($text, $limit = 30, $chars = 'აბგდევზთიკლმნოპჟრსტუფქღყშჩცძწჭხჯჰ0123456789')
{
    if (strlen($text) > $limit)
    {
        $words = str_word_count($text, 2, $chars);
        $words = array_reverse($words, TRUE);
        foreach($words AS $length => $word)
        {
            if ($length + strlen($word) >= $limit)
                array_shift($words);
            else
                break;
        }
        $words = array_reverse($words);
        $text = implode(' ', $words) . '&hellip;';
    }
    return $text;
}

function get_project_chart_data($unique)
{
	//$result = array();
	$v = array();
	$names = array();

	$sql = "
		SELECT
			organizations.name
		FROM 
			`project_organizations`
		LEFT JOIN
			`organizations`
		ON
			(`project_organizations`.`organization_unique` = `organizations`.`unique`)
		WHERE
			project_unique = :unique;
	";
	$query = db()->prepare($sql);
	$query->execute(array(':unique' => $unique));

	$results = $query->fetchAll(PDO::FETCH_ASSOC);
	$names[1] = array();
	$v[1] = array();
	$real_values[1] = array();

	foreach ( $results as $r )
	{
		$real_values[1][] = $v[1][] = 1;
		$names[1][] = str_replace(" ", "+", $r['name']);
	}


	$sql = "SELECT budget, title FROM  `projects` WHERE lang = '" . LANG . "';";
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

	$real_values[2] = $v[2];

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

	return array($v, $names, $real_values);
}
/*function down_to_range($n, $range = 100)
{
	if ( $n > $range )
		return down_to_range($n / $range, $range);
	else
		return $n;
}*/






/*================================================	Admin Organizations	============================================*/
function get_organization($unique)
{
	$sql = "SELECT * FROM organizations WHERE `unique` = :unique AND lang = '" . LANG . "' LIMIT 1;";
	$statement = db()->prepare($sql);
	$statement->execute(array(
		':unique' => $unique
	));
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function get_organization_projects($unique)
{
	$sql = "SELECT p.`unique`,p.id,p.title FROM projects AS p 
		LEFT JOIN project_organizations AS po ON p.`unique` = po.project_unique
		LEFT JOIN organizations AS o ON o.`unique` = po.organization_unique
		WHERE o.`unique` = :unique AND o.lang = '" . LANG . "'";
	$statement = db()->prepare($sql);
	$statement->execute(array(
		':unique' => $unique
	));
	
	return $statement->fetchAll();
}

function delete_organization($unique){
	$org = get_organization($unique);
	$sql = "DELETE FROM organizations WHERE `unique` = :unique;
		DELETE FROM pages_data WHERE owner = 'organization' AND owner_unique = :unique";
	$statement = db()->prepare($sql);
	$statement->execute(array(':unique' => $unique));
	if (file_exists($org['logo']))
		unlink($org['logo']);
}

function add_organization($name,$description,$projects_info,$city_town,$district,$grante,$sector,$tags,$tag_names,$file, $org_key = NULL, $org_sort = NULL, $org_value = NULL, $sidebar = NULL)
{
	if(count($file) > 0)
	if( count($file) > 0 AND $file['p_logo']['error'] == 0 ){
		$logo_destination = DIR.'uploads/organization_photos/';
		$logo_name = mt_rand(0,100000).time().$file['p_logo']['name'];
		upload_files($file,$logo_destination,array(
			$logo_name
		));
		$logo = $logo_destination.$logo_name;
	}
	else
	{
		$logo = NULL;
	}

	$languages = config('languages');
	$unique = generate_unique("organizations");
    	foreach ($languages as $lang)
    	{
		$sql = "INSERT INTO organizations(
				name,
				description,
				district,
				city_town,
				grante,
				sector,
				projects_info,
				logo,
				lang,
				`unique`
			)
			VALUES(
				:name,
				:description,
				:district,
				:city_town,
				:grante,
				:sector,
				:projects_info,
				:logo,
				:lang,
				:unique
			)";
		$data = array(
			':name' => $name . ((LANG == $lang) ? NULL : " ({$lang})"),
			':description' => $description,
			':projects_info' => $projects_info,
			':city_town' => $city_town,
			':district' => $district,
			':grante' => $grante,
			':sector' => $sector,
			':logo' => $logo,
			':lang' => $lang,
	        	':unique' => $unique
		);
		foreach ($data as $key => $d) 
		    $sql = str_replace($key, "'" . $d . "'", $sql);
		$statement = db()->prepare($sql);
		$exec = $statement->execute($data);

		add_tag_connector('org', $unique, $tags, $tag_names);
	}
	if ($exec AND !empty($org_key))
        	add_page_data('organization', $unique, $org_key, $org_sort, $sidebar, $org_value);
}

function edit_organization($unique,$name,$info,$projects_info,$city_town,$district,$grante,$sector,$file,$tag_uniques,$tag_names)
{
	$org = get_organization($unique);
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

	//$unique = get_unique("organizations", $id);	

	$sql = "UPDATE organizations SET name=:name,description=:info,district=:district,city_town=:city_town,
		grante=:grante,sector=:sector,projects_info=:projects_info,logo=:logo
		WHERE `unique`=:unique AND lang = '" . LANG . "' LIMIT 1;";
	$statement = db()->prepare($sql);
	$statement->execute(array(
		':name' => $name,
		':info' => $info,
		':district' => $district,
		':city_town' => $city_town,
		':grante' => $grante,
		':sector' => $sector,
		':projects_info' => $projects_info,
		':unique' => $unique,
		':logo' => $logo
	));

    //$unique = get_unique("organizations", $id);
    fetch_db("DELETE FROM tag_connector WHERE org_unique = $unique");
    if (!empty($tag_uniques) OR !empty($tag_names))
    	add_tag_connector('org', $unique, $tag_uniques, $tag_names);
}

/*===================================================	  Organizations Fontpage	===============================*/
function organization_total_budget($organization_unique)
{
	$sql = "SELECT
			SUM(projects.budget) AS total_budget
		FROM 
			`project_organizations`
		JOIN
			`projects`
		ON
			(`project_organizations`.`project_unique` = `projects`.`unique`)
		WHERE
			organization_unique = :unique
		AND
			projects.lang = '" . LANG . "';
	";
	$query = db()->prepare($sql);
	$query->execute(array(':unique' => $organization_unique));
	$result = $query->fetch(PDO::FETCH_ASSOC);
	return number_format($result['total_budget']);
}

function get_organization_chart_data($unique)
{
	//$result = array();
	$v = array();
	$names = array();

	$sql = "
		SELECT
			projects.title,
			projects.budget
		FROM 
			project_organizations
		LEFT JOIN
			projects
		ON
			(project_organizations.project_unique = projects.`unique`)
		WHERE
			organization_unique = :unique;
	";
	$query = db()->prepare($sql);
	//$unique = get_unique("projects", $id);
	$query->execute(array(':unique' => $unique));

	$results = $query->fetchAll(PDO::FETCH_ASSOC);

	//print_r($results);exit;
    
	$b = FALSE;

	foreach ($results as $r)
	{
		$i = $v[1][] = str_replace("$", "", str_replace(",", "", $r['budget']));
		$b OR $b = ( $i > 100 );
		$names[1][] = str_replace(" ", "+", $r['title']);
	}

	//print_r($v);exit;

    	$real_values[1] = $v[1];

	if ($b)
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

	$sql = "SELECT projects.start_at FROM project_organizations
		LEFT JOIN `projects` ON (`project_organizations`.`project_unique` = `projects`.`unique`)
		WHERE organization_unique = :unique ORDER BY start_at LIMIT 0,1;";
	$query = db()->prepare($sql);
	$query->execute(array(':unique' => $unique));
	$first = $query->fetch(PDO::FETCH_ASSOC);
	$first_year = substr($first['start_at'], 0, 4);

	$sql = "SELECT projects.end_at FROM project_organizations
		LEFT JOIN `projects` ON (`project_organizations`.`project_unique` = `projects`.`unique`)
		WHERE organization_unique = :unique ORDER BY end_at DESC LIMIT 0,1;";
	$query = db()->prepare($sql);
	$query->execute(array(':unique' => $unique));
	$last = $query->fetch(PDO::FETCH_ASSOC);
	$last_year = substr($last['end_at'], 0, 4);

	$budgets = array();
	$names[2] = array();

	$b = FALSE;

	for($i = $first_year; $i <= $last_year; $i ++):
		$names[2][] = $i;

		$sql = "SELECT projects.budget,projects.end_at,projects.start_at FROM project_organizations
			LEFT JOIN `projects` ON (`project_organizations`.`project_unique` = `projects`.`unique`)
			WHERE organization_unique = :unique AND projects.start_at <= :start;";
		$query = db()->prepare($sql);
		$query->execute(array(':unique' => $unique, ':start' => $i . "-12-31"));
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		if ( empty($fetch) )
			continue;

		$budgets[$i] = 0;

		foreach( $fetch as $project ):
			if(strtotime($project['end_at']) < strtotime($i."-01-01"))
				continue;
			if(strtotime($project['start_at']) >= strtotime($i."-01-01"))
				$start = $project['start_at'];
			else
				$start = $i . "-01-01";
			$end = (strtotime($project['end_at']) < strtotime($i."-12-31")) ? $project['end_at'] : ($i."-12-31");
			$budgets[$i] +=	(dateDiff($start, $end) + 1) / (dateDiff($project['start_at'], $project['end_at']) + 1)
					* $project['budget'];
		endforeach;

		$b = ($budgets[$i] > 100);
	endfor;

	$real_values[2] = $v[2] = $budgets;

	if ( $b ):
		$max = max($v[2]);
		$depth = 0;
		while ( $max > 100 ):
			$max = $max / 100;
			$depth ++;
		endwhile;
		for ( $i = $first_year; $i <= $last_year; $i ++  ):
			for ( $j = 0; $j < $depth; $j ++ )
				$v[2][$i] = $v[2][$i] / 90;
			$v[2][$i] *= 20;
		endfor;
	endif;

	return array($v, $names, $real_values);
}

function get_region_chart_data($unique)
{
	//$result = array();
	$v = array();
	$names = array();



	/*=========================		PIE 1		=============================*/
	$sql = "
		SELECT title,budget FROM projects
		LEFT JOIN places ON projects.place_unique = places.`unique`
		WHERE places.region_unique = :unique AND places.lang = '" . LANG . "'
		LIMIT 0,1
	;";
	$query = db()->prepare($sql);
	$query->execute(array(':unique' => $unique));

	$results = $query->fetchAll(PDO::FETCH_ASSOC);

	$b = FALSE;
	$v[1] = array();

	foreach ( $results as $r )
	{
		$i = $v[1][] = str_replace("$", "", str_replace(",", "", $r['budget']));
		$b OR $b = ($i > 100);
		$names[1][] = str_replace(" ", "+", $r['title']);
	}

	$real_values[1] = $v[1];

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




	/*=========================		COLUMN 1		=============================*/

	$sql = "SELECT start_at FROM projects LEFT JOIN places ON projects.place_unique = places.`unique`
			AND projects.lang = places.lang
		WHERE places.region_unique = :unique AND places.lang = '" . LANG . "'
		ORDER BY start_at LIMIT 0,1;";
	$query = db()->prepare($sql);
	$query->execute(array(':unique' => $unique));
	$first = $query->fetch(PDO::FETCH_ASSOC);
	$first_year = substr($first['start_at'], 0, 4);

	$sql = "SELECT end_at FROM projects LEFT JOIN places ON projects.place_unique = places.`unique` AND projects.lang = places.lang
		WHERE places.region_unique = :unique AND places.lang = '" . LANG . "'
		ORDER BY end_at DESC LIMIT 0,1;";
	$query = db()->prepare($sql);
	$query->execute(array(':unique' => $unique));
	$last = $query->fetch(PDO::FETCH_ASSOC);
	$last_year = substr($last['end_at'], 0, 4);

	$budgets = array();
	$names[2] = array();

	$b = FALSE;

	for($i = $first_year; $i <= $last_year; $i ++):
		$names[2][] = $i;

		$sql = "SELECT budget,end_at,start_at FROM projects LEFT JOIN places ON projects.place_unique = places.`unique`
			WHERE places.region_unique = :unique AND places.lang = '" . LANG . "' AND projects.lang = '" . LANG . "'
			AND start_at <= :start";
		$query = db()->prepare($sql);
		$query->execute(array(':unique' => $unique, ':start' => $i . "-12-31"));
		$fetch = $query->fetchAll(PDO::FETCH_ASSOC);
		if (empty($fetch))
			continue;

		$budgets[$i] = 0;

		foreach( $fetch as $project ):
			if(strtotime($project['end_at']) < strtotime($i."-01-01"))
				continue;
			if(strtotime($project['start_at']) >= strtotime($i."-01-01"))
				$start = $project['start_at'];
			else
				$start = $i . "-01-01";
			$end = (strtotime($project['end_at']) < strtotime($i."-12-31")) ? $project['end_at'] : ($i."-12-31");
			$budgets[$i] +=	(dateDiff($start, $end) + 1) / (dateDiff($project['start_at'], $project['end_at']) + 1)
					* $project['budget'];
		endforeach;

		$b = ($budgets[$i] > 100);
	endfor;

	$real_values[2] = $v[2] = $budgets;

	if ( $b ):
		$max = max($v[2]);
		$depth = 0;
		while ( $max > 100 ):
			$max = $max / 100;
			$depth ++;
		endwhile;
		for ( $i = $first_year; $i <= $last_year; $i ++  ):
			for ( $j = 0; $j < $depth; $j ++ )
				$v[2][$i] = $v[2][$i] / 90;
			$v[2][$i] *= 20;
		endfor;
	endif;


	/*=========================		PIE 2		=============================*/
	$query = "SELECT p.budget, p.title, o.name
		  FROM organizations AS o
		  INNER JOIN project_organizations AS po
		  ON po.organization_unique = o.`unique`
		  INNER JOIN projects AS p
		  ON p.`unique` = po.project_unique
		  LEFT JOIN places
		  ON p.place_unique = places.`unique` AND po.lang = places.lang AND p.lang = places.lang
		  WHERE places.region_unique = :unique AND places.lang = '" . LANG . "'
		  ORDER BY o.name
		";
	$query = db()->prepare($query);
	$query->execute(array(':unique' => $unique));
	$results = $query->fetchAll(PDO::FETCH_ASSOC);

	$names[3] = array();
	$v[3] = array();
	$grouped = array();
	$b = FALSE;
	foreach($results as $result)
	{
		if (!isset($grouped[$result['name']]['budget']) OR empty($grouped[$result['name']]['budget']))
			$grouped[$result['name']]['budget'] = $result['budget'];
	        else
		        $grouped[$result['name']]['budget'] += $result['budget'];
		$b = ($grouped[$result['name']]['budget'] > 100);
		//$grouped[$result['name']]['projects'][] = array('title' => $result['title'], 'budget' => $result['budget']);
		in_array($result['name'], $names[3]) OR $names[3][] = $result['name'];
	}

	foreach($grouped as $budget)
		$v[3][] = $budget['budget'];

	$real_values[3] = $v[3];

	if ( $b )
	{
		$max = max($v[3]);
		$depth = 0;
		while ( $max > 100 ):
			$max = $max / 100;
			$depth ++;
		endwhile;
		for ( $i = 0, $n = count($v[3]); $i < $n; $i ++  )
			for ( $j = 0; $j < $depth; $j ++ )
				$v[3][$i] = $v[3][$i] / 100;
	}


	return array($v, $names, $real_values);
}


function dateDiff($start, $end)
{
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}
