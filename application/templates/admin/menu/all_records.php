<?
  echo "
  	<div class='panel'>
  ";

  $parents = read_menu(0, NULL, $readhidden = TRUE);
  foreach($parents as $parent)
  {
      $link_edit = href("admin/menu/". $parent['unique'], TRUE);
      if (in_array($parent['unique'], $undeletable_menus))
      {
	   $button_del = "<a style='color: #888; cursor: default;'>Delete</a>";
      }
      else
      {
	   $link_del = href("admin/menu/". $parent['unique'] . '/delete', TRUE);
	   $button_del = "<a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>";
      }

      echo "
		<div class='record'>
		  <div class='rleft'> " . $parent['name'] . "</div>
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      " . $button_del . "
		  </div>
		</div>
      ";

      $children = read_menu($parent['unique'], NULL, TRUE);

      foreach($children as $child)
      {
          $link_edit = href("admin/menu/". $child['unique'], TRUE);
          if (in_array($child['unique'], $undeletable_menus))
	  {
		$button_del = "<a style='color: #888; cursor: default;'>Delete</a>";
	  }
	  else
	  {
		$link_del = href("admin/menu/". $child['unique'] . '/delete', TRUE);
		$button_del = "<a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>";
	  }
          echo "
		<div class='record'>
		  <div class='rleftsub'>↳ " . $child['name'] . "</div>
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      " . $button_del . "
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
