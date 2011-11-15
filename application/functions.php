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

function l($item, $variables = array())
{
    if (!isset(Storage::instance()->language_items[$item]))
        return NULL;
    return empty($variables) ? Storage::instance()->language_items[$item] : strtr(Storage::instance()->language_items[$item], $variables);
}

function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
        $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
}

function trace($data, $title = NULL)
{
    $whitelist_ips = config('whitelist_ips');
    if (!in_array(get_ip(), $whitelist_ips))
        return;
    $instance = FirePHP::getInstance(true);
    $arguments = func_get_args();
    return call_user_func_array(array($instance, 'fb'), $arguments);
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
    $statement->closeCursor();
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
    $max = fetch_db('SELECT MAX(`unique`) AS u FROM `' . $table . '`;', NULL, TRUE);
    if (empty($max) OR empty($max['u']))
        return 1;
    return ($max['u'] + 1);
}

function get_unique($table, $id)
{
//	$table = htmlspecialchars(str_replace(";", "", $table));
    $query = db()->prepare("SELECT `unique` from `" . $table . "` WHERE id = :id LIMIT 1;");
    $query->closeCursor();
    $query->execute(array(':id' => $id));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (empty($result) OR empty($result['unique']))
        return FALSE;
    return $result['unique'];
}

### MENU MANAGEMENT

function read_menu($parent_unique = 0, $lang = null, $readhidden = FALSE)
{
    $sql = "SELECT id,name,short_name,`unique`,hidden FROM menu WHERE parent_unique = :parent_unique AND lang = '" . LANG . "'
    	   " . ($readhidden ? NULL : " AND hidden = 0") . ";";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(':parent_unique' => $parent_unique));
    return $statement->fetchAll();
}

function has_submenu($menuunique)
{
    $sql = "SELECT id,`unique` FROM menu WHERE parent_unique = :menuunique AND lang = '" . LANG . "';";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(':menuunique' => $menuunique));
    $a = $statement->fetchAll();
    return (count($a) > 0);
}

function read_submenu()
{
    $sql = "SELECT id,`unique`,name,short_name,parent_unique FROM menu WHERE hidden = 0 AND parent_unique != 0 AND lang = '" . LANG . "' ORDER BY parent_unique,`unique`;";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute();
    $items = $statement->fetchAll();
    $submenus = array();
    foreach ($items AS $item)
        $submenus[$item['parent_unique']][] = $item;
    return $submenus;
}

