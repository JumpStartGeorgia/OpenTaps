<?php

function check_map_data_access()
{
    return;
    if (!Slim::request()->isAjax())
        exit(json_encode(array('error' => 'Incorrect request.')));
}

function db_escape_string($string)
{
    if (empty($string) OR !is_string($string))
        return $string;
    $find = array('\\', "\0", "\n", "\r", "'", '"', "\x1a");
    $replace = array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z');
    return str_replace($find, $replace, $string);
}

Slim::get('/map-data/settlements(/:type)', 'check_map_data_access', function($type = NULL)
        {
            $type = db_escape_string($type);

            $type = empty($type) ? NULL : " WHERE type = '{$type}'";

            $sql = "SELECT name_" . LANG . " AS name, lon, lat FROM map_settlements{$type};";
            $result = db()->query($sql, PDO::FETCH_ASSOC);

            if (empty($result))
                exit(json_encode(array()));

            $geojson = array(
                'type' => 'FeatureCollection',
                'features' => array()
            );

            foreach ($result AS $item)
            {
                $geojson['features'][] = array(
                    'type' => 'Feature',
                    'properties' => array(
                        'name' => $item['name']
                    ),
                    'geometry' => array(
                        'type' => 'Point',
                        'coordinates' => array($item['lat'], $item['lon'])
                    )
                );
            }

            exit(json_encode($geojson));
        }
);

Slim::get('/map-data/projects/:type(/:status)', 'check_map_data_access', function($type, $status = 'all')
        {
            $type = db_escape_string($type);
            $status = db_escape_string($status);

            $type = ucwords(str_replace('_', ' ', trim(strtolower($type))));

            $status_sql = NULL;
            switch ($status)
            {
                case 'completed':
                    $status_sql = "AND DATE(pr.end_at) < CURDATE()";
                    break;
                case 'current':
                    $status_sql = "AND CURDATE() BETWEEN DATE(pr.start_at) AND DATE(pr.end_at)";
                    break;
                case 'scheduled':
                    $status_sql = "AND DATE(pr.start_at) > CURDATE()";
                    break;
            }

            $sql = "
                SELECT
                    pr.`unique` AS id,
                    pr.title,
                    pl.longitude,
                    pl.latitude
                FROM places AS pl
                    INNER JOIN project_places AS pp
                        ON pp.place_id = pl.`unique`
                    INNER JOIN projects AS pr
                        ON pp.project_id = pr.`unique`
                WHERE pr.lang = '" . LANG . "'
                    AND pr.lang = pl.lang
                    AND pr.type = '{$type}'
                    {$status_sql}
            ;";

            $places = db()->query($sql, PDO::FETCH_ASSOC);

            $json = array();

            if (empty($places))
                exit(json_encode($json));

            $json = $places->fetchAll();

            exit(json_encode($json));
        }
);

Slim::get('/map-data/project(/:unique)', 'check_map_data_access', function($unique = NULL)
        {
            $unique = db_escape_string($unique);

            $json = array();

            if (empty($unique))
                exit(json_encode($json));

            $sql = "
                    SELECT pr.*
                    FROM places AS pl
                        INNER JOIN project_places AS pp
                            ON pp.place_id = pl.`unique`
                        INNER JOIN projects AS pr
                            ON pr.`unique` = pp.project_id
                    WHERE pr.`unique` = {$unique}
                        AND pl.lang = '" . LANG . "'
                        AND pr.lang = pl.lang
                    LIMIT 1
            ;";

            $result = db()->query($sql);

            if (empty($result))
                exit(json_encode($json));

            $json = $result->fetch();

            exit(json_encode($json));
        }
);

Slim::get('/map-data/project-coordinates/:unique', 'check_map_data_access', function ( $unique )
        {
            $unique = db_escape_string($unique);
            $json = array();
            $sql = "
			SELECT pl.name,pl.longitude,pl.latitude FROM places pl
				INNER JOIN project_places prl
					ON pl.unique = prl.place_id
			WHERE prl.project_id = :project_unique
				AND pl.lang = :lang
		;";

            $stmt = db()->prepare($sql);
            $stmt->execute(array(
                ':project_unique' => $unique,
                ':lang' => LANG
            ));

            $json = $stmt->fetchAll(PDO::FETCH_ASSOC);
            exit(json_encode($json));
        }
);

Slim::get('/map-data/region-coordinates/:unique', 'check_map_data_access', function ($unique)
        {
            $unique = db_escape_string($unique);
            $json = array();
            $sql = "
				SELECT r.longitude,r.latitude FROM regions r
					 WHERE r.unique = :unique AND r.lang = :lang LIMIT 1
			;";
            $stmt = db()->prepare($sql);
            $stmt->execute(array(
                ':unique' => $unique,
                ':lang' => LANG
            ));
            $json = $stmt->fetchAll(PDO::FETCH_ASSOC);
            exit(json_encode($json));
        }
);

function get_region_projects($region_unique, $type, $status)
{
    $type = ucwords(str_replace('_', ' ', trim(strtolower($type))));
    $status_sql = NULL;
    switch ($status)
    {
        case 'completed':
            $status_sql = "AND DATE(pr.end_at) < CURDATE()";
            break;
        case 'current':
            $status_sql = "AND CURDATE() BETWEEN DATE(pr.start_at) AND DATE(pr.end_at)";
            break;
        case 'scheduled':
            $status_sql = "AND DATE(pr.start_at) > CURDATE()";
            break;
    }
    $sql = "
        SELECT COUNT(pl.id) AS number
        FROM places AS pl
            INNER JOIN project_places AS pp
                ON pp.place_id = pl.`unique`
            INNER JOIN projects AS pr
                ON pr.`unique` = pp.project_id
        WHERE pr.region_unique = {$region_unique}
            AND pl.lang = '" . LANG . "'
            AND pr.lang = pl.lang
        AND pr.type = '{$type}'
        {$status_sql}
    ;";
    $result = db()->query($sql, PDO::FETCH_ASSOC)->fetch();
    if (empty($result))
        return 0;
    return $result['number'];
}

Slim::get('/map-data/cluster-region-projects/(:variations)', 'check_map_data_access', function($variations = NULL)
        {

            empty($variations) AND exit('[]');

            if (strpos($variations, ',') === FALSE)
                $variations = array($variations);
            else
                $variations = explode(',', $variations);

            $temp = array();
            foreach ($variations AS $item)
            {
                if (strpos($item, '-') === FALSE)
                    continue;
                $parts = explode('-', $item);
                $temp[$parts[0]][] = $parts[1];
            }
            $variations = $temp;
            unset($temp);

            $sql = "
                SELECT `unique`, name, longitude, latitude
                FROM regions
                WHERE lang = '" . LANG . "'
            ;";
            $result = db()->query($sql, PDO::FETCH_ASSOC);

            if (empty($result))
                exit(json_encode(array()));

            $json = array();

            foreach ($result AS $region)
            {

                $count = 0;
                foreach ($variations AS $type => $status)
                    $count += get_region_projects($region['unique'], $type, $status);

                //$region['type'] = empty($type_item) ? FALSE : strtolower(str_replace('', '_', $count['type']));
                //$region['status'] = empty($status_item) ? FALSE : $status_item;

                unset($region['unique']);
                $region['places'] = $count;

                $json[] = $region;
            }

            exit(json_encode($json));
        }
);
