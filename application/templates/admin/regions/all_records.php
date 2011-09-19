<?
  echo "
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Title</div>
  		    <div class='tcenter'>Description</div>
  		    <div class='rright'>Manage</div>
  		</div>
  ";

  foreach($regions as $region)
  {
      $link_edit = href("admin/regions/". $region['id']);
      $link_add_data = href("admin/regions-data/". $region['id'] . "/new");
      $link_edit_data = href("admin/regions-data/". $region['id']);
      $link_del = href("admin/regions/". $region['id'] . '/delete');
      $region['name'] = ( strlen($region['name']) > 12 ) ? substr($region['name'], 0, 9) . "..." : $region['name'];
      $region['region_info'] = ( strlen($region['region_info']) > 70 )
      		? substr($region['region_info'], 0, 65) . "..."
      		: $region['region_info'];

      echo "
		<div class='record'>
		  <div class='rleft'> " . $region['name'] . "</div>
		  <div class='rcenter' style='width:61%;'> " . $region['region_info'] . "</div>
		  <div class='rright' style='width:133px'>
		      <a href=\"" . $link_edit . "\">Edit/Show</a>
		      <!--<a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>-->
		  </div>
		</div>
      ";
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/regions/new") . "\">New Record</a>
  		</div>
  	</div>
  ";
