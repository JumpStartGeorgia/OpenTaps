<?php
################################################################ Menu admin routes start
Slim::get('/admin/menu/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/menu/all_records');
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/menu/new/', function(){
    if(userloggedin())
	Storage::instance()->content = template('admin/menu/new');
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/menu/:id/', function($id){
    if(userloggedin())
    {
	$sql = "SELECT * FROM menu WHERE id = :id";
	$statement = Storage::instance()->db->prepare($sql);
	$statement->execute(array(':id' => $id));
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	Storage::instance()->content = template('admin/menu/edit', array('id' => $id, 'result' => $result));
    }
    else
	Storage::instance()->content = template('login');
});

Slim::get('/admin/menu/:id/delete/', function($id){
    if(userloggedin())
	if( delete_menu($id) )
	    Storage::instance()->content = "
		<meta http-equiv='refresh' content='0; url=" . href("admin/menu") . "' />
 	    ";
        else
	    Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/menu") . "\">Back</a>
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
        if( add_menu($_POST['m_name'], $_POST['m_short_name'], $_POST['m_parent_id'], $_POST['m_title'], $_POST['m_text'],$hide,$footer ) )
 	    Slim::redirect(href('admin/menu'));
        else
	    Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/menu") . "\">Back</a>
	    ";
        }
    else
	Storage::instance()->content = template('login');
});

Slim::post('/admin/menu/:id/update/', function($id){
        if(userloggedin()){
            if( isset($_POST['m_hide']) ){
                $hide = 0;
            }else $hide = -1;
             if( isset($_POST['m_footer']) ){
                 $footer = 0;
            } else $footer = -1;                
             if( update_menu($id, $_POST['m_name'], $_POST['m_short_name'], $_POST['m_parent_id'], $_POST['m_title'], $_POST['m_text'], $hide, $footer) )
	    Storage::instance()->content = "
		<meta http-equiv='refresh' content='0; url=" . href("admin/menu") . "' />
	    ";
        
	else
	    Storage::instance()->content = "
		invalid data <br />
		<a href=\"" . href("admin/menu") . "\">Back</a>
	    ";
        }
    else
	Storage::instance()->content = template('login');
});
################################################################ Menu admin routes end
