<?php

################################################################ projects view
Slim::get('/projects/(filter/:filter/)', function($filter = FALSE)
        {
            $posp = config('projects_on_single_page');
            $filter = ($filter AND strlen($filter) > 1) ? ucwords(htmlspecialchars(str_replace('%20', ' ', $filter))) : FALSE;
            $total_pages = projects_total_pages($filter);

            $query = "SELECT DISTINCT tags.id,
			  tags.name,
			  (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique` AND tag_connector.lang = '" . LANG . "')
			  AS total_tags
			  FROM tag_connector
			  JOIN tags ON tag_connector.tag_unique = tags.`unique`
			  JOIN projects ON tag_connector.proj_unique = projects.`unique`
			  WHERE tags.lang = '" . LANG . "' AND projects.lang = '" . LANG . "' AND tag_connector.lang = '" . LANG . "';";
            $query = db()->prepare($query);
            $query->execute();
            $tags = $query->fetchAll(PDO::FETCH_ASSOC);

            Storage::instance()->content = template('projects', array(
                'projects' => read_projects_one_page(0, $posp, 'region', 'ASC', $filter),
                'current_page' => 1,
                'total_pages' => $total_pages,
                'this_order' => 'region',
                'tags' => $tags,
                'direction' => 'asc',
                'filter' => $filter,
                'types' => config('project_types')
                    ));
        });

Slim::get('/project/:unique/', function($unique)
        {
            Storage::instance()->show_project_map = TRUE;
            Storage::instance()->show_chart = array('project' => TRUE);
            $query = "
            	  SELECT DISTINCT(tags.id), tags.name,(SELECT count(id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique` AND tag_connector.lang = '" . LANG . "') AS total_tags
		  FROM tags
		  LEFT JOIN tag_connector ON `tag_unique` = tags.`unique`
		  LEFT JOIN projects ON projects.`unique` = tag_connector.proj_unique
		  WHERE tags.lang = '" . LANG . "' AND projects.lang = '" . LANG . "' AND projects.`unique` = :unique AND tag_connector.lang = '" . LANG . "';";
            $query = db()->prepare($query);
            $query->execute(array(':unique' => $unique));
            $tags = $query->fetchAll(PDO::FETCH_ASSOC);

            $sql = "SELECT * FROM pages_data
		WHERE owner = 'project' AND owner_unique = :unique AND lang = '" . LANG . "' AND `sidebar` = :sidebar
		ORDER BY `sort`,`unique`;";
            $side_data = fetch_db($sql, array(':unique' => $unique, ':sidebar' => 1));
            $data = fetch_db($sql, array(':unique' => $unique, ':sidebar' => 0));

            $budgets = fetch_db("
		SELECT pb.*, o.name FROM project_budgets AS pb INNER JOIN organizations AS o ON o.`unique` = pb.organization_unique WHERE project_unique = :unique AND o.lang = '" . LANG . "' ORDER BY id;", array(':unique' => $unique)
            );

            Storage::instance()->content = template('project', array(
                'project' => read_projects($unique),
                'organizations' => get_project_organizations($unique),
                'data' => $data,
                'chart_data' => get_project_chart_data($unique),
                'side_data' => $side_data,
                'tags' => $tags,
                'edit_permission' => userloggedin(),
                'budgets' => $budgets
                    ));
        });

