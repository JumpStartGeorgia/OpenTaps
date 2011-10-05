<?
  echo "
  	<div class='panel'>
  ";
    
  foreach($users as $user)
  {
      $link_edit = href("admin/users/". $user['id'], TRUE);
      $link_del = href("admin/users/". $user['id'] . '/delete', TRUE);

      echo "
		<div class='record'>
		  <div class='rleft'> " . $user['username'] . "</div>
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/users/new", TRUE) . "\">New Record</a>
  		</div>
  	</div>
  ";
