<?
  echo "
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Title</div>
  		    <div class='tcenter'>Description</div>
  		    <div class='rright'>Manage</div>
  		</div>
  ";

  foreach($organizations as $organization)
  {
      $link_edit = href("admin/organizations/". $organization['unique']);
      $link_add_data = href("admin/regions-data/". $organization['unique'] . "/new");
      $link_edit_data = href("admin/organizations-data/". $organization['unique']);
      $link_del = href("admin/organizations/". $organization['unique'] . '/delete');
      $organization['name'] = ( strlen($organization['name']) > 12 ) ? substr($organization['name'], 0, 9) . "..." : $organization['name'];
      $organization['description'] = htmlspecialchars($organization['description']);
      $organization['description'] = (strlen($organization['description']) > 70)
      		? substr($organization['description'], 0, 65) . "..."
      		: $organization['description'];

      echo "
		<div class='record'>
		  <div class='rleft'> " . $organization['name'] . "</div>
		  <div class='rcenter' style='width:61%;'> " . $organization['description'] . "</div>
		  <div class='rright' style='width:133px'>
		      <a href=\"" . $link_edit . "\">Edit/Show</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/organizations/new") . "\">New Record</a>
  		</div>
  	</div>
  ";