Slim::get('/projects/page/:page/(filter/:filter/)', function($page, $filter = FALSE)
        {
            ($page > 0) OR die('invalid page');
            $posp = config('projects_on_single_page');
            $filter = ($filter AND strlen($filter) > 1) ? ucwords(htmlspecialchars(str_replace('%20', ' ', $filter))) : FALSE;
            $total_pages = projects_total_pages($filter);
            ($page > $total_pages) AND $page = $total_pages;

            $query = "SELECT DISTINCT tags.id,
			  tags.name,
			  (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique` AND tag_connector.lang = '" . LANG . "')
			  AS total_tags
			  FROM tag_connector
			  JOIN tags ON tag_connector.tag_unique = tags.`unique`
			  JOIN projects ON tag_connector.proj_unique = projects.`unique`
			  WHERE tags.lang = '" . LANG . "' AND projects.lang = '" . LANG . "' AND tag_connector.lang = '" . LANG . "';";
            $query = db()->prepare($query);
            $query->execute();
            $tags = $query->fetchAll(PDO::FETCH_ASSOC);

            Storage::instance()->content = template('projects', array(
                'projects' => read_projects_one_page(($posp * $page - $posp), $posp, 'region', 'ASC', $filter),
                'current_page' => $page,
                'total_pages' => $total_pages,
                'this_order' => 'region',
                'tags' => $tags,
                'direction' => 'asc',
                'filter' => $filter,
                'types' => config('project_types')
                    ));
        });

Slim::get('/projects/order/:order-:direction/(filter/:filter/)', function($order, $direction, $filter = FALSE)
        {
            list($order) = explode("_", strtolower(htmlspecialchars(stripslashes($order))));
            in_array($order, array('region', 'district', 'years', 'categories', 'a-z')) OR die('invalid project ordering');
            in_array(strtolower($direction), array('asc', 'desc')) OR $direction = 'asc';
            $filter = ($filter AND strlen($filter) > 1) ? ucwords(htmlspecialchars(str_replace('%20', ' ', $filter))) : FALSE;
            $total_pages = projects_total_pages($filter);

            $posp = config('projects_on_single_page');

            $query = "SELECT DISTINCT tags.id,tags.name,
			  (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique` AND tag_connector.lang = '" . LANG . "')
			  AS total_tags
			  FROM tag_connector
			  JOIN tags ON tag_connector.tag_unique = tags.`unique`
			  JOIN projects ON tag_connector.proj_unique = projects.`unique`
			  WHERE tags.lang = '" . LANG . "' AND projects.lang = '" . LANG . "' AND tag_connector.lang = '" . LANG . "';";
            $query = db()->prepare($query);
            $query->execute();
            $tags = $query->fetchAll(PDO::FETCH_ASSOC);

            Storage::instance()->content = template('projects', array(
                'projects' => read_projects_one_page(0, $posp, $order, $direction, $filter),
                'current_page' => 1,
                'total_pages' => $total_pages,
                'this_order' => $order,
                'tags' => $tags,
                'direction' => $direction,
                'filter' => $filter,
                'types' => config('project_types')
                    ));
        });

Slim::get('/projects/order/:order-:direction/page/:page/(filter/:filter/)', function($order, $direction, $page, $filter = FALSE)
        {
            list($order) = explode("_", strtolower(htmlspecialchars(stripslashes($order))));
            ($page > 0) OR die('invalid page');
            in_array($order, array('region', 'district', 'years', 'categories', 'a-z')) OR die('invalid project ordering');
            in_array(strtolower($direction), array('asc', 'desc')) OR $direction = 'asc';
            $filter = ($filter AND strlen($filter) > 1) ? ucwords(htmlspecialchars(str_replace('%20', ' ', $filter))) : FALSE;
            $total_pages = projects_total_pages($filter);
            ($page > $total_pages) AND $page = $total_pages;

            $posp = config('projects_on_single_page');

            $query = "SELECT DISTINCT tags.id,tags.name,
			  (SELECT count(tag_connector.id) FROM tag_connector WHERE tag_connector.tag_unique = tags.`unique` AND tag_connector.lang = '" . LANG . "')
			  AS total_tags
			  FROM tag_connector
			  JOIN tags ON tag_connector.tag_unique = tags.`unique`
			  JOIN projects ON tag_connector.proj_unique = projects.`unique`
			  WHERE tags.lang = '" . LANG . "' AND projects.lang = '" . LANG . "' AND tag_connector.lang = '" . LANG . "';";
            $query = db()->prepare($query);
            $query->execute();
            $tags = $query->fetchAll(PDO::FETCH_ASSOC);

            Storage::instance()->content = template('projects', array(
                'projects' => read_projects_one_page(($posp * $page - $posp), $posp, $order, $direction, $filter),
                'current_page' => $page,
                'total_pages' => $total_pages,
                'this_order' => $order,
                'tags' => $tags,
                'direction' => $direction,
                'filter' => $filter,
                'types' => config('project_types')
                    ));
        });

















