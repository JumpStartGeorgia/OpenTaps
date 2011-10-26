<?php

Slim::get('/map-data/borders', function()
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

Slim::get('/map-data/regions', function()
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

Slim::get('/map-data/water', function()
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

Slim::get('/map-data/hydro', function()
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
                /*
                  $villages[] = array(
                  'name' => $item['name'],
                  'latitude' => $item['latitude'],
                  'longitude' => $item['longitude']
                  );
                 */

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

Slim::get('/map-data/cities', function()
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

Slim::get('/map-data/projects/:type', function($type)
        {
            $project_sql = "
                SELECT `unique` AS id, title, place_unique
                FROM projects
                WHERE type = '{$type}'
                AND lang = 'en'
;";
            $result = db()->query($project_sql, PDO::FETCH_ASSOC);

            $json = array();

            foreach ($result AS $item)
            {
                $place_ids = $item['place_unique'];
                //$place_ids = unserialize($item['place_unique']);
                //$place_ids = implode(', ', $place_ids);
                $sql = "SELECT name, latitude, longitude FROM places WHERE `unique` IN ($place_ids) AND lang = 'en';";
                $json[] = array(
                    'id' => $item['id'],
                    'title' => $item['title'],
                    'places' => db()->query($sql, PDO::FETCH_ASSOC)->fetchAll()
                );
            }

            exit(json_encode($json));
        }
);
