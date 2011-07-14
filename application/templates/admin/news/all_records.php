<?
  echo "
  	<div class='panel'>
  ";

  $parents = Storage::instance()->menu;
  foreach($parents as $parent)
  {
      $link_edit = href("admin/menu/". $parent['id']);
      $link_del = href("admin/menu/". $parent['id'] . '/delete');

      echo "
		<div class='record'>
		  <div class='rleft'> " . $parent['name'] . "</div>
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";

      $children = read_menu($parent['id']);

      foreach($children as $child)
      {
          $link_edit = href("admin/menu/". $child['id']);
          $link_del = href("admin/menu/". $child['id'] . '/delete');
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
  		    <a href=\"" . href("admin/menu/new") . "\">New Record</a>
  		</div>
  	</div>
  ";