function get_menu($short_name)
{
    if (is_numeric($short_name))
    {
        $sql = "SELECT * FROM menu WHERE `unique` = :short_name AND lang = '" . LANG . "' LIMIT 1;";
    }
    else
    {
        $sql = "SELECT * FROM menu WHERE short_name = :short_name AND lang = '" . LANG . "' LIMIT 1;";
    }
    $stmt = db()->prepare($sql);
    $stmt->closeCursor();
    $stmt->execute(array(
        ':short_name' => $short_name
    ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return empty($result) ? array() : $result;
}

function add_menu($adding_lang, $name, $short_name, $parent_unique, $title, $text, $footer)
{
    if (strlen($name) < 2)
        return false;

    $unique = generate_unique("menu");

    $sql = "INSERT INTO  `opentaps`.`menu` (`parent_unique`, `name`, `short_name`, title, text, hidden, footer, lang, `unique`)
    	    VALUES(:parent_unique, :name, :short_name, :title, :text, 1, :footer, :lang, :unique)";
    $statement = db()->prepare($sql);
    $statement->closeCursor();

    foreach (config('languages') as $lang)
    {
        $the_name = $name . (($adding_lang == $lang) ? NULL : " ({$lang})");
        $exec = $statement->execute(array(
                    ':name' => $the_name,
                    ':short_name' => empty($short_name) ? string_to_friendly_url($the_name) : $short_name,
                    ':parent_unique' => $parent_unique,
                    ':title' => $title,
                    ':text' => $text,
                    ':footer' => $footer,
                    ':lang' => $lang,
                    ':unique' => $unique
                ));

        $success = (bool) $exec;
    }

    return $success;
}

function update_menu($unique, $name, $short_name, $parent_unique, $title, $text, $hide, $footer)
{
    if (strlen($name) < 2 || !is_numeric($unique))
        return false;

    $sql = "UPDATE `menu` SET  `parent_unique` =  :parent_unique, `short_name` =  :short_name, `name` =  :name, title=:title, text=:text, hide=:hide, footer=:footer  WHERE  `menu`.`unique` = :unique AND lang = '" . LANG . "'";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $exec = $statement->execute(array(
                ':unique' => $unique,
                ':short_name' => empty($short_name) ? string_to_friendly_url($name) : $short_name,
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
    $statement->closeCursor();

    $exec = $statement->execute(array(':unique' => $unique));

    return ($exec) ? true : false;
}

### NEWS MANAGEMENT

function read_news($limit = false, $from = 0, $news_unique = false)
{
    if ($news_unique)
    {
        $sql = "SELECT * FROM news WHERE `unique` = :news_unique AND lang = '" . LANG . "' ORDER BY published_at DESC";
        $statement = db()->prepare($sql);
        $statement->closeCursor();
        $statement->execute(array(':news_unique' => $news_unique));
    }
    else
    {
        $sql = "SELECT * FROM news WHERE lang = '" . LANG . "'
		ORDER BY published_at DESC" . ($limit ? " LIMIT " . $from . "," . $limit : NULL);
        $statement = db()->prepare($sql);
        $statement->closeCursor();
        $statement->execute();
    }
    return $statement->fetchAll();
}

function read_news_one_page($from, $limit, $type = FALSE)
{
    $sql = "SELECT * FROM news " . ($type ? "WHERE category = :type AND lang = '" . LANG . "'" : "WHERE lang = '" . LANG . "'") . "
            AND `hidden` = 0
    	    ORDER BY published_at DESC LIMIT " . $from . ", " . $limit . "";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $data = $type ? array(':type' => $type) : NULL;
    $statement->execute($data);

    return $statement->fetchAll();
}

function add_news($adding_lang, $title, $show_in_slider, $body, $filedata, $category, $place, $tags, $tag_names, $data_key = NULL, $data_sort = NULL, $data_value = NULL, $sidebar = NULL)
{
    if (strlen($title) < 1)
        return "title can't be empty";

    $up = image_upload($filedata);
    if (substr($up, 0, 8) != "uploads/" && $up != "")  //return if any errors
        return $up;

    $unique = generate_unique("news");
    $date = $_POST['published_at'];

    $sql = "INSERT INTO  opentaps.`news` (title, show_in_slider, `body`, published_at, image, category, place_unique, lang, `unique`, hidden)
	    VALUES(:title, :show_in_slider, :body, :published_at, :image, :category, :place, :lang, :unique, :hidden)";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $data = array(
        ':show_in_slider' => $show_in_slider,
        ':body' => $body,
        ':published_at' => ($date['year'] . '-' . $date['month'] . '-' . ($date['day'] < 10 ? '0' . $date['day'] : $date['day']) . ' ' . $date['hour'] . ':' . $date['minute']), //date("Y-m-d H:i"),
        ':image' => $up,
        ':category' => $category,
        ':place' => $place,
        ':unique' => $unique,
        ':hidden' => (isset($_POST['hidden']) ? 1 : 0),
    );

    foreach (config('languages') as $lang)
    {
        $data[':title'] = $title . (($adding_lang == $lang) ? NULL : " ({$lang})");
        $data[':lang'] = $lang;
        $exec = $statement->execute($data);
        $success = (bool) $exec;
    }

    if ($success)
    {
        (empty($tags) AND empty($tag_names)) OR add_tag_connector('news', $unique, $tags, $tag_names);
        empty($data_key) OR add_page_data('news', $unique, $data_key, $data_sort, $sidebar, $data_value, $adding_lang);
        Slim::redirect(href('admin/news', TRUE));
    }
    else
    {
        var_dump("couldn't insert into database");
        die;
    }
}

function update_news($unique, $title, $show_in_slider, $body, $filedata, $category, $place, $tags, $tag_names)
{
    if (strlen($title) < 1 OR !is_numeric($unique))
        return "title is empty or invalid id";

    $date = $_POST['published_at'];
    $up = image_upload($filedata);
    if (substr($up, 0, 8) != "uploads/" && $up != "")   //return if any errors
        return $up;
    elseif ($up == "")
    {
        $sql = "UPDATE  `opentaps`.`news` SET  `title` =  :title, published_at = :published_at, hidden = :hidden, show_in_slider = :show_in_slider, `body` = :body, category = :category, place_unique = :place WHERE  `news`.`unique` = :unique AND news.lang = '" . LANG . "';";
        $data = array(
            ':unique' => $unique,
            ':title' => $title,
            ':body' => $body,
            ':published_at' => ($date['year'] . '-' . $date['month'] . '-' . ($date['day'] < 10 ? '0' . $date['day'] : $date['day']) . ' ' . $date['hour'] . ':' . $date['minute']),
            ':show_in_slider' => $show_in_slider,
            ':category' => $category,
            ':place' => $place,
            ':hidden' => (isset($_POST['hidden']) ? 1 : 0),
        );
    }
    else
    {
        delete_image($unique);
        $sql = "UPDATE  `opentaps`.`news` SET  `title` =  :title, published_at = :published_at, hidden = :hidden, show_in_slider = :show_in_slider, `image` =  :image, `body` =  :body, category = :category, place_unique = :place WHERE  `news`.`unique` = :unique AND news.lang = '" . LANG . "' LIMIT 1;
        	UPDATE  `opentaps`.`news` SET  `image` =  :image WHERE  `news`.`unique` = :unique;";
        $data = array(
            ':unique' => $unique,
            ':title' => $title,
            ':body' => $body,
            ':published_at' => ($date['year'] . '-' . $date['month'] . '-' . ($date['day'] < 10 ? '0' . $date['day'] : $date['day']) . ' ' . $date['hour'] . ':' . $date['minute']),
            ':image' => $up,
            ':show_in_slider' => $show_in_slider,
            ':category' => $category,
            ':place' => $place,
            ':hidden' => (isset($_POST['hidden']) ? 1 : 0),
        );
    }

    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $exec = $statement->execute($data);
    //$unique = get_unique("news", $id);

    fetch_db("DELETE FROM tag_connector WHERE news_unique = :unique AND lang = '" . LANG . "';", array(':unique' => $unique));
    if (!empty($tags) OR !empty($tag_names))
    {
        add_tag_connector('news', $unique, $tags, $tag_names);
    }

    Slim::redirect(href("admin/news", TRUE));
    return $exec;
}

function delete_news($unique)
{
    if (!is_numeric($unique))
        return false;

    delete_image($unique);

    //$unique = get_unique("news", $id);
    //print_r(get_uniques_ids("news", $unique));die;
    $sql = "DELETE FROM `opentaps`.`news` WHERE  `news`.`unique` = :unique;
    	    DELETE FROM pages_data WHERE owner = 'news' AND owner_unique = :unique;";
    $statement = db()->prepare($sql);
    $statement->closeCursor();

    $exec = $statement->execute(array(':unique' => $unique));
    fetch_db("DELETE FROM tag_connector WHERE news_unique = '$unique'");
    return ($exec) ? true : false;
}

function image_upload($filedata, $path = "uploads/")
{
    if ($filedata['size'] > 0)
    {
        if (($filedata['type'] == "image/jpeg" || $filedata['type'] == "image/pjpeg" ||
                $filedata['type'] == "image/gif" || $filedata['type'] == "image/png") && $filedata['size'] / 1024 < 3149)
        {
            $path = "uploads/";
            $name = substr(sha1(uniqid() . time() . mt_rand(0, 1000)), 0, 15) . substr($filedata['name'], -20);
            if (file_exists($path . $name))
                $name = mt_rand(0, 99999) . $name;
            $upload = move_uploaded_file($filedata["tmp_name"], $path . $name);
            if (!$upload)
                return "file is valid but upload failed";
            return $path . $name;
        }
        else
            return "uploaded file is not an image or file size exceeds 3MB";
    }
    else
        return "";
}

function delete_image($unique)
{
    $sql = "SELECT image FROM news WHERE `unique` = :news_unique AND lang = '" . LANG . "' LIMIT 1";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(':news_unique' => $unique));
    $image = $statement->fetch(PDO::FETCH_ASSOC);
    if (file_exists($image['image']))
        unlink($image['image']);
}

function view_image($news_unique)
{
    $sql = "SELECT image FROM news WHERE `unique` = :news_unique AND lang = '" . LANG . "'";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(':news_unique' => $news_unique));
    $image = $statement->fetch(PDO::FETCH_ASSOC);
    return file_exists($image['image']) ? URL . $image['image'] : false;
}

### TAGS MANAGEMENT

function read_tags($tag_unique = false)
{
    if ($tag_unique)
    {
        $sql = "SELECT * FROM tags WHERE `unique` = :unique AND lang = '" . LANG . "' LIMIT 1";
        $statement = db()->prepare($sql);
        $statement->closeCursor();
        $statement->execute(array(':unique' => $tag_unique));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    $sql = "SELECT * FROM tags WHERE lang = '" . LANG . "'";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute();
    return $statement->fetchAll();
}

function read_tag_connector($field, $unique)
{
    if ($field != "news" && $field != "proj" && $field != "org")
        return array();

    $sql = "SELECT tag_unique FROM tag_connector WHERE " . $field . "_unique = '" . $unique . "' AND lang = '" . LANG . "';";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute();
    $r = $statement->fetchAll();
    $result = array();
    foreach ($r as $s)
    {
        $result[] = $s['tag_unique'];
    }
    return $result;
}

function add_tag_connector($field, $f_unique, $tag_uniques, $tag_names = NULL)
{
    if ($field != "news" AND $field != "proj" AND $field != "org")
    {
        exit("incorrect field");
    }

    if (empty($tag_uniques) AND empty($tag_names))
    {
        return TRUE;
    }

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
            $query->closeCursor();
            $query->execute(array(':name' => $tag_name));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $query->closeCursor();
            $success = TRUE;
            if (empty($result))
            {
                if (add_tag((empty($_POST['record_language']) ? LANG : $_POST['record_language']), $tag_name, FALSE) == TRUE)
                {
                    $stmt = db()->prepare("SELECT `unique` FROM tags WHERE name = :name LIMIT 1");
                    $stmt->closeCursor();
                    $stmt->execute(array(':name' => $tag_name));

                    $inserted_unique = $stmt->fetch(PDO::FETCH_ASSOC);
                    $result['unique'] = $inserted_unique['unique'];
                    $success = TRUE;
                }
                else
                    $success = FALSE;
            }
            $success AND !in_array($result['unique'], $tag_uniques) AND $tag_uniques[] = $result['unique'];
        }
    }

    $check = TRUE;


    $sql = "INSERT INTO `opentaps`.`tag_connector` (lang, `tag_unique`, `" . $field . "_unique`) VALUES(:lang, :tag_unique, :f_unique);";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    foreach ($tag_uniques AS $tag_unique)
    {
        $exec = $statement->execute(array(
                    ':lang' => (empty($_POST['record_language']) ? LANG : $_POST['record_language']),
                    ':f_unique' => $f_unique,
                    ':tag_unique' => $tag_unique
                ));
        $check AND $check = (bool) $exec;
    }

    return $check;
}

function add_tag($adding_lang, $name, $redirect = TRUE)
{
    $back = "<br /><a href=\"" . href("admin/tags/new", TRUE) . "\">Back</a>";

    if (strlen($name) < 2)
        return "name too short" . $back;

    $unique = generate_unique("tags");
    $sql = "INSERT INTO  `opentaps`.`tags` (`name`, lang, `unique`) VALUES(:name, :lang, :unique)";
    $statement = db()->prepare($sql);
    $statement->closeCursor();

    foreach (config('languages') as $lang)
    {
        $exec = $statement->execute(array(
                    ':name' => $name . (($adding_lang == $lang) ? NULL : " ({$lang})"),
                    ':lang' => $lang,
                    ':unique' => $unique
                ));
        $success = (bool) $exec;
    }

    if ($redirect)
    {
        Slim::redirect(href("admin/tags", TRUE));
    }
    return $success;
}

function update_tag($unique, $name)
{
    $back = "<br /><a href=\"" . href("admin/tags/" . $unique, TRUE) . "\">Back</a>";

    if (strlen($name) < 2 || !is_numeric($unique))
        return "name too short or invalid id" . $back;

    $sql = "UPDATE `tags` SET  `name` =  :name WHERE  `tags`.`unique` = :unique AND lang = '" . LANG . "'";
    $statement = db()->prepare($sql);
    $statement->closeCursor();

    $exec = $statement->execute(array(
                ':unique' => $unique,
                ':name' => $name
            ));

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/tags", TRUE) . "' />";
    return ($exec) ? $metarefresh : "couldn't update record/database error" . $back;
}

function delete_tag($unique)
{
    if (!is_numeric($unique))
        return "invalid id";

    $sql = "DELETE FROM `opentaps`.`tags` WHERE  `tags`.`unique` = :unique";
    $statement = db()->prepare($sql);
    $statement->closeCursor();

    $exec = $statement->execute(array(':unique' => $unique));

    $metarefresh = "<meta http-equiv='refresh' content='0; url=" . href("admin/tags", TRUE) . "' />";
    return ($exec) ? $metarefresh : "couldn't delete record/database error";
}

################################ IRAKLI'S FUNCTIONS

function fetch_db($sql, $data = NULL, $fetch_one = FALSE)
{
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute($data);
    if ($fetch_one)
    {
        if (strpos(strtolower($sql), "select") !== FALSE AND strpos(strtolower($sql), "from") !== FALSE)
        {
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }
        return empty($result) ? array() : $result;
    }
    else
    {
        if (strpos(strtolower($sql), "select") !== FALSE AND strpos(strtolower($sql), "from") !== FALSE)
        {
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return empty($result) ? array() : $result;
    }
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


                move_uploaded_file($file['tmp_name'], ( (substr($file_destination, strlen(trim($file_destination)) - 1) == '/' OR substr($file_destination, strlen(trim($file_destination)) - 1) == '\\') ? trim($file_destination) : trim($file_destination) . '/' ) . basename(( isset($files_names[$i]) AND !empty($files_names[$i]) ) ? trim($files_names[$i]) : trim($file['name']) ));
            }
            $i++;
        }
    }
    else
        return false;
}

function add_place($post)
{
    $unique = generate_unique("places");

    $sql = "INSERT INTO places (longitude,latitude,name,region_unique, lang, `unique`, district_unique)
	    VALUES(:lon, :lat, :name,:region, :lang, :unique,:district_unique)";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $data = array(
        ':lon' => $post['pl_longitude'],
        ':lat' => $post['pl_latitude'],
        ':region' => isset($post['pl_region']) ? $post['pl_region'] : 0,
        ':unique' => $unique,
        ':district_unique' => $post['pl_district']
    );

    foreach (config('languages') as $lang)
    {
        $data[':name'] = $post['pl_name'] . (($post['record_language'] == $lang) ? NULL : " ({$lang})");
        $data[':lang'] = $lang;
        $statement->execute($data);
    }
}

function edit_place($unique, $post)
{
    $sql = "UPDATE places SET
			longitude = :lon,
			latitude = :lat,
			name = :place_name,
			region_unique = :region,
			district_unique = :district_unique
		WHERE
			`unique` = :unique
		AND
			lang = '" . LANG . "'
		LIMIT 1;";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(
        ':lon' => $post['pl_longitude'],
        ':lat' => $post['pl_latitude'],
        ':place_name' => $post['pl_name'],
        ':region' => isset($post['pl_region']) ? $post['pl_region'] : 0,
        ':unique' => $unique,
        ':district_unique' => $post['pl_district']
    ));
}

function delete_place($unique)
{
    $sql = "DELETE FROM places WHERE `unique` = :unique;";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(':unique' => $unique));
}

/* =======================================================Admin Regions 	============================================================ */

function add_region($adding_lang, $name, $region_info, $region_projects_info, $city, $cities, $towns, $population, $squares, $settlement, $villages, $districts, $water_supply, $data_key = NULL, $data_sort = NULL, $data_value = NULL, $sidebar = NULL, $longitude = NULL, $latitude = NULL)
{
    $unique = generate_unique("regions");

    $sql = "INSERT INTO regions(name,region_info,projects_info,city,cities,towns,population,square_meters,settlement,villages,districts,lang,`unique`,longitude,latitude)
	    VALUES(:name,:region_info,:region_projects,:city,:cities,:towns,:population,:squares,:settlement,:villages,:districts, :lang, :unique,:longitude,:latitude)";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $data = array(
        ':region_info' => $region_info,
        ':region_projects' => $region_projects_info,
        ':city' => $city,
        ':cities' => $cities,
        ':towns' => $towns,
        ':population' => $population,
        ':squares' => $squares,
        ':settlement' => $settlement,
        ':villages' => $villages,
        ':districts' => $districts,
        ':unique' => $unique,
        ':longitude' => $longitude,
        ':latitude' => $latitude
    );

    foreach (config('languages') as $lang)
    {
        $data[':name'] = $name . (($adding_lang == $lang) ? NULL : " ({$lang})");
        $data[':lang'] = $lang;
        $exec = $statement->execute($data);
    }

    //$lastid = Storage::instance()->db->lastInsertId();

    if ($exec)
    {
        if (!empty($data_key))
        {
            add_page_data('region', $unique, $data_key, $data_sort, $sidebar, $data_value, $adding_lang);
        }

        $sql = "INSERT INTO water_supply (text, region_unique) VALUE(:text, :region_unique)";
        $stmt = db()->prepare($sql);
        $stmt->closeCursor();
        $stmt->execute(array(
            ':text' => $water_supply,
            ':region_unique' => $unique
        ));
    }
}

function delete_region($unique)
{
    $sql = "DELETE FROM regions WHERE `unique` = :unique;
	    DELETE FROM pages_data WHERE owner = 'region' AND owner_unique = :unique;";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(':unique' => $unique));
}

