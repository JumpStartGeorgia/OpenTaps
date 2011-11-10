<?php

Slim::get('/water_supply/', function()
        {
            Storage::instance()->show_map = FALSE;
            $sql = "SELECT * FROM regions WHERE lang = '" . LANG . "';";
            $regions = fetch_db($sql);
            Storage::instance()->content = template('water_supply', array('regions' => $regions));
        }
);

Slim::get('/water_supply/:unique/', function($unique)
        {
            $sql = "SELECT * FROM water_supply WHERE district_unique = :uniq AND lang = '" . LANG . "' LIMIT 1;";
            $result = fetch_db($sql, array(':uniq' => $unique));
            empty($result) AND exit('');
            exit('<div style="border-radius: 5px; padding: 11px; border: 1px solid rgba(0, 0, 0, .2);">' . $result['text'] . '</div>');
        }
);


