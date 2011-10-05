<?
  echo "
  	<div class='panel'>
  ";


  foreach($places as $place)
  {
      $link_edit = href("admin/places/". $place['unique'], TRUE);
      $link_del = href("admin/places/". $place['unique'] . '/delete', TRUE);

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
  		    <a href=\"" . href("admin/places/new", TRUE) . "\">New Record</a>
  		</div>
  	</div>
  ";