Slim::post('/exportserver/', function()
        {
            //header('Content-Type: image/svg+xml; charset=UTF-8');
            $_SESSION['svg'] = $_POST['svg'];
            Slim::redirect(href('exportserver', TRUE));
            exit();
        });

Slim::get('/exportserver/', function()
        {
            $svg = $_SESSION['svg'];
            $headers = array(
                'Content-Type' => 'charset=UTF-8',
                'Content-Disposition' => 'attachment; filename=chart'
            );
            foreach ($headers AS $key => $value)
                header("{$key}: {$value}");
            echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
            exit($svg . '</body></html>');
        });

Slim::get('/export/:type/:uniqid/:name/', function($type, $uniqid, $name)
        {
            $name = substr(sha1(uniqid(TRUE) . time() . rand()), 0, 5) . '_' . str_replace(' ', '_', strtolower($name)) . '.' . $type;

            switch ($type)
            {
                /*
                  case 'png':
                  $headers = array(
                  'Content-Type' => 'image/png',
                  'Content-Disposition' => 'attachment; filename=' . $name
                  );
                  foreach ($headers AS $key => $value)
                  header("{$key}: {$value}");

                  $file = fopen(str_replace(' ', '_', base64_decode($data)), 'r');
                  fpassthru($file);
                  fclose($file);
                  break;
                 */
                case 'csv':

                    $data = json_decode($_SESSION[$uniqid], TRUE);
                    $first_row = $_SESSION[$uniqid . '_first_row'];
                    $headers = array(
                        'Content-Type' => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => 'attachment; filename=' . $name
                    );
                    foreach ($headers AS $key => $value)
                        header("{$key}: {$value}");

                    $fp = fopen(DIR . 'uploads/' . $name, 'w');
                    //chmod(DIR . 'uploads/' . $name, 777);

                    fputcsv($fp, $first_row);
                    foreach ($data as $fields)
                    {
                        //foreach ($fields as &$value)
                            //$value = mb_convert_encoding($value, mb_detect_encoding($value), 'UTF-16');
                        //$value = mb_convert_encoding($value, 'SJIS', 'UTF-8');
                        //$value = iconv('', , $value);
                        //$value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                        //$value = iconv("Windows-1252", "UTF-8", $value);
                        fputcsv($fp, $fields);
                    }

                    fclose($fp);

                    $file = fopen(DIR . 'uploads/' . $name, 'r');
                    fpassthru($file);
                    fclose($file);

                    file_exists(DIR . 'uploads/' . $name) AND unlink(DIR . 'uploads/' . $name);

                    /* ## UNSET SESSIONS STORED FOR CHART EXPORTING ##
                      foreach ($_SESSION AS $key => $value)
                      if (substr($key, 0, 8) == 'chartcsv')
                      unset($_SESSION[$key]); */

                    break;
            }

            exit;
        }
);


################################################################ projects admin routes start
Slim::get('/admin/projects/', function()
        {
            Storage::instance()->content = userloggedin() ? template('admin/projects/all_records', array('projects' => read_projects(FALSE, NULL, TRUE))) : template('login');
        });

