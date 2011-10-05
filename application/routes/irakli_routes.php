<?php

$news = fetch_db("SELECT n.*,p.longitude,p.latitude FROM news n INNER JOIN places p ON n.place_unique = p.`unique` WHERE places.lang = '" . LANG . "' AND news.lang = '" . LANG . "'");
$js_news = array();
foreach( $news as $new )
    $js_news[] = '[' . $new['unique'] . ',' . $new['longitude'] . ',' . $new['latitude'] .',"' . $new['title'] . '", new Date("' . $new['published_at'] . '") ]';
Storage::instance()->js_news = $js_news;

$projects = fetch_db("SELECT p.*,pl.longitude,pl.latitude FROM projects p INNER JOIN places pl ON p.place_unique = pl.`unique` WHERE p.lang = '" . LANG . "' AND pl.lang = '" . LANG . "'");
$js_projects[] = '[ new Date("' . date('Y-m-d') . '") ]';
foreach($projects as $project)

	$js_projects[] = '[' . $project['unique'] . ', new Date("' . $project['start_at'] . '") , new Date("' . $project['end_at'] . '") , "'. $project['title'] .'", "'. $project['grantee'] .'", "'. $project['budget'] .'", "'. $project['city'] .'","'. $project['type'] .'","'.$project['longitude'] .'","'.$project['latitude'] .'"]';

Storage::instance()->js_projects = $js_projects;

$years_sql = "
    SELECT DISTINCT
        YEAR(start_at) AS start,
        YEAR(end_at) AS end
    FROM
        projects
    ORDER BY
        start_at,
        end_at
    WHERE
    	lang = '" . LANG . "'
    ;
";
$years_res = fetch_db($years_sql);
$years_storage = array();
foreach ($years_res AS $years)
{
    foreach (range($years['start'], $years['end']) AS $year)
        $years_storage[] = $year;
}
Storage::instance()->js_years = array_unique($years_storage);

$types_tmp = array();
$type_img = array('Water Pollution' => 'water-pollution.png','Sewage' => 'sewage.png','Water Supply' => 'water-supply.png','Irrigation' => 'irrigation.png','Water Quality' => 'water-quality.png','Water Accidents' => 'water-accidents.png');
foreach( config('project_types') as $type ){
	if(isset($type_img[$type])){
		$types_tmp[] = array($type,$type_img[$type]);
	}
	else{
		$types_tmp[] = array($type);
	}
}
$types = $types_tmp;
unset($types_tmp);
Storage::instance()->js_types = $types;


require_once DIR.'application/routes/organization_routes.php';

require_once DIR.'application/routes/users_routes.php';

require_once DIR.'application/routes/places_routes.php';

require_once DIR.'application/routes/watersupply_routes.php';


