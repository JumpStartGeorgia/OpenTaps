<?php

function check_map_data_access()
{
    return;
    if (!Slim::request()->isAjax())
        exit('Go to hell!');
}

Slim::get('/map-data/settlements(/:type)', 'check_map_data_access', function($type = NULL)
        {
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

            /* foreach ($projects AS $project)
              {
              //$place_ids = $item['place_unique'];
              if (empty($project['place_unique']) OR is_numeric($project['place_unique']))
              $place_ids = $project['place_unique'];
              else
              {
              $place_ids = unserialize($project['place_unique']);
              if (empty($place_ids))
              continue;
              $place_ids = implode(', ', $place_ids);
              }
              $places_sql = "SELECT name, latitude, longitude FROM places WHERE `unique` IN ($place_ids) AND lang = '" . LANG . "';";
              $places = db()->query($places_sql, PDO::FETCH_ASSOC)->fetchAll();
              if (empty($places))
              continue;

              $json[] = array(
              'id' => $project['id'],
              'title' => $project['title'],
              'places' => $places
              );
              } */

            $json = $places->fetchAll();

            exit(json_encode($json));
        }
);

Slim::get('/map-data/project(/:unique)', 'check_map_data_access', function($unique = NULL)
        {
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
        }
);

Slim::get('/map-data/cluster-projects/:type/:status(/:radius)', 'check_map_data_access', function($type, $status, $radius = 10)
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
                SELECT pl.*
                FROM places AS pl
                    INNER JOIN project_places AS pp ON pp.place_id = pl.`unique`
                    INNER JOIN projects AS pr ON pp.project_id = pr.`unique`
                WHERE pl.lang = '" . LANG . "'
                    AND pr.lang = pl.lang
                ;";

            $places = db()->query($sql, PDO::FETCH_ASSOC)->fetchAll();

            $json = array();

            if (empty($places))
                exit(json_encode($json));

            foreach ($places AS $key => &$place)
            {
                $sql = "
                    SELECT DISTINCT pr.`unique`, pr.*
                    FROM projects AS pr
                        INNER JOIN project_places AS pp ON pp.project_id = pr.`unique`
                        INNER JOIN places AS pl ON pp.place_id = {$place['unique']}
                    WHERE pr.lang = '" . LANG . "'
                        AND pr.hidden = 0
                        #AND pr.type = '{$type}'
                        #{$status_sql}
                ;";
                $projects = db()->query($sql, PDO::FETCH_ASSOC)->fetchAll();
                if (empty($projects))
                    continue;
                $place['projects'] = $projects;
                $json[] = $place;
            }

            exit(json_encode($json));
        }
);

Slim::get('/map-data/cluster-region-projects(/:type(/:status))', 'check_map_data_access', function($type = NULL, $status = NULl)
        {

            $type_sql = NULL;
            $type_item = NULL;
            if (!empty($type))
            {
                $type_sql = " AND pr.type = '" . ucwords(str_replace('_', ' ', trim(strtolower($type)))) . "' ";
                $type_item = ", pr.type AS type";
            }

            $status_sql = NULL;
            $status_item = NULL;
            switch ($status)
            {
                case 'completed':
                    $status_sql = "AND DATE(pr.end_at) < CURDATE()";
                    $status_item = 'completed';
                    break;
                case 'current':
                    $status_sql = "AND CURDATE() BETWEEN DATE(pr.start_at) AND DATE(pr.end_at)";
                    $status_item = 'current';
                    break;
                case 'scheduled':
                    $status_sql = "AND DATE(pr.start_at) > CURDATE()";
                    $status_item = 'scheduled';
                    break;
            }

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
                $sql = "
                    SELECT COUNT(pl.id) AS number{$type_item}
                    FROM places AS pl
                        INNER JOIN project_places AS pp
                            ON pp.place_id = pl.`unique`
                        INNER JOIN projects AS pr
                            ON pr.`unique` = pp.project_id
                    #WHERE pl.region_unique = {$region['unique']}
                    WHERE pr.region_unique = {$region['unique']}
                        AND pl.lang = '" . LANG . "'
                        AND pr.lang = pl.lang
                    {$type_sql}
                    {$status_sql}
                ;";

                $count = db()->query($sql, PDO::FETCH_ASSOC)->fetch();

                if (empty($count) OR empty($count['number']))
                    continue; //$count['number'] = 0;

                unset($region['unique']);
                $region['type'] = empty($type_item) ? FALSE : strtolower(str_replace('', '_', $count['type']));
                $region['status'] = empty($status_item) ? FALSE : $status_item;
                $region['places'] = $count['number'];

                $json[] = $region;
            }

            exit(json_encode($json));
        }
);

