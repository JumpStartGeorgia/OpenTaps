<?php


Slim::get('/water_supply/',function()
      {
          Storage::instance()->show_map = FALSE;
          $regions = fetch_db("SELECT * FROM regions WHERE lang = '" . LANG . "'");
          $water_supply = fetch_db("SELECT * FROM water_supply WHERE region_unique = ".$regions[0]['unique']." AND lang = '" . LANG . "' LIMIT 1;");
          Storage::instance()->content = template('water_supply',array(
                                                      'regions' => $regions,
                                                      'water_supply' => $water_supply,
                                                      'region_unique' => $regions[0]['unique']
          ));
      }
);

Slim::get('/water_supply/:unique/', function($unique)
      {
          Storage::instance()->show_map = FALSE;
          $regions = fetch_db("SELECT * FROM regions WHERE lang = '" . LANG . "'");
          $water_supply = fetch_db("SELECT * FROM water_supply WHERE region_unique = :unique AND lang = '" . LANG . "' LIMIT 1;", array(':unique' => $unique));

          $projects = fetch_db("
          	SELECT p.* FROM projects AS p
          	INNER JOIN places AS pl ON pl.lang = p.lang AND pl.`unique` = p.place_unique
          	INNER JOIN regions AS r ON r.`unique` = pl.region_unique AND r.lang = p.lang
          	WHERE r.`unique` = :unique AND p.lang = '" . LANG . "';", array(':unique' => $unique));

          Storage::instance()->content = template('water_supply',array(
                   'regions' => $regions,
                   'water_supply' => $water_supply,
                   'region_unique' => $unique,
                   'projects' => $projects
          ));
      }
);