Slim::get('/admin/projects/new/', function()
        {
            $query = "SELECT * FROM organizations WHERE lang = '" . LANG . "';";
            $orgs = fetch_db($query);
            $regions_query = "SELECT * FROM regions WHERE lang = '" . LANG . "'";
            $regions = fetch_db($regions_query);
            $sql_places = "SELECT * FROM places WHERE lang = '" . LANG . "'";

            $num = count($orgs) - 1;
            $orgnames_jsarray = $orguniques_jsarray = "[";
            foreach ($orgs as $idx => $org)
            {
                $orgnames_jsarray .= '"' . $org['name'] . '"';
                $orguniques_jsarray .= $org['unique'];
                if ($idx != $num)
                {
                    $orgnames_jsarray .= ',';
                    $orguniques_jsarray .= ',';
                }
            }
            $orgnames_jsarray .= "]";
            $orguniques_jsarray .= "]";

            $currency_list = config('currency_list');
            $num = count($currency_list) - 1;
            $currency_list_jsarray = "[";
            foreach ($currency_list as $idx => $currency)
            {
                $currency_list_jsarray .= '"' . $currency . '"';
                ($idx == $num) OR $currency_list_jsarray .= ',';
            }
            $currency_list_jsarray .= "]";

            echo '
    	<script type="text/javascript" language="javascript">
	    var organization_names = ' . $orgnames_jsarray . ',
	    organization_uniques = ' . $orguniques_jsarray . ',
	    currency_list = ' . $currency_list_jsarray . ';
    	</script>
    ';

            Storage::instance()->content = userloggedin() ? template('admin/projects/new', array(
                        'all_tags' => read_tags(),
                        'organizations' => $orgs,
                        'regions' => $regions,
                        'project_types' => config('project_types'),
                        'places' => fetch_db($sql_places),
                        'currency_list' => $currency_list,
                        'project_places' => '',
                        'districts' => fetch_db("SELECT `unique`, name FROM districts_new WHERE lang = '" . LANG . "';")
                    )) : template('login');
        });


Slim::get('/admin/projects/:unique/', function($unique)
        {
            if (userloggedin())
            {
                $orgs = fetch_db("SELECT * FROM organizations WHERE lang = '" . LANG . "';");

                $query = "SELECT organization_unique FROM project_organizations WHERE project_unique = :unique;";
                $query = Storage::instance()->db->prepare($query);
                //$unique = get_unique("projects", $id);
                $query->execute(array(':unique' => $unique));
                $result = $query->fetchAll();
                $this_orgs = array();
                foreach ($result as $s)
                    $this_orgs[] = $s['organization_unique'];

                $num = count($orgs) - 1;
                $orgnames_jsarray = $orguniques_jsarray = "[";
                foreach ($orgs as $idx => $org)
                {
                    $orgnames_jsarray .= '"' . $org['name'] . '"';
                    $orguniques_jsarray .= $org['unique'];
                    if ($idx != $num)
                    {
                        $orgnames_jsarray .= ',';
                        $orguniques_jsarray .= ',';
                    }
                }
                $orgnames_jsarray .= "]";
                $orguniques_jsarray .= "]";

                $currency_list = config('currency_list');
                $num = count($currency_list) - 1;
                $currency_list_jsarray = "[";
                foreach ($currency_list as $idx => $currency)
                {
                    $currency_list_jsarray .= '"' . $currency . '"';
                    ($idx == $num) OR $currency_list_jsarray .= ',';
                }
                $currency_list_jsarray .= "]";

                echo '
		<script type="text/javascript" language="javascript">
		    var organization_names = ' . $orgnames_jsarray . ',
		    organization_uniques = ' . $orguniques_jsarray . ',
		    currency_list = ' . $currency_list_jsarray . ';
		</script>
	';

                $regions = fetch_db("SELECT * FROM regions WHERE lang = '" . LANG . "';");
                $places = fetch_db("SELECT * FROM places WHERE lang = '" . LANG . "';");
                $budgets = fetch_db("SELECT * FROM project_budgets WHERE project_unique = :unique ORDER BY id;", array(':unique' => $unique));
                Storage::instance()->content = template('admin/projects/edit', array
                    (
                    'project' => read_projects($unique),
                    'all_tags' => read_tags(),
                    'this_tags' => read_tag_connector('proj', $unique),
                    'this_orgs' => $this_orgs,
                    'organizations' => $orgs,
                    'regions' => $regions,
                    'project_places' => get_project_place_ids($unique),
                    'places' => $places,
                    'project_types' => config('project_types'),
                    'data' => read_page_data('project', $unique),
                    'budgets' => $budgets,
                    'currency_list' => $currency_list,
                    'districts' => fetch_db("SELECT `unique`, name FROM districts_new WHERE lang = '" . LANG . "';")
                        ));
            }
            else
                Storage::instance()->content = template('login');
        });

Slim::get('/admin/projects/:unique/delete/', function($unique)
        {
            Storage::instance()->content = (userloggedin()) ? delete_project($unique) : template('login');
        });