/*
  Slim::get('/map-data/borders', 'check_access', function()
  {

  $sql = "SELECT state, geometry FROM map_borders;";
  $result = db()->query($sql, PDO::FETCH_ASSOC);

  $geojson = array(
  'type' => 'FeatureCollection',
  'features' => array()
  );

  foreach ($result AS $item)
  {
  $geojson['features'][] = array(
  'type' => 'Feature',
  'properties' => array(
  'state' => $item['state']
  ),
  'geometry' => array(
  'type' => 'Polygon',
  'coordinates' => unserialize($item['geometry'])
  )
  );
  }

  exit(json_encode($geojson));
  }
  );

  Slim::get('/map-data/borders/:state', function($state)
  {

  $sql = "SELECT state, geometry FROM map_borders WHERE state = '{$state}' LIMIT 1;";
  $result = db()->query($sql, PDO::FETCH_ASSOC)->fetch();

  $geojson = array(
  'type' => 'FeatureCollection',
  'features' => array()
  );

  $geojson['features'][] = array(
  'type' => 'Feature',
  'properties' => array(
  'state' => $state
  ),
  'geometry' => array(
  'type' => 'Polygon',
  'coordinates' => unserialize($result['geometry'])
  )
  );

  exit(json_encode($geojson));
  }
  );

  Slim::get('/map-data/regions', 'check_access', function()
  {

  $sql = "SELECT name_eng AS name, geometry FROM map_regions;";
  $result = db()->query($sql, PDO::FETCH_ASSOC);

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
  'type' => 'Polygon',
  'coordinates' => unserialize($item['geometry'])
  )
  );
  }

  exit(json_encode($geojson));
  }
  );

  Slim::get('/map-data/water', 'check_access', function()
  {

  $sql = "SELECT geometry FROM map_water;";
  $result = db()->query($sql, PDO::FETCH_ASSOC);

  $geojson = array(
  'type' => 'FeatureCollection',
  'features' => array()
  );

  foreach ($result AS $item)
  {
  $geojson['features'][] = array(
  'type' => 'Feature',
  //'properties' => array(),
  'geometry' => unserialize($item['geometry'])
  );
  }

  exit(json_encode($geojson));
  }
  );

  Slim::get('/map-data/hydro', 'check_access', function()
  {

  $sql = "SELECT name, latitude, longitude FROM map_hydro;";
  $result = db()->query($sql, PDO::FETCH_ASSOC);

  $stations = array();

  foreach ($result AS $item)
  {
  $stations[] = array(
  'name' => $item['name'],
  'latitude' => $item['latitude'],
  'longitude' => $item['longitude']
  );
  }

  exit(json_encode($stations));
  }
  );

  Slim::get('/map-data/villages/:left/:top/:right/:bottom', function($left, $top, $right, $bottom)
  {

  $sql = "
  SELECT name_eng AS name, latitude, longitude
  FROM map_villages
  WHERE latitude BETWEEN '{$left}' AND '{$right}'
  AND longitude between '{$top}' AND '{$bottom}'
  ;";
  $result = db()->query($sql, PDO::FETCH_ASSOC);

  $villages = array();

  $idx = 0;


  $geojson = array(
  'type' => 'FeatureCollection',
  'features' => array()
  );

  foreach ($result AS $item)
  {
  if ($idx == 100)
  break;
  $villages[] = array(
  'name' => $item['name'],
  'latitude' => $item['latitude'],
  'longitude' => $item['longitude']
  );


  $geojson['features'][] = array(
  'type' => 'Feature',
  'properties' => array(
  'name' => 'name_eng'
  ),
  'geometry' => array(
  'type' => 'Point',
  'coordinates' => array(
  $item['latitude'],
  $item['longitude']
  )
  )
  );

  $idx++;
  }

  exit(json_encode($geojson));
  }
  );

  Slim::get('/map-data/cities', 'check_access', function()
  {
  $sql = "SELECT name_eng AS name, geometry FROM map_cities;";
  $result = db()->query($sql, PDO::FETCH_ASSOC);

  $geojson = array(
  'type' => 'FeatureCollection',
  'features' => array()
  );

  foreach ($result AS $item)
  {
  $geometry = unserialize($item['geometry']);
  $geojson['features'][] = array(
  'type' => 'Feature',
  'properties' => array(
  'name' => $item['name']
  ),
  'geometry' => array(
  'type' => 'Point',
  'coordinates' => array(
  $geometry['coordinates'][0],
  $geometry['coordinates'][1]
  )
  )
  );
  }

  exit(json_encode($geojson));
  }
  );
 */
