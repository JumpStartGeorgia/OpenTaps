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

    $query = "SELECT id FROM tags WHERE name = :name";
    $query = db()->prepare($query);
    $query->execute(array(':name' => $name));
    $id = $query->fetch(PDO::FETCH_ASSOC);
    $id = $id['id'];

    $tosp = config('tags_on_single_page');

    $query = "
    		SELECT
    			" . $table . ".*
    		FROM
    			tag_connector
    		INNER JOIN
    			" . $table . "
    		ON
    			tag_connector." . $prefix . "_id = " . $table . ".id
    		WHERE
    			tag_connector.tag_id = :id
    		LIMIT 0, " . $tosp . ";
    	     ";
    $query = db()->prepare($query);
    $query->execute(array(':id' => $id));
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = "  SELECT COUNT(" . $table . ".id) AS total FROM tag_connector
    		INNER JOIN " . $table . " ON tag_connector." . $prefix . "_id = " . $table . ".id
    		WHERE tag_connector.tag_id = :id;";
    $query = db()->prepare($query);
    $query->execute(array(':id' => $id));
    $total = $query->fetch(PDO::FETCH_ASSOC);
    $total = $total['total'];
    $total_pages = ($total - $total % $tosp) / $tosp + 1;

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

    $query = "SELECT id FROM tags WHERE name = :name";
    $query = db()->prepare($query);
    $query->execute(array(':name' => $name));
    $id = $query->fetch(PDO::FETCH_ASSOC);
    $id = $id['id'];

    $tosp = config('tags_on_single_page');

    $query = "  SELECT COUNT(" . $table . ".id) AS total FROM tag_connector
    		INNER JOIN " . $table . " ON tag_connector." . $prefix . "_id = " . $table . ".id
    		WHERE tag_connector.tag_id = :id;";
    $query = db()->prepare($query);
    $query->execute(array(':id' => $id));
    $total = $query->fetch(PDO::FETCH_ASSOC);
    $total = $total['total'];
    $total_pages = ($total <= $tosp) ? 1 : ($total - $total % $tosp) / $tosp;
    ($page > $total_pages) AND die('invalid page');

    $query = "
    		SELECT
    			" . $table . ".*
    		FROM
    			tag_connector
    		INNER JOIN
    			" . $table . "
    		ON
    			tag_connector." . $prefix . "_id = " . $table . ".id
    		WHERE
    			tag_connector.tag_id = :id
    		LIMIT " . ($tosp * $page - $tosp). ", " . $tosp . ";
    	     ";
    $query = db()->prepare($query);
    $query->execute(array(':id' => $id));
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

Slim::get('/admin/tags/:id/', function($id){
    Storage::instance()->content = userloggedin() ? template('admin/tags/edit', array('result' => read_tags($id))) : template('login');
});

Slim::get('/admin/tags/:id/delete/', function($id){
    Storage::instance()->content = userloggedin() ? delete_tag($id) : template('login');
});

Slim::post('/admin/tags/create/', function(){
    Storage::instance()->content = userloggedin() ? add_tag( $_POST['t_name'] ) : template('login');
});

Slim::post('/admin/tags/:id/update/', function($id){
    Storage::instance()->content = userloggedin() ? update_tag( $id, $_POST['t_name'] ) : template('login');
});
################################################################ tags admin routes end
