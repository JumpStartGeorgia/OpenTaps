<?
  echo "
  	<div class='panel'>
  ";


  foreach($places as $place)
  {
      $link_edit = href("admin/places/". $place['unique']);
      $link_del = href("admin/places/". $place['unique'] . '/delete');

      echo "
		<div class='record'>
		  <div class='rleft'> " . $place['name'] . "</div>
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/places/new") . "\">New Record</a>
  		</div>
  	</div>
  ";
