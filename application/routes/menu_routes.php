<?php
################################################################ Menu admin routes start
Slim::get('/admin/menu/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/menu/all_records', array(
		'undeletable_menus' => config("undeletable_menu_uniques")
	));
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/menu/new/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/menu/new');
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/menu/:unique/', function($unique){
    if(userloggedin())
    {
	$sql = "SELECT * FROM menu WHERE `unique` = :unique AND lang = '" . LANG . "'";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(':unique' => $unique));
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	Storage::instance()->content = template('admin/menu/edit', array('unique' => $unique, 'result' => $result));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/menu/:unique/delete/', function($unique){
    if(userloggedin())
	if( delete_menu($unique) )
	    Storage::instance()->content = "
		<meta http-equiv='refresh' content='0; url=" . href("admin/menu", TRUE) . "' />
 	    ";
        else
	    Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/menu", TRUE) . "\">Back</a>
	    ";
    else
	Storage::instance()->content = template('login');
});


Slim::post('/admin/menu/create/', function(){
        if(userloggedin()){
        if( isset($_POST['m_hide']) ){
            $hide = 0;
        }else $hide = -1;
        if( isset($_POST['m_footer']) ){
            $footer = 0;
        } else $footer = -1;
        if (add_menu($_POST['m_name'], $_POST['m_short_name'], $_POST['m_parent_unique'], $_POST['m_title'], $_POST['m_text'], $hide, $footer))
 	    Slim::redirect(href('admin/menu', TRUE));
        else
	    Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/menu", TRUE) . "\">Back</a>
	    ";
        }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/menu/:unique/update/', function($unique){
        if(userloggedin()){
            if( isset($_POST['m_hide']) ){
                $hide = 0;
            }else $hide = -1;
             if( isset($_POST['m_footer']) ){
                 $footer = 0;
            } else $footer = -1;                
             update_menu($unique, $_POST['m_name'], $_POST['m_short_name'], $_POST['m_parent_unique'], $_POST['m_title'], $_POST['m_text'], $hide, $footer);
	    Slim::redirect(href("admin/menu", TRUE));
        }
    else
	Storage::instance()->content = template('login');
});
/*############################################################# Menu admin routes end*/
