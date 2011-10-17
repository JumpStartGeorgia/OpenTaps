<?php

header('Content-Type: text/html; charset=utf-8');

if (($handle = fopen("Districty_points_with_coordinates.csv", "r")) !== FALSE)
{
    $content = array();
    $i = 0;
    while (($data = fgetcsv($handle, 0, ";")) !== FALSE)
    {
	if ($i == 0)
	{
	    $keys = $data;
	}
	else
	{
	    foreach ($keys as $idx => $key)
	    {
		$content[$i][$key] = $data[$idx];
	    }
        }
	$i ++;
    }
    fclose($handle);
}
$sql = NULL;
/*foreach ($content as $idx => $item)
{
	$sql .= "
		 INSERT INTO regions_from_csv(
				name,
				lang,
				`unique`,
				region_info
		 	)
		 	VALUES(
				'{$item['region_name_ka']}',
				'ka',
				'{$idx}',
				'latitude: {$item['lat']}, longitude: {$item['long']}'
		 	); 
		 INSERT INTO regions_from_csv(
				name,
				lang,
				`unique`,
				region_info
		 	)
			 VALUES(
				'{$item['region_name_en']}',
				'en',
				'{$idx}',
				'latitude: {$item['lat']}, longitude: {$item['long']}'
			 ); ";
}*/
foreach ($content as $idx => $item)
{
	$sql .= "
		 INSERT INTO places_new(
				`unique`,
				lang,
				region,
				district,
				country,
				latitude,
				longitude
		 	)
		 	VALUES(
				'{$idx}',
				'ka',
				'{$item['Region_Eng']}',
				'{$item['distr_ge']}',
				'{$item['Cntry_Eng']}',
				'{$item['x']}',
				'{$item['y']}'
		 	); 
		 INSERT INTO places_new(
				`unique`,
				lang,
				region,
				district,
				country,
				latitude,
				longitude
		 	)
		 	VALUES(
				'{$idx}',
				'en',
				'{$item['Region_Eng']}',
				'{$item['Distr_Eng']}',
				'{$item['Cntry_Eng']}',
				'{$item['x']}',
				'{$item['y']}'
			 ); ";
}

print_r($sql);die;


?>
