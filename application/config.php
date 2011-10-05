<?php

return array(
    'db_host' => 'localhost',
    'db_name' => 'opentaps',
    'db_user' => 'root',
    'db_pass' => 'password',
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
    'whitelist_ips' => array(
        '127.0.0.1',
        '109.238.228.42',
        '109.238.228.*'
    )
);
