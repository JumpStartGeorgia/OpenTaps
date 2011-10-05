<?
  echo "
  	<div class='panel'>
  ";

  $parents = read_menu(0, NULL, $readhidden = TRUE);
  foreach($parents as $parent)
  {
      $link_edit = href("admin/menu/". $parent['unique'], TRUE);
      $link_del = href("admin/menu/". $parent['unique'] . '/delete', TRUE);

      echo "
		<div class='record'>
		  <div class='rleft'> " . $parent['name'] . "</div>
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";

      $children = read_menu($parent['unique'], NULL, TRUE);

      foreach($children as $child)
      {
          $link_edit = href("admin/menu/". $child['unique'], TRUE);
          $link_del = href("admin/menu/". $child['unique'] . '/delete', TRUE);
          echo "
		<div class='record'>
		  <div class='rleftsub'>↳ " . $child['name'] . "</div>
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
          ";
      }
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/menu/new", TRUE) . "\">New Record</a>
  		</div>
  	</div>
  ";
