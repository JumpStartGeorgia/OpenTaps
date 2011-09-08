<?php
/*================================  Admin Users   ======================================*/

Slim::get('/admin/users/',function()
    {
        $sql_users = "SELECT * FROM users";
        Storage::instance()->content = userloggedin()
            ? template('admin/users/all_records',array('users' => fetch_db($sql_users))) : template('login');
    }
);
Slim::get('/admin/users/:id/delete/',function($id)
          {
              if(userloggedin()){
                  delete_user($id);
                  Slim::redirect(href('admin/users'));
              }
              else Storage::instance()->content = template('login');
          }
    );
Slim::get('/admin/users/new/',function()
          {
              if( userloggedin() ){
                  Storage::instance()->content = template('admin/users/new');
              }
              else Storage::instance()->content = template('login');
          }
);
Slim::get('/admin/users/:id/',function($id)
          {
              if( userloggedin() ){
                  Storage::instance()->content = template('admin/users/edit',array('result' => get_user($id)));
              }
              else Storage::instance()->content = template('login');
          }
   );
Slim::post('/admin/users/:id/update/',function($id)
           {
               if( userloggedin() ){
                   update_user($id,$_POST);
                   Slim::redirect(href('admin/users'));
               }
               else Storage::instance()->content = template('login');
           }
   );
Slim::post('/admin/users/create/',function()
          {
              if( userloggedin() ){
                  add_user($_POST);
                  Slim::redirect(href('admin/users'));
              }
              else Storage::instance()->content = template('login');
          }
    );