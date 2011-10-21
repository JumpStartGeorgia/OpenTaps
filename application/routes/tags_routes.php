<?php
################################################################ tags show routes start
/*
Slim::get('/tags/', function(){
    Storage::instance()->content = template('tags', array('limit' => false));
});
*/

Slim::get('/tag/:def/:name/', function($def, $name){
     switch( $def ):
        default:
            $prefix = "proj";
            $table = "projects";
            break;
    	case "project":
    	    $prefix = "proj";
    	    $table = "projects";
    	    break;
    	case "news":
    	    $prefix = "news";
    	    $table = "news";
    	    break;
    	case "organization":
    	    $prefix = "org";
    	    $table = "organizations";
    	    break;
    endswitch;

    $query = "SELECT id FROM tags WHERE name = :name AND lang = '" . LANG . "';";
    $query = db()->prepare($query);
    $query->execute(array(':name' => $name));
    $id = $query->fetch(PDO::FETCH_ASSOC);
    $id = $id['id'];

    $tosp = config('tags_on_single_page');
    $unique = get_unique("tags", $id);

    $query = "
    		SELECT
    			" . $table . ".*
    		FROM
    			tag_connector
    		INNER JOIN
    			" . $table . "
    		ON
    			tag_connector." . $prefix . "_unique = " . $table . ".`unique`
    		WHERE
    			tag_connector.tag_unique = :unique AND lang = '" . LANG . "'
    		LIMIT 0, " . $tosp . ";
    	     ";
    $query = db()->prepare($query);
    $query->execute(array(':unique' => $unique));
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = "  SELECT COUNT(" . $table . ".`unique`) AS total FROM tag_connector
    		INNER JOIN " . $table . " ON tag_connector." . $prefix . "_unique = " . $table . ".`unique`
    		WHERE tag_connector.tag_unique = :unique AND lang = '" . LANG . "';";
    $query = db()->prepare($query);
    $query->execute(array(':unique' => $unique));
    $total = $query->fetch(PDO::FETCH_ASSOC);
    $total = $total['total'];
    //$total_pages = ($total - $total % $tosp) / $tosp + 1;
    $total_pages = ($total % $tosp == 0) ? $total / $tosp : ($total + ($tosp - $total % $tosp)) / $tosp;

    Storage::instance()->content = template('tags', array(
    	'results' => $result,
    	'def' => $table,
    	'tag_name' => $name,
    	'current_page' => 1,
    	'total_pages' => $total_pages
    ));
});

Slim::get('/tag/:def/:name/:page/', function($def, $name, $page){
    ($page > 0) OR die('invalid page');

     switch( $def ):
        default:
            $prefix = "proj";
            $table = "projects";
            break;
    	case "project":
    	    $prefix = "proj";
    	    $table = "projects";
    	    break;
    	case "news":
    	    $prefix = "news";
    	    $table = "news";
    	    break;
    	case "organization":
    	    $prefix = "org";
    	    $table = "organizations";
    	    break;
    endswitch;

    $query = "SELECT id FROM tags WHERE name = :name AND lang = '" . LANG . "'";
    $query = db()->prepare($query);
    $query->execute(array(':name' => $name));
    $id = $query->fetch(PDO::FETCH_ASSOC);
    $id = $id['id'];

    $tosp = config('tags_on_single_page');
    $unique = get_unique("tags", $id);

    $query = "  SELECT COUNT(" . $table . ".`unique`) AS total FROM tag_connector
    		INNER JOIN " . $table . " ON tag_connector." . $prefix . "_unique = " . $table . ".`unique`
    		WHERE tag_connector.tag_unique = :unique AND lang = '" . LANG . "';";
    $query = db()->prepare($query);
    $query->execute(array(':unique' => $unique));
    $total = $query->fetch(PDO::FETCH_ASSOC);
    $total = $total['total'];
    //$total_pages = ($total - $total % $tosp) / $tosp + 1;
    $total_pages = ($total % $tosp == 0) ? $total / $tosp : ($total + ($tosp - $total % $tosp)) / $tosp;
    ($page > $total_pages) AND die('invalid page');

    $query = "
    		SELECT
    			" . $table . ".*
    		FROM
    			tag_connector
    		INNER JOIN
    			" . $table . "
    		ON
    			tag_connector." . $prefix . "_unique = " . $table . ".`unique`
    		WHERE
    			tag_connector.tag_unique = :unique AND lang = '" . LANG . "'
    		LIMIT " . ($tosp * $page - $tosp). ", " . $tosp . ";
    	     ";
    $query = db()->prepare($query);
    $query->execute(array(':unique' => $unique));
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    Storage::instance()->content = template('tags', array(
    	'results' => $result,
    	'def' => $table,
    	'tag_name' => $name,
    	'current_page' => $page,
    	'total_pages' => $total_pages
    ));
});

################################################################ tags show routes end

################################################################ tags admin routes start
Slim::get('/admin/tags/', function(){
    Storage::instance()->content = userloggedin() ? template('admin/tags/all_records') : template('login');
});

Slim::get('/admin/tags/new/', function(){
    Storage::instance()->content = userloggedin() ? template('admin/tags/new') : template('login');
});

Slim::get('/admin/tags/:unique/', function($unique){
    Storage::instance()->content = userloggedin()
    	? template('admin/tags/edit', array('result' => read_tags($unique)))
    	: template('login');
});

Slim::get('/admin/tags/:unique/delete/', function($unique){
    Storage::instance()->content = userloggedin() ? delete_tag($unique) : template('login');
});

Slim::post('/admin/tags/create/', function(){
    !empty($_POST['record_language']) AND in_array($_POST['record_language'], config('languages')) OR $_POST['record_language'] = LANG;
    Storage::instance()->content = userloggedin() ? add_tag($_POST['record_language'], $_POST['t_name']) : template('login');
});

Slim::post('/admin/tags/:unique/update/', function($unique){
    Storage::instance()->content = userloggedin() ? update_tag($unique, $_POST['t_name']) : template('login');
});
################################################################ tags admin routes end