Slim::post('/admin/projects/create/', function()
        {
            empty($_POST['p_tag_uniques']) AND $_POST['p_tag_uniques'] = array();
            empty($_POST['p_orgs']) AND $_POST['p_orgs'] = array();

            if (empty($_POST['p_budget']) OR empty($_POST['p_budget_org']) OR empty($_POST['p_budget_currency']))
            {
                $budgets = NULL;
            }
            else
            {
                $budgets = array($_POST['p_budget'], $_POST['p_budget_org'], $_POST['p_budget_currency']);
            }

            if (userloggedin())
            {
                !empty($_POST['record_language']) AND in_array($_POST['record_language'], config('languages')) OR $_POST['record_language'] = LANG;
                add_project(
                        $_POST['record_language'], $_POST['p_title'], '', //$_POST['p_desc'],
                        $budgets, $_POST['p_beneficiary_people'] . ' ' . $_POST['p_beneficiary_type'], (empty($_POST['p_place']) ? array() : $_POST['p_place']), $_POST['p_city'], $_POST['p_grantee'], $_POST['p_sector'], $_POST['p_start_at'], $_POST['p_end_at'], '', //$_POST['p_info'],
                        $_POST['p_tag_uniques'], $_POST['p_tag_names'], $_POST['p_orgs'], $_POST['p_type'], (empty($_POST['data_key']) ? NULL : $_POST['data_key']), (empty($_POST['data_sort']) ? NULL : $_POST['data_sort']), (empty($_POST['data_value']) ? NULL : $_POST['data_value']), (empty($_POST['sidebar']) ? NULL : $_POST['sidebar'])
                );
            }
            else
                Storage::instance()->content = template('login');
        });

Slim::post('/admin/projects/:unique/update/', function($unique)
        {
            empty($_POST['p_tag_uniques']) AND $_POST['p_tag_uniques'] = array();
            empty($_POST['p_orgs']) AND $_POST['p_orgs'] = array(NULL);

            if (empty($_POST['p_budget']) OR empty($_POST['p_budget_org']) OR empty($_POST['p_budget_currency']))
            {
                $budgets = NULL;
            }
            else
            {
                $budgets = array($_POST['p_budget'], $_POST['p_budget_org'], $_POST['p_budget_currency']);
            }

            if (userloggedin())
            {
                delete_page_data('project', $unique, LANG);
                if (!empty($_POST['data_key']))
                {
                    add_page_data('project', $unique, $_POST['data_key'], $_POST['data_sort'], $_POST['sidebar'], $_POST['data_value'], LANG);
                }

                update_project(
                        $unique, $_POST['p_title'], '', //$_POST['p_desc'],
                        $budgets, $_POST['p_beneficiary_people'] . ' ' . $_POST['p_beneficiary_type'], (empty($_POST['p_place']) ? NULL : $_POST['p_place']), $_POST['p_city'], $_POST['p_grantee'], $_POST['p_sector'], $_POST['p_start_at'], $_POST['p_end_at'], '', //$_POST['p_info'],
                        $_POST['p_tag_uniques'], $_POST['p_tag_names'], $_POST['p_orgs'], $_POST['p_type']
                );
            }
            else
                Storage::instance()->content = template('login');
        });


Slim::get('/admin/project-tags/:unique/', function($unique)
        {
            if (userloggedin())
            {
                $sql = "SELECT tag_unique FROM tag_connector WHERE proj_unique = :unique AND tag_connector.lang = '" . LANG . "';";
                $statement = Storage::instance()->db->prepare($sql);
                //$unique = get_unique("projects", $id);
                $statement->execute(array(':unique' => $unique));
                $r = $statement->fetchAll();
                $tags = array();
                foreach ($r as $res)
                {
                    $tags[] = $res['tag_unique'];
                }
                //if(empty($tags)) $rags = array();
                Storage::instance()->content = template('admin/projects/project-tags', array(
                    'all_tags' => read_tags(),
                    'this_tags' => $tags,
                    'unique' => $unique
                        ));
            }
            else
                Storage::instance()->content = template('login');
        });

