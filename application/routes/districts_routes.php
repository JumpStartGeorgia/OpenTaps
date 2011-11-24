<?php

Slim::get('/admin/districts/',function()
	{
		Storage::instance()->show_map = FALSE;
		$districts = fetch_db("SELECT * FROM districts_new WHERE lang = '" . LANG . "'");
		Storage::instance()->content = template('admin/districts/all_records',array(
			'districts' => $districts		
		));
	}
);

   
Slim::get('/admin/districts/:unique/water_supply/', function($id){
            Storage::instance()->content = (userloggedin()) ? 
                    template('admin/districts/water_supply',array(
                        'unique' => $id,
                        'water_supply' => get_supply($id)
                    ))
                    : template('login');
});

Slim::post('/admin/districts/:unique/water_supply/update/', function($id){
        if (userloggedin()){
            update_supply($_POST['pl_water_supply'],$id);
            Slim::redirect(href('admin/districts', TRUE));
        }
        else Storage::instance ()->content = template('login');
});
