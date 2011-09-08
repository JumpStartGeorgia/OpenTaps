<?php

Slim::get('/admin/places/',function()
          {

              if( userloggedin() ) {
                  $sql = "SELECT * FROM places";
                  Storage::instance()->content = template('admin/places/all_records',array('places' => fetch_db($sql)));
              }
              else Storage::instance()->content = template('login');
          }
   );
Slim::get('/admin/places/:id/delete/',function($id)
          {
              if( userloggedin() ){
                  delete_place($id);
                  Slim::redirect( href('admin/places') );
              }
              else Storage::instance()->content = template('login');
          }
    );
Slim::get('/admin/places/new/',function()
          {
              if( userloggedin() ){
                  $sql_regions = "SELECT * FROM regions";
                  $sql_projects = "SELECT * FROM projects";
                  Storage::instance()->content = template('admin/places/new',array('regions'=>fetch_db($sql_regions)));
              }
              else Storage::instance()->content = template('login');
          }
    );
Slim::post('/admin/places/create/',function()
           {
               if( userloggedin() ){
                   add_place($_POST);
                   Slim::redirect( href('admin/places') );
               }
               else Storage::instance()->content = template('login');
           }
   );
Slim::get('/admin/places/:id/',function($id)
          {
              if( userloggedin() ){

                  $sql = "SELECT * FROM places WHERE id=$id";
                  $sql_regions = "SELECT * FROM regions";
                  $sql_regions_this = "SELECT r.id,r.name FROM regions r INNER JOIN places pl ON pl.id = $id AND pl.region_id = r.id ";
                  Storage::instance()->content = template('admin/places/edit',array(
                                                              'place' => fetch_db($sql),
                                                              'regions' => fetch_db($sql_regions),
                                                              'region_this' => fetch_db($sql_regions_this)
                                                              ));
              }
              else Storage::instance()->content = template('login');
          }
    );
Slim::post('/admin/places/:id/update/',function($id)
           {
               if( userloggedin() ){
                   edit_place($id,$_POST);
                   Slim::redirect(href('admin/places'));
               }
               else Storage::instance()->content = template('login');
           }
    );