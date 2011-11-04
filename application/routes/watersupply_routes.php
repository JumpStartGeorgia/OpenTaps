<?php


Slim::get('/water_supply/',function()
      {
          Storage::instance()->show_map = FALSE;
          $regions = fetch_db("SELECT * FROM regions WHERE lang = '" . LANG . "'");       
          Storage::instance()->content = template('water_supply',array(
               'regions' => $regions
          ));
      }
);


Slim::get('/water_supply/:unique/', function($unique)
      {
	$water_supply = fetch_db("SELECT * FROM water_supply WHERE district_unique = :unique AND lang = '" . LANG . "' LIMIT 1;", array(':unique' => $unique));

	foreach ($water_supply as $ws)
	{
		echo '<div style="border-radius: 5px; padding: 11px; border: 1px solid rgba(0, 0, 0, .2);">' . $ws['text'] . '</div>';			
	}
	exit;
     }
);


Slim::get('/water_supply/districts/:id', function($id) 
	{
		$districts = fetch_db(
			"SELECT dn.unique id,dn.name name FROM places dn WHERE region_unique= :region_unique AND lang='" . LANG . "'",
			array(':region_unique' => $id)
		);
		exit(json_encode($districts));
	}
);
