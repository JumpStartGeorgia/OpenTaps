<?php

Slim::get('/admin/places/',function()
          {

              if (userloggedin())
              {
                  $sql = "SELECT * FROM places WHERE lang = '" . LANG . "'";
                  Storage::instance()->content = template('admin/places/all_records',array('places' => fetch_db($sql)));
              }
              else Storage::instance()->content = template('login');
          }
   );
Slim::get('/admin/places/:unique/delete/',function($unique)
          {
              if (userloggedin())
              {
                  delete_place($unique);
                  Slim::redirect( href('admin/places') );
              }
              else Storage::instance()->content = template('login');
          }
    );
Slim::get('/admin/places/new/',function()
          {
              if (userloggedin())
              {
                  $sql_regions = "SELECT * FROM regions WHERE lang = '" . LANG . "'";
                  $sql_projects = "SELECT * FROM projects WHERE lang = '" . LANG . "'";
                  Storage::instance()->content = template('admin/places/new', array('regions'=>fetch_db($sql_regions)));
              }
              else Storage::instance()->content = template('login');
          }
    );
Slim::post('/admin/places/create/',function()
           {
               if (userloggedin())
               {
                   add_place($_POST);
                   Slim::redirect( href('admin/places') );
               }
               else Storage::instance()->content = template('login');
           }
   );
Slim::get('/admin/places/:unique/',function($unique)
          {
              if (userloggedin())
              {
                  $sql = "SELECT * FROM places WHERE `unique` = $unique AND lang = '" . LANG . "'";
                  $sql_regions = "SELECT * FROM regions WHERE lang = '" . LANG . "'";
                  $sql_regions_this = " SELECT r.id,r.`unique`,r.name FROM regions r
                  			INNER JOIN places pl ON pl.`unique` = $unique AND pl.region_unique = r.`unique`
                  			WHERE r.lang = '" . LANG . "' AND pl.lang = '" . LANG . "';";
                  Storage::instance()->content = template('admin/places/edit',array(
                                                              'place' => fetch_db($sql),
                                                              'regions' => fetch_db($sql_regions),
                                                              'region_this' => fetch_db($sql_regions_this)
                                                 ));
              }
              else Storage::instance()->content = template('login');
          }
    );
Slim::post('/admin/places/:unique/update/',function($unique)
           {
               if (userloggedin())
               {
                   edit_place($unique, $_POST);
                   Slim::redirect(href('admin/places'));
               }
               else Storage::instance()->content = template('login');
           }
    );