function get_region($unique)
{
    $sql = "SELECT * FROM regions WHERE `unique` = :unique AND lang = '" . LANG . "' LIMIT 1";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(
        ':unique' => $unique
    ));
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function update_region($unique, $name, $region_info, $region_projects_info, $city, $cities, $towns, $population, $squares, $settlement, $villages, $districts, $water_supply, $longitude = NULL, $latitude = NULL)
{
    //cities = :cities,
    //towns = :towns,
    $sql = "UPDATE regions SET
			name = :name,
			region_info = :region_info,
			projects_info = :region_projects,
			city = :city,
			population = :population,
			square_meters = :squares,
			settlement = :settlement,
			villages = :villages,
			districts = :districts,
                        longitude = :longitude,
                        latitude = :latitude
		WHERE `unique` = :unique AND lang = '" . LANG . "'";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(
        ':unique' => $unique,
        ':name' => $name,
        ':region_info' => $region_info,
        ':region_projects' => $region_projects_info,
        ':city' => $city,
        //':cities' => $cities,
        //':towns' => $towns,
        ':population' => $population,
        ':squares' => $squares,
        ':settlement' => $settlement,
        ':villages' => $villages,
        ':districts' => $districts,
        ':longitude' => $longitude,
        ':latitude' => $latitude
    ));

    $sql = "UPDATE water_supply SET text = :text WHERE district_unique = :region_unique AND lang = '" . LANG . "' LIMIT 1;";
    $stmt = Storage::instance()->db->prepare($sql);
    $stmt->closeCursor();
    $stmt->execute(array(
        ':text' => $water_supply,
        ':region_unique' => $unique
    ));
}

/* ===================================================	  Regions Fontpage	=============================== */

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

/* ===========================   Users Admin     ============================ */

function delete_user($id)
{
    $sql = "DELETE FROM users WHERE id = :id LIMIT 1;";
    $stmt = db()->prepare($sql);
    $stmt->closeCursor();
    $stmt->execute(array(
        ':id' => $id
    ));
}

function add_user($post)
{
    if (isset($post['u_name']) && isset($post['u_pass']))
    {
        $sql = "INSERT INTO users(username,password) VALUES(:username,:password)";
        $stmt = db()->prepare($sql);
        $stmt->closeCursor();
        $stmt->execute(array(
            ':username' => $post['u_name'],
            ':password' => hash('sha1', $post['u_pass'])
        ));
    }
}

