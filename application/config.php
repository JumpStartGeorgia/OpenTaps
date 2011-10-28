<?php

return array(
    'project_types' => array(
        'Sewage',
        'Water Supply',
        'Water Pollution',
        'Irrigation',
        'Water Quality',
        'Water Accidents'
    ),
    'news_types' => array(
        'text',
        'photo',
        'video',
        'document',
        'chart'
    ),
    'tags_on_single_page' => 15,
    'news_on_single_page' => 15,
    'projects_on_single_page' => 15,
    'about_us_uniques' => array(
        'main' => 7,
        'open_information' => 9,
        'participation' => 10,
        'innovation' => 11
    ),
    'languages' => array('en', 'ka'),
    'undeletable_menu_uniques' => array(
        1,
        7,
        9,
        10,
        11,
        12
    ),
    'whitelist_ips' => array(
        '127.0.0.1',
        '109.238.228.42',
        '109.238.228.*'
    ),
    'currency_list' => array(
	'gel',
	'usd'
    ),
<<<<<<< HEAD
	'getDate' => function($lang='en',$timestring){
		$the_months = array(
			'January' => 'იანვარი',
			'February' => 'თებერვალი',
			'March' => 'მარტი',
			'April' => 'აპრილი',
			'May' => 'მაისი',
			'June' => 'ივნისი',
			'July' => 'ივლისი',
			'August' => 'აგვისტო',
			'September' => 'სექტემბერი',
			'October' => 'ოქტომბერი',
			'November' => 'ნოემბერი',
			'December' => 'დეკემბერი'	
		);
		if( $lang == 'en' )
			return date('F d, Y',strtotime($timestring));			
		else
			return str_replace(array_keys($the_months), $the_months, date('F d, Y',strtotime($timestring)));
	}
=======
    'projects_in_sidebar' => 10
>>>>>>> 093f4f898270447b49f31a797cc5edc72cca8867
);