Slim::post('/admin/project-tags/:unique/update/', function($unique)
        {
            if (userloggedin())
            {
                $sql = "DELETE FROM tag_connector where proj_unique = :unique;";
                $statement = Storage::instance()->db->prepare($sql);
                //$unique = get_unique("projects", $unique);
                $delete = $statement->execute(array(':unique' => $unique));
                add_tag_connector('proj', $unique, $_POST['p_tags']);
                Slim::redirect(href('admin/projects', TRUE));
            }
            else
                Storage::instance()->content = template('login');
        });


Slim::get('/admin/project-data/:unique/', function($unique)
        {
            if (userloggedin())
            {
                $r = read_page_data('project', $unique);
                empty($r) AND $r = array(array('key' => NULL, 'value' => NULL, 'owner_unique' => $unique, 'id' => NULL));
                Storage::instance()->content = template('admin/projects/edit_data', array('data' => $r));
            }
            else
                Storage::instance()->content = template('login');
        });

Slim::get('/admin/project-data/:unique/new/', function($unique)
        {
            if (userloggedin())
                Storage::instance()->content = template('admin/projects/new_data', array('unique' => $unique));
            else
                Storage::instance()->content = template('login');
        });
Slim::post('/admin/project-data/:unique/create/', function($unique)
        {
            if (userloggedin())
            {
                empty($_POST['sidebar']) AND $_POST['sidebar'] = NULL;
                add_page_data('project', $unique, $_POST['data_key'], $_POST['data_sort'], $_POST['sidebar'], $_POST['data_value'], LANG);
                Slim::redirect(href('admin/projects', TRUE));
            }
            else
                Storage::instance()->content = template('login');
        });

Slim::post('/admin/project-data/:unique/update/', function($unique)
        {
            if (userloggedin())
            {
                delete_page_data('project', $unique, LANG);
                empty($_POST['sidebar']) AND $_POST['sidebar'] = NULL;
                add_page_data('project', $unique, $_POST['data_key'], $_POST['data_sort'], $_POST['sidebar'], $_POST['data_value'], LANG);
                Slim::redirect(href('admin/projects', TRUE));
            }
            else
                Storage::instance()->content = template('login');
        });









Slim::post('/admin/project-ajax/:unique/:datatype', function($unique, $datatype)
        {
            if (userloggedin() AND !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                switch ($datatype)
                {
                    case "basic_info":
                        $html = template('admin/projects/ajax_edit_project', array(
                            'project' => read_projects($unique),
                            'places' => fetch_db("SELECT * FROM places WHERE lang = '" . LANG . "'"),
                            'types' => config('project_types')
                                ));
                        break;

                    case "project_data":
                        $data = db()->prepare("SELECT * FROM pages_data WHERE owner = 'project' AND lang = '" . LANG . "' AND `unique` = :unique");
                        $data->execute(array(':unique' => $unique));
                        $html = template('admin/projects/ajax_edit_project_data', array(
                            'data' => $data->fetch(PDO::FETCH_ASSOC)
                                ));
                        break;
                }
                die($html);
            }
            else
                die('error');
        });

Slim::post('/admin/project-ajax-save/:unique/:datatype', function($unique, $datatype)
        {
            if (userloggedin() AND !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                switch ($datatype)
                {
                    case "basic_info":
                        $_POST[':unique'] = $unique;
                        $query = "UPDATE projects SET
    		    		city = :city,
    		    		place_unique = :place_unique,
    		    		grantee = :grantee,
    		    		sector = :sector,
    		    		budget = :budget,
    		    		start_at = :start_at,
    		    		end_at = :end_at,
    		    		type = :type
    		    	      WHERE lang = '" . LANG . "' AND `unique` = :unique";
                        $exec = db()->prepare($query)->execute($_POST);
                        break;

                    case "project_data":
                        $_POST[':unique'] = $unique;
                        $query = "UPDATE pages_data SET
    		    		`key` = :key,
    		    		`value` = :value
    		    	      WHERE lang = '" . LANG . "' AND `unique` = :unique AND owner = 'project'";
                        $exec = db()->prepare($query)->execute($_POST);
                        break;
                }
                $html = (bool) $exec ? '<br /><span style="color: green">saved successfully.</span>' : "<br />error";
                die($html);
            }
            else
                die('error');
        });