function get_user($id)
{
    $sql = "SELECT * FROM users WHERE id = :id LIMIT 1;";
    $stmt = db()->prepare($sql);
    $stmt->closeCursor();
    $stmt->execute(array(
        ':id' => $id
    ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return empty($result) ? array() : $result;
}

function update_user($id, $post)
{
    if (isset($post['u_name']))
    {
        $sql = "UPDATE users SET username = :username, password = :password WHERE id = :id";
        $stmt = db()->prepare($sql);
        $stmt->closeCursor();
        $stmt->execute(array(
            ':username' => $post['u_name'],
            ':password' => hash('sha1', $post['u_pass']),
            ':id' => $id
        ));
    }
}

//projects


function read_projects($project_unique = FALSE, $limit = NULL, $readhidden = FALSE)
{
    if ($project_unique)
    {
        $sql = "
        SELECT
            p.*,
            pl.longitude,
            pl.latitude,
            r.name AS region_name
            "./*r.`unique` AS region_unique*/"
        FROM projects AS p
        LEFT JOIN places AS pl
            ON p.place_unique = pl.`unique` AND p.lang = pl.lang
        LEFT JOIN regions AS r
            ON pl.region_unique = r.`unique` AND pl.lang = r.lang
        WHERE p.`unique` = :unique AND p.lang = '" . LANG . "'
        ;";
        $statement = db()->prepare($sql);
        $statement->closeCursor();
        $statement->execute(array(':unique' => $project_unique));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return empty($result) ? array() : $result;
    }
    empty($limit) OR $limit = " LIMIT {$limit} ";
    $sql = "SELECT * FROM projects WHERE lang = '" . LANG . "' " . ($readhidden ? NULL : "AND hidden = 0 ") . " ORDER BY start_at{$limit}";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute();
    return $statement->fetchAll();
}

function projects_total_pages($filter = FALSE)
{
    $posp = config('projects_on_single_page');
    $query = "SELECT COUNT(id) AS total FROM projects WHERE lang = '" . LANG . "' " . ($filter ? ' AND type = :type ' : NULL) . ";";
    $query = db()->prepare($query);
    $query->execute($filter ? array(':type' => $filter) : NULL);
    $total = $query->fetch(PDO::FETCH_ASSOC);
    $total = $total['total'];
    $total == 0 and $total = 1;
    $total_pages = ($total % $posp == 0) ? $total / $posp : ($total + ($posp - $total % $posp)) / $posp;
    return $total_pages;
}

function read_projects_one_page($from, $limit, $order = FALSE, $direction = FALSE, $type = FALSE)
{
    if ($order)
    {
        $order = htmlspecialchars(stripslashes($order));
        $direction = $direction ? strtoupper(htmlspecialchars(stripslashes($direction))) : NULL;
        switch ($order)
        {
            default: $order = "p.title";
                break;
            case "region": $order = "pl.region_unique";
                break;
            case "districts": $order = "";
                break;
            case "years": $order = "p.start_at";
                break;
            case "categories": $order = "p.type";
                break;
            case "a-z": $order = "p.title";
                break;
        }
        $order .= " " . $direction . " ";
    }
    $sql = "
        SELECT
            p.title, p.`unique`, p.description, p.start_at, p.type, r.name AS region_name, r.`unique` AS region_unique
        FROM projects AS p
        LEFT JOIN places AS pl
            ON p.place_unique = pl.`unique` AND p.lang = pl.lang
	LEFT JOIN regions AS r
	    ON pl.region_unique = r.`unique` AND pl.lang = r.lang
        WHERE p.lang = '" . LANG . "' AND hidden = 0 " . ($type ? ' AND p.type = :type ' : NULL) . "
	" . ($order ? " ORDER BY {$order} " : NULL ) . " LIMIT {$from}, {$limit};";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute($type ? array(':type' => $type) : NULL);
    return $statement->fetchAll();
}

function add_project($adding_lang, $title, $desc, $budgets, $beneficiary_people, $place_unique, $city, $grantee, $sector, $start_at, $end_at, $info, $tag_uniques, $tag_names, $org_uniques, $type, $project_key = NULL, $project_sort = NULL, $project_value = NULL, $sidebar = NULL)
{
    $unique = generate_unique("projects");
    $startdate = $_POST['p_start_at'];
    $enddate = $_POST['p_end_at'];
    $sql = "
    	INSERT INTO `opentaps`.`projects`(
    		`title`,
    		"/* `description`, */ . "
    		`beneficiary_people`,
    		`city`,
    		`grantee`,
    		`sector`,
    		`start_at`,
    		`end_at`,
    		"/* `info`, */ . "
    		`type`,
	        `lang`,
	        `unique`,
	        `hidden`,
	        `region_unique`,
	        `district_unique`
    	)
    	VALUES(
    		:title,
    		"/* :description, */ . "
    		:beneficiary_people,
    		:city,
    		:grantee,
    		:sector,
    		:start_at,
    		:end_at,
    		"/* :info, */ . "
    		:type,
		:lang,
		:unique,
		:hidden,
		:region_unique,
		:district_unique
    	);
    ";
    $statement = db()->prepare($sql);
    $statement->closeCursor();

    $data = array(
        //':description' => $desc,
        ':beneficiary_people' => $beneficiary_people,
        ':city' => $city,
        ':grantee' => $grantee,
        ':sector' => $sector,
        ':start_at' => ($startdate['year'] . '-' . $startdate['month'] . '-' . ($startdate['day'] < 10 ? '0' . $startdate['day'] : $startdate['day'])),
        ':end_at' => ($enddate['year'] . '-' . $enddate['month'] . '-' . ($enddate['day'] < 10 ? '0' . $enddate['day'] : $enddate['day'])),
        //':info' => $info,
        ':type' => $type,
        //':place_unique' => serialize($place_unique),
        ':unique' => $unique,
        ':hidden' => (isset($_POST['hidden']) ? 1 : 0),
        ':region_unique' => $_POST['region_unique'],
        ':district_unique' => $_POST['district_unique']
    );

    foreach (config('languages') as $lang)
    {
        $data[':title'] = $title . (($adding_lang == $lang) ? NULL : " ({$lang})");
        $data[':lang'] = $lang;
        //foreach ($data as &$d){ $d = "'{$d}'"; } print_r(strtr($sql, $data));// die;
        $success = (bool) $statement->execute($data);
    }

    if ($success)
    {

        connect_project_places($unique, $place_unique);

        if (!empty($org_uniques))
            foreach ($org_uniques as $org_unique)
            {
                $query = "INSERT INTO `project_organizations`(project_unique, organization_unique)
            	      VALUES(:project_unique, :organization_unique);";
                $query = db()->prepare($query);
                $query->closeCursor();
                $query = $query->execute(array(':project_unique' => $unique, ':organization_unique' => $org_unique));
            }

        if (!empty($tag_uniques) OR !empty($tag_names))
        {
            add_tag_connector('proj', $unique, $tag_uniques, $tag_names);
        }

        empty($project_key) OR add_page_data('project', $unique, $project_key, $project_sort, $sidebar, $project_value, $adding_lang);
        if (!empty($budgets))
        {
            list($budgets, $organization, $currency) = $budgets;
            foreach ($budgets AS $idx => $budget)
            {
                if (is_numeric($budget))
                {
                    $sql = "INSERT INTO `project_budgets`(project_unique, organization_unique, budget, currency)
		    	    VALUES(:project_unique, :organization_unique, :budget, :currency);";
                    $query = db()->prepare($sql);
                    $query->closeCursor();
                    $query = $query->execute(array(
                                ':project_unique' => $unique,
                                ':organization_unique' => $organization[$idx],
                                ':currency' => $currency[$idx],
                                ':budget' => $budget
                            ));
                }
            }
        }
    }

    Slim::redirect(href("admin/projects", TRUE));
}

function connect_project_places($unique, $place_unique)
{
    if (!empty($place_unique))
    {
        $place_statement = db()->prepare("INSERT INTO project_places (project_id, place_id) VALUEs(:project_id, :place_id);");
        $place_statement->closeCursor();
        foreach ($place_unique AS $place_id)
        {
            $place_statement->execute(array(
                ':project_id' => $unique,
                ':place_id' => (int) $place_id
            ));
        }
    }
}

function update_project($unique, $title, $desc, $budgets, $beneficiary_people, $place_unique, $city, $grantee, $sector, $start_at, $end_at, $info, $tag_uniques, $tag_names, $org_ids, $type)
{
    $back = "<br /><a href=\"" . href("admin/projects/" . $unique, TRUE) . "\">Back</a>";
    $startdate = $_POST['p_start_at'];
    $enddate = $_POST['p_end_at'];

    if (strlen($title) == 0)
    {
        return;
    }

    $sql = "
    	UPDATE
    		`projects`
    	SET
    		title = :title,
    		description = :description,
    		beneficiary_people = :beneficiary_people,
    		city = :city,
    		grantee = :grantee,
    		sector = :sector,
    		start_at = :start_at,
    		end_at = :end_at,
    		info = :info,
    		type = :type,
		hidden = :hidden,
		region_unique = :region_unique,
		district_unique = :district_unique
    	WHERE
    		`projects`.`unique` = :unique
    	AND
    		projects.lang = '" . LANG . "';
    	DELETE FROM
    		tag_connector
    	WHERE
    		proj_unique = :unique AND lang = '" . LANG . "';
    	DELETE FROM
    		project_budgets
    	WHERE
    		project_unique = :unique;
    	DELETE FROM
    		project_organizations
    	WHERE
    		project_unique = :unique;
        DELETE FROM project_places WHERE project_id = :unique;
    ";
    $statement = db()->prepare($sql);
    $statement->closeCursor();

    $data = array(
        ':unique' => $unique,
        ':title' => $title,
        ':description' => $desc,
        ':beneficiary_people' => $beneficiary_people,
        ':city' => $city,
        ':grantee' => $grantee,
        ':sector' => $sector,
        ':start_at' => ($startdate['year'] . '-' . $startdate['month'] . '-' . ($startdate['day'] < 10 ? '0' . $startdate['day'] : $startdate['day'])),
        ':end_at' => ($enddate['year'] . '-' . $enddate['month'] . '-' . ($enddate['day'] < 10 ? '0' . $enddate['day'] : $enddate['day'])),
        ':info' => $info,
        ':type' => $type,
        //':place_unique' => serialize($place_unique),
        ':hidden' => (isset($_POST['hidden']) ? 1 : 0),
        ':region_unique' => $_POST['region_unique'],
        ':district_unique' => $_POST['district_unique']
    );
    $exec = $statement->execute($data);

    connect_project_places($unique, $place_unique);

    if (!empty($org_ids))
    {
        $sql = "INSERT INTO project_organizations (project_unique, organization_unique) VALUES(:project, :organization);";
        $query = db()->prepare($sql);
        $query->closeCursor();
        foreach ($org_ids AS $org_unique)
        {
            if (!empty($org_unique))
            {
                $query->execute(array(':project' => $unique, ':organization' => $org_unique));
            }
        }
    }


    fetch_db("DELETE FROM tag_connector WHERE proj_unique = :unique AND lang = '" . LANG . "'", array(':unique' => $unique));
    if (!empty($tag_uniques) OR !empty($tag_names))
    {
        add_tag_connector('proj', $unique, $tag_uniques, $tag_names);
    }

    if (!empty($budgets))
    {
        list($budgets, $organization, $currency) = $budgets;
        foreach ($budgets AS $idx => $budget)
        {
            if (is_numeric($budget))
            {
                $sql = "INSERT INTO `project_budgets`(project_unique, organization_unique, budget, currency)
			VALUES(:project_unique, :organization_unique, :budget, :currency);";
                $query = db()->prepare($sql);
                $query->closeCursor();
                $query = $query->execute(array(
                            ':project_unique' => $unique,
                            ':organization_unique' => $organization[$idx],
                            ':currency' => $currency[$idx],
                            ':budget' => $budget
                        ));
            }
        }
    }

    Slim::redirect(href("admin/projects", TRUE));
}

function get_project_place_ids($unique)
{
    $sql = "SELECT place_id FROM project_places WHERE project_id = {$unique};";
    $result = db()->query($sql)->fetchAll();
    if (empty($result))
        return array();
    $ids = array();
    foreach ($result AS $item)
        $ids[] = $item['place_id'];
    return $ids;
}

function delete_project($unique)
{
    if (!is_numeric($unique))
        return "invalid id";

    //$unique = get_unique("projects", $id);
    $sql = "
    		DELETE FROM `projects` WHERE  `projects`.`unique` = :unique;
    		DELETE FROM tag_connector WHERE proj_unique = :unique;
		DELETE FROM project_organizations WHERE project_unique = :unique;
		DELETE FROM pages_data WHERE owner = 'project' AND owner_unique = :unique;
		DELETE FROM project_budgets WHERE project_unique = :unique;
	   ";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $delete = $statement->execute(array(':unique' => $unique));

    //delete_project_data($id);

    if ($delete)
        Slim::redirect(href("admin/projects", TRUE));
    else
        return "couldn't delete record/database error";
}

/* ========================================================================================================== */

function read_page_data($owner, $unique)
{
    $query = "SELECT * FROM pages_data
		  WHERE owner = :owner AND owner_unique = :unique AND lang = '" . LANG . "'
		  ORDER BY `sort`,`unique`;";
    $query = db()->prepare($query);
    $query->closeCursor();
    $query->execute(array(':unique' => $unique, ':owner' => $owner));
    $query = $query->fetchAll();
    empty($query) AND $query = array();
    return $query;
}

function delete_page_data($owner, $unique, $deleting_lang = FALSE)
{
    $sql = "DELETE FROM pages_data WHERE owner = :owner AND owner_unique = :unique";
    $deleting_lang AND $sql .= " AND lang = '" . $deleting_lang . "';";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(':unique' => $unique, ':owner' => $owner));
}

function add_page_data($owner, $owner_unique, $key, $sort, $sidebar, $value, $adding_lang)
{
    //$languages = config('languages');

    $sql = "INSERT INTO `opentaps`.`pages_data` (`key`, `value`, `owner`, owner_unique, `sort`, `sidebar`, lang, `unique`)
	    VALUES (:key, :value, :owner, :owner_unique, :sort, :sidebar, :lang, :unique);";
    $statement = db()->prepare($sql);

    for ($idx = 0, $count = count($key); $idx < $count; $idx++)
    {
        if (empty($key[$idx]) OR empty($value[$idx]))
            continue;
        $statement->closeCursor();
        $unique = generate_unique('pages_data');
        //foreach ($languages as $lang)
        //{
        $data = array(
            ':owner' => $owner,
            ':owner_unique' => $owner_unique,
            ':key' => $key[$idx], // . ((LANG == $lang) ? NULL : " ({$lang})"),
            ':value' => $value[$idx],
            ':sort' => $sort[$idx],
            ':sidebar' => ((!empty($sidebar[$idx]) AND $sidebar[$idx] == "checked") ? 1 : 0),
            ':lang' => $adding_lang,
            ':unique' => $unique
        );
        /*
          array_walk($data, function(&$value)
          {
          $value = "'{$value}'";
          });
          exit(strtr($sql, $data));
         */
        $statement->execute($data);
        //}
    }
}

/* ========================================================================================================== */

//function word_limiter($text, $limit = 30, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzაბგდევზთიკლმნოპჟრსტუფქღყშჩცძწჭხჯჰ0123456789')
function word_limiter($text, $limit = 30)
{
    $chars = implode(NULL, array(
        implode(NULL, range('A', 'Z')),
        implode(NULL, range('a', 'z')),
        implode(NULL, range(0, 9)),
        'აბგდევზთიკლმნოპჟრსტუფქღყშჩცძწჭხჯჰ'
            ));
    if (strlen($text) > $limit)
    {
        $words = str_word_count($text, 2, $chars);
        $words = array_reverse($words, TRUE);
        foreach ($words AS $length => $word)
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

function char_limit($string, $limit = 30)
{
    $enc = mb_detect_encoding($string);
    mb_strlen($string, $enc) > $limit AND $string = mb_substr($string, 0, $limit - 3, $enc) . "...";
    return $string;
}

function json_replace_unicode($string)
{
    $cyrillic = explode(' ', "\u10e6 \u10ef \u10e3 \u10d9 \u10d4 \u10dc \u10d2 \u10e8 \u10ec \u10d6 \u10ee \u10ea \u10e4 \u10eb \u10d5 \u10d7 \u10d0 \u10de \u10e0 \u10dd \u10da \u10d3 \u10df \u10ed \u10e9 \u10e7 \u10e1 \u10db \u10d8 \u10e2 \u10e5 \u10d1 \u10f0");
    $georgian = explode(' ', "ღ ჯ უ კ ე ნ გ შ წ ზ ხ ც ფ ძ ვ თ ა პ რ ო ლ დ ჟ ჭ ჩ ყ ს მ ი ტ ქ ბ ჰ");
    return str_replace($cyrillic, $georgian, $string);
}

function convert_to_chart_array($data, $nameindex, $budgetindex)
{
    $newdata = array();
    if (empty($data) OR !is_array($data))
    {
        return NULL;
    }
    foreach ($data as $d)
    {
        if (!empty($d[$budgetindex]))
        {
            $d[$nameindex] = char_limit($d[$nameindex], 30);
            $newdata[] = array($d[$nameindex], (integer) $d[$budgetindex]);
        }
    }
    //for ($i = 1; $i < 25; $i ++){ $newdata[] = array('test', $i * 250000000); }
    return json_replace_unicode(json_encode($newdata));
    //return json_encode($newdata);
}

function home_chart_data()
{
    $sql = "SELECT
    		o.name,
    		(SELECT SUM(budget)
    		 FROM project_budgets AS pb
    		 WHERE o.`unique` = pb.organization_unique AND currency = 'gel'
    		) AS total_budget
    	    FROM organizations AS o
    	    WHERE o.lang = '" . LANG . "'
    	    ORDER BY total_budget;";

    return convert_to_chart_array(fetch_db($sql), 'name', 'total_budget');
}

function get_project_chart_data($unique)
{
    $results = array();

    $sql = "SELECT
		DISTINCT(orgs.`unique`), orgs.name,
		(SELECT SUM(budget) FROM project_budgets WHERE organization_unique = orgs.`unique` AND currency = 'gel') AS org_total_budget
	    FROM projects
	    INNER JOIN organizations AS orgs
            INNER JOIN project_budgets ON organization_unique = orgs.`unique`
	    WHERE projects.`unique` = :unique AND projects.lang = '" . LANG . "' AND project_unique = :unique AND orgs.lang = '" . LANG . "'
	    ORDER BY org_total_budget;";

    $query = db()->prepare($sql);
    $query->closeCursor();
    $query->execute(array(':unique' => $unique));
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    $data = count($data == 1) ? NULL : convert_to_chart_array($data, 'name', 'org_total_budget');

    $results['organization_projects'] = array(
        'description' => 'Organizations which run this project, ordered by sum of budgets of all their projects.',
        'title' => 'Organization Projects',
        'data' => $data
    );

    $sql = "SELECT
    		projects.`unique`, projects.title,
    		(SELECT SUM(budget) FROM project_budgets WHERE project_unique = projects.`unique` AND currency = 'gel') AS total_budget
	    FROM projects
    	    WHERE projects.lang = '" . LANG . "'
    	    ORDER BY total_budget;";
    $query = db()->prepare($sql);
    $query->closeCursor();
    $query->execute(array(':unique' => $unique));
    $data = convert_to_chart_array($query->fetchAll(PDO::FETCH_ASSOC), 'title', 'total_budget');

    $results['all_projects'] = array(
        'description' => 'All projects ordered by budget.',
        'title' => 'All Projects Budgets',
        'data' => $data
    );

    return $results;
}

/* ================================================	Admin Organizations	============================================ */

function get_organization($unique, $return_total_budget = FALSE)
{
    $tbsql = $return_total_budget ? ",(SELECT SUM(budget) FROM project_budgets WHERE organization_unique = :unique AND currency = 'gel') AS total_budget " : NULL;
    $sql = "SELECT *{$tbsql} FROM organizations WHERE `unique` = :unique AND lang = '" . LANG . "' LIMIT 1;";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(':unique' => $unique));
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function get_organization_projects($unique)
{
    $sql = "SELECT DISTINCT(p.`unique`) AS `unique`, p.id,p.title,p.type FROM projects AS p
	    INNER JOIN project_organizations AS po ON p.`unique` = po.project_unique
	    INNER JOIN organizations AS o ON o.`unique` = po.organization_unique AND o.lang = p.lang
	    WHERE o.`unique` = :unique AND o.lang = '" . LANG . "';";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(
        ':unique' => $unique
    ));

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function count_organization_project_types($unique)
{
    $total_types_count = 0;
    foreach (config('project_types') AS $type)
    {
        $sql = "SELECT COUNT(p.`unique`) AS num FROM projects AS p
		INNER JOIN project_organizations AS po ON p.`unique` = po.project_unique
		INNER JOIN organizations AS o ON o.`unique` = po.organization_unique AND o.lang = p.lang
		WHERE o.`unique` = :unique AND p.type = :type AND o.lang = '" . LANG . "'";
        $statement = db()->prepare($sql);
        $statement->closeCursor();
        $statement->execute(array(
            ':unique' => $unique,
            ':type' => $type
        ));
        $total = $statement->fetch(PDO::FETCH_ASSOC);
        $count[$type] = $total['num'];
        ($count[$type] > 0) AND $total_types_count++;
    }
    return ($total_types_count > 0) ? $count : FALSE;
}

function count_region_project_types($unique)
{
    $total_types_count = 0;
    foreach (config('project_types') AS $type)
    {
        $total = fetch_db("SELECT COUNT(p.id) AS num FROM projects AS p INNER JOIN places AS pl ON pl.`unique` = p.place_unique AND pl.lang = p.lang WHERE pl.`region_unique` = :unique AND p.type = :type AND p.lang = '" . LANG . "';", array(':unique' => $unique, ':type' => $type), TRUE);
        $count[$type] = $total['num'];
        ($count[$type] > 0) AND $total_types_count++;
    }
    return ($total_types_count > 0) ? $count : FALSE;
}

function delete_organization($unique)
{
    $org = get_organization($unique);
    $sql = "DELETE FROM organizations WHERE `unique` = :unique;
	    DELETE FROM pages_data WHERE owner = 'organization' AND owner_unique = :unique;";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(':unique' => $unique));
    if (file_exists($org['logo']))
        unlink($org['logo']);
}

function add_organization($adding_lang, $name, $type, $description, $projects_info, $city_town, $district, $grante, $sector, $tags, $tag_names, $filedata, $org_key = NULL, $org_sort = NULL, $org_value = NULL, $sidebar = NULL)
{
    $up = image_upload($filedata);
    in_array($type, array('donor', 'organization')) OR $type = "organization";

    $unique = generate_unique("organizations");

    $sql = "
	INSERT INTO organizations
	(
	    #name,
	    type,
	    description,
	    district,
	    city_town,
	    grante,
	    sector,
	    projects_info,
	    logo,
	    lang,
	    `unique`,
	    hidden
	)
	VALUES
	(
	    #:name,
	    :type,
	    :description,
	    :district,
	    :city_town,
	    :grante,
	    :sector,
	    :projects_info,
	    :logo,
	    :lang,
	    :unique,
	    :hidden
	);
    ";
    $data = array(
        ':type' => $type,
        ':description' => $description,
        ':projects_info' => $projects_info,
        ':city_town' => $city_town,
        ':district' => $district,
        ':grante' => $grante,
        ':sector' => $sector,
        ':logo' => $up,
        ':unique' => $unique,
        ':hidden' => (isset($_POST['hidden']) ? 1 : 0),
    );

    /*
      array_walk($data, function(&$value)
      {
      $value = "'{$value}'";
      });
      exit(strtr($sql, $data));
     */

    $statement = db()->prepare($sql);
    $statement->closeCursor();

    foreach (config('languages') as $lang)
    {
        $data[':name'] = $name . (($adding_lang == $lang) ? NULL : " ({$lang})");
        $data[':lang'] = $lang;
        $exec = $statement->execute($data);
    }

    if ($exec)
    {
        if (!empty($org_key))
        {
            add_page_data('organization', $unique, $org_key, $org_sort, $sidebar, $org_value, $adding_lang);
        }

        if (!empty($tags) OR !empty($tag_names))
        {
            add_tag_connector('org', $unique, $tags, $tag_names);
        }
    }
}

function edit_organization($unique, $name, $type, $description, $projects_info, $city_town, $district, $grante, $sector, $filedata, $tag_uniques, $tag_names)
{
    $org = get_organization($unique);
    in_array($type, array('donor', 'organization')) OR $type = "organization";

    $up = $org['logo'];
    if ($filedata)
    {
        if ($filedata['size'] > 0)
        {
            file_exists($org['logo']) AND unlink($org['logo']);
            $up = image_upload($filedata);
        }
        elseif (!empty($filedata['delete']) AND $filedata['delete'] == TRUE)
        {
            file_exists($org['logo']) AND unlink($org['logo']);
            $up = NULL;
        }
    }


    //$unique = get_unique("organizations", $id);

    $sql = "UPDATE organizations SET name = :name, type = :type, description = :description, district = :district, city_town = :city_town,
		grante = :grante, sector = :sector, projects_info = :projects_info, hidden = :hidden
		WHERE `unique` = :unique AND lang = '" . LANG . "' LIMIT 1;
	    UPDATE organizations SET logo = :logo WHERE `unique` = :unique;
	    DELETE FROM tag_connector WHERE org_unique = :unique AND lang = '" . LANG . "';";
    $statement = db()->prepare($sql);
    $statement->closeCursor();
    $statement->execute(array(
        ':name' => $name,
        ':type' => $type,
        ':description' => $description,
        ':district' => $district,
        ':city_town' => $city_town,
        ':grante' => $grante,
        ':sector' => $sector,
        ':projects_info' => $projects_info,
        ':unique' => $unique,
        ':logo' => $up,
        ':hidden' => (isset($_POST['hidden']) ? 1 : 0)
    ));

    //$unique = get_unique("organizations", $id);
    //fetch_db("DELETE FROM tag_connector WHERE org_unique = :unique;", array(':unique' => $unique));

    if (!empty($tag_uniques) OR !empty($tag_names))
    {
        add_tag_connector('org', $unique, $tag_uniques, $tag_names);
    }
}

/* ===================================================	  Organizations Fontpage	=============================== */

function organization_total_budget($organization_unique)
{
    $sql = "SELECT
			SUM(project_budgets.budget) AS total_budget
		FROM
			`project_budgets`
		WHERE
			organization_unique = :unique
	";
    $query = db()->prepare($sql);
    $query->closeCursor();
    $query->execute(array(':unique' => $organization_unique));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return number_format($result['total_budget']);
}

function get_organization_chart_data($unique)
{
    $results = array();

    $sql = "SELECT
		DISTINCT(projects.`unique`), projects.title,
		(SELECT SUM(budget) FROM project_budgets
		 WHERE organization_unique = :unique AND project_unique = projects.`unique` AND currency = 'gel')
		 AS budget
	    FROM projects
	    INNER JOIN project_budgets AS pb ON pb.project_unique = projects.`unique`
	    WHERE projects.lang = '" . LANG . "' AND pb.organization_unique = :unique
	    ORDER BY budget";

    $query = db()->prepare($sql);
    $query->closeCursor();
    $query->execute(array(':unique' => $unique));
    $data = convert_to_chart_array($query->fetchAll(PDO::FETCH_ASSOC), 'title', 'budget');

    $results['organization_projects'] = array(
        'description' => 'Projects of this organization.',
        'title' => 'Organization Projects',
        'data' => $data
    );

    $sql = "SELECT org.name, (SELECT SUM(budget) FROM project_budgets WHERE organization_unique = org.`unique` AND currency = 'gel') AS budget
	    FROM organizations AS org WHERE org.lang = '" . LANG . "' ORDER BY budget;";

    $query = db()->prepare($sql);
    $query->closeCursor();
    $query->execute(array(':unique' => $unique));
    $data = convert_to_chart_array($query->fetchAll(PDO::FETCH_ASSOC), 'name', 'budget');

    $results['organizations_budgets'] = array(
        'description' => 'All organizations with their total budget.',
        'title' => 'Organizations Budgets',
        'data' => $data
    );


    /*$sql = "
	select
	r.name,
	(select sum(budget) from project_budgets as pb
	where pb.organization_unique = po.`organization_unique` and pb.project_unique = p.`unique` and currency = 'gel'
	) as budget
	from regions as r
	inner join places as pl on r.`unique` = pl.region_unique
	inner join projects as p on p.place_unique = pl.`unique`
	inner join project_organizations as po on po.project_unique = p.`unique`
	where po.organization_unique = :unique and p.lang = 'ka' and r.lang = 'ka' and pl.lang = 'ka'
    ";

    $query = db()->prepare($sql);
    $query->closeCursor();
    $query->execute(array(':unique' => $unique));
    $data = convert_to_chart_array($query->fetchAll(PDO::FETCH_ASSOC), 'name', 'budget');*/

    $results['budgets_by_year'] = array(
	'description' => '',
	'title' => '',
	'data' => json_encode(array(100,200,300,2100,500,3200))
    );

    return $results;
}

function get_region_chart_data($unique)
{

    $results = array();

    $sql = "select *, (select sum(pb.budget) as budget from projects as p inner join project_budgets as pb on pb.project_unique = p.`unique` inner join places as pl on pl.`unique` = p.place_unique where region_unique = :unique) from organizations as o ";
    $sql = "
	select distinct(o.`unique`), (select sum(budget) from project_budgets as pb where pb.currency = 'gel' and pb.project_unique = p.`unique` and pb.organization_unique = o.`unique`) as org_budget from organizations as o
	inner join projects as p on p.lang = o.lang
	inner join project_organizations as po on po.organization_unique = o.`unique` and po.project_unique = p.`unique`
	inner join places as pl on pl.lang = p.lang and pl.`unique` = p.place_unique where pl.region_unique = :unique and p.lang = '" . LANG . "'
    ";

    $query = db()->prepare($sql);
    $query->closeCursor();
    $query->execute(array(':unique' => $unique));
    $data = convert_to_chart_array($query->fetchAll(PDO::FETCH_ASSOC), 'name', 'budget');

    $results['organizations_budgets'] = array(
        'description' => 'All organizations with their total budget.',
        'title' => 'Organizations Budgets',
        'data' => $data
    );

    return $results;
}

function get_project_organizations($unique)
{
    $query = "SELECT o.name, o.`unique` FROM projects AS p
	      INNER JOIN project_organizations AS po ON po.project_unique = p.`unique`
	      INNER JOIN organizations AS o ON o.lang = p.lang AND o.`unique` = po.organization_unique
	      WHERE p.lang = '" . LANG . "' AND p.`unique` = :unique
	      ORDER BY o.name;";
    $query = db()->prepare($query);
    $query->closeCursor();
    $query->execute(array(':unique' => $unique));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function dateDiff($start, $end)
{
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

function dateformat($date)
{
    $date = is_numeric($date) ? $date : strtotime($date);
    $c = LANG == 'ka';
    $months = array(
        'january' => ($c ? 'იანვარი' : 'January'),
        'february' => ($c ? 'თებერვალი' : 'February'),
        'march' => ($c ? 'მარტი' : 'March'),
        'april' => ($c ? 'აპრილი' : 'April'),
        'may' => ($c ? 'მაისი' : 'May'),
        'june' => ($c ? 'ივნისი' : 'June'),
        'july' => ($c ? 'ივლისი' : 'July'),
        'august' => ($c ? 'აგვისტო' : 'August'),
        'september' => ($c ? 'სექტემბერი' : 'September'),
        'october' => ($c ? 'ოქტომბერი' : 'October'),
        'november' => ($c ? 'ნოემბერი' : 'November'),
        'december' => ($c ? 'დეკემბერი' : 'December'),
    );

    return strtr(strtolower(date('F d, Y', $date)), $months);
}

function change_language($lang)
{
    in_array($lang, Storage::instance()->config['languages']) OR $lang = 'ka';

    /* if (strpos($_SERVER['REQUEST_URI'], "admin") === FALSE)
      {
      return href() . "?lang=" . $lang;
      } */

    list($uri) = explode("?", $_SERVER['REQUEST_URI']);
    $_GET['lang'] = $lang;
    $querystring = NULL;
    foreach ($_GET as $key => $value)
    {
        $querystring .= $key . (empty($value) ? NULL : "=" . $value) . "&";
    }
    $querystring = substr($querystring, 0, -1);
    $uri = $uri . "?" . $querystring;

    return 'http://' . $_SERVER['HTTP_HOST'] . $uri;
}

/*  Admin Water Supply  */

function get_supply($unique)
{
    $sql = "SELECT * FROM water_supply WHERE district_unique = :unique AND lang = '" . LANG . "' LIMIT 1;";
    $stmt = db()->prepare($sql);
    $stmt->execute(array(
        ':unique' => $unique
    ));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_supply($text, $unique)
{
    $ws = get_supply($unique);
    if (empty($ws))
    {
        fetch_db("INSERT INTO water_supply(text, lang, district_unique) VALUES(:text, '" . LANG . "', :wsunique)", array(':text' => $text, ':wsunique' => $unique));
    }
    else
    {
        $sql = "UPDATE water_supply SET text = :text WHERE district_unique = :unique AND lang = '" . LANG . "' LIMIT 1;";
        $stmt = db()->prepare($sql);
        $stmt->execute(array(
            ':text' => $text,
            ':unique' => $unique
        ));
    }
}

function geo_utf8_to_latin($text)
{
    //აბგდევზთიკლმნოპჟრსტუფქღყშჩცძწჭხჯჰ
    $letters = array(
        'ა' => 'a',
        'ბ' => 'b',
        'გ' => 'g',
        'დ' => 'd',
        'ე' => 'e',
        'ვ' => 'v',
        'ზ' => 'z',
        'თ' => 'T',
        'ი' => 'i',
        'კ' => 'k',
        'ლ' => 'l',
        'მ' => 'm',
        'ნ' => 'n',
        'ო' => 'o',
        'პ' => 'p',
        'ჟ' => 'J',
        'რ' => 'r',
        'ს' => 's',
        'ტ' => 't',
        'უ' => 'u',
        'ფ' => 'f',
        'ქ' => 'q',
        'ღ' => 'R',
        'ყ' => 'y',
        'შ' => 'S',
        'ჩ' => 'C',
        'ც' => 'c',
        'ძ' => 'Z',
        'წ' => 'w',
        'ჭ' => 'W',
        'ხ' => 'x',
        'ჯ' => 'j',
        'ჰ' => 'h'
    );
    return str_replace(array_keys($letters), array_values($letters), $text);
}

function string_to_friendly_url($title, $separator = '-')
{
    /*
      $title = preg_replace('/[^ა-ჰa-z0-9_\s-]/', NULL, strtolower($title));
      $title = preg_replace('/[\s-]+/', ' ', $title);
      $title = preg_replace('/[\s_]/', $separator, $title);
      return trim($title);
     */
    $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', NULL, strtolower($title));
    $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);
    return trim($title, $separator);
}
