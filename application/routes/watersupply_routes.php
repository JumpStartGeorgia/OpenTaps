<?php


Slim::get('/water_supply',function()
      {
          Storage::instance()->show_map = false;
          $regions = fetch_db("SELECT * FROM regions");
          $water_supply = fetch_db("SELECT * FROM water_supply WHERE region_id = ".$regions[0]['id']." LIMIT 1;");
          Storage::instance()->content = template('water_supply',array(
                                                      'regions' => $regions,
                                                      'water_supply' => $water_supply,
                                                      'region_id' => $regions[0]['id']
          ));
      }
);

Slim::get('/water_supply/:id', function($id)
      {
          Storage::instance()->show_map = false;
          $regions = fetch_db("SELECT * FROM regions");
          $water_supply = fetch_db("SELECT * FROM water_supply WHERE region_id = " . $id . " LIMIT 1;");
          Storage::instance()->content = template('water_supply',array(
                   'regions' => $regions,
                   'water_supply' => $water_supply,
                   'region_id' => $id
          ));
      }
);