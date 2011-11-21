<?php
/*$f = file_get_contents('regions_districts_withcodes.csv');
$data = explode("\n", $f);
$names = explode(',', $data[0]);
unset($data[0]);
$last = end($data);
if (empty($last))
    array_pop($data);
reset($data);
$grouped = array();
$lastindex = '';
foreach ($data as $key => &$value)
{
    $value = explode(',', str_replace('"', '', $value));
    if ($value[1] == $value[3])
    {
	unset($value[3]);
    }
    if (!empty($grouped[$value[0]]) AND is_array($grouped[$value[0]]))
	array_push($grouped[$value[0]], $value[2]);
    else
	$grouped[$value[0]] = array($value[2]);
}
foreach ($grouped as $key => $group)
{
    $region = fetch_db("select * from regions where name = '" . $key . "'", NULL, TRUE);

    foreach($group as $data)
    {
	$district = fetch_db("select name from districts where name = '" . $data . "';", NULL, TRUE);
	print_r($district['name']);
	fetch_db("update districts set region_unique = " . $region['unique'] . " where name  = '" . $data . "';");
    }
}
die;
$dis = fetch_db("select * from districts where lang = 'en'");
foreach ($dis as $d){ fetch_db("update districts set region_unique = :regun where `unique` = :unique and lang = 'ka';", array(':regun' => $d['region_unique'], ':unique' => $d['unique'])); }*/

Slim::get('/water_supply/', function()
        {
            Storage::instance()->show_map = FALSE;
            $regions = fetch_db("SELECT * FROM regions WHERE lang = '" . LANG . "';");
            Storage::instance()->content = template('water_supply', array('regions' => $regions));
        }
);

Slim::get('/water_supply/district/:unique/', function($unique)
        {
            $districts = fetch_db("select `unique`, name, id from districts_new where `region_unique` = :unique AND lang = '" . LANG . "';", array(':unique' => $unique));
            die(empty($districts) ? json_encode('empty') : json_encode($districts));
        }
);

Slim::get('/water_supply/supply/:unique/', function($unique)
        {
            $sql = "SELECT text FROM water_supply WHERE district_unique = :uniq AND lang = '" . LANG . "';";
            $result = fetch_db($sql, array(':uniq' => $unique));
            $html = '';
            foreach ($result as $ws)
            {
		$html .= '<div style="margin-bottom: 5px; border-radius: 5px; padding: 11px; border: 1px solid rgba(0, 0, 0, .2);">' . $ws['text'] . '</div>';
            }
            exit($html);
        }
);
