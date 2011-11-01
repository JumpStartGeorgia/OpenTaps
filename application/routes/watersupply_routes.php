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


Slim::get('/water_supply/districts/:id', function($id) 
	{
			$districts = fetch_db("SELECT dn.unique id,dn.name name FROM districts_new dn WHERE region_unique= :region_unique AND lang='" . LANG . "'",array(':region_unique' => $id));
			$json = $districts;
			exit(json_encode($json));
	}
);


Slim::get('/water_supply/:unique/', function($unique)
      {
          $water_supply = fetch_db("SELECT * FROM water_supply WHERE district_unique = :unique AND lang = '" . LANG . "' LIMIT 1;", array(':unique' => $unique));
			
			foreach( $water_supply as $ws ){
				echo '<div style="width:100px;height:100px;border:1px solid #000;">' . print_r($ws) . '</div>';			
			}
			exit;
     }
);
