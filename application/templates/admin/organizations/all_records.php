<?

echo "
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Title</div>
  		    "/* <div class='tcenter'>Description</div> */ . "
  		    <div class='rright'>Manage</div>
  		</div>
  ";

foreach ($organizations as $organization)
{
    $link_edit = href("admin/organizations/" . $organization['unique'], TRUE);
    $link_del = href("admin/organizations/" . $organization['unique'] . '/delete', TRUE);
    /* $link_add_data = href("admin/regions-data/". $organization['unique'] . "/new", TRUE);
      $link_edit_data = href("admin/organizations-data/". $organization['unique'], TRUE);
      $organization['description'] = htmlspecialchars($organization['description']);
      $organization['description'] = (strlen($organization['description']) > 70)
      ? substr($organization['description'], 0, 65) . "..."
      : $organization['description']; */

    echo "
		<div class='record'" . ((bool) $organization['hidden'] ? ' style="background: #90DAF3"' : NULL) . ">
		  <div class='rleft'> " . char_limit($organization['name'], 60) . "</div>
		  "/* <div class='rcenter' style='width:61%;'> " . $organization['description'] . "</div> */ . "
		  <div class='rright' style='width:190px'>
                      <a href=\"" . href() . 'admin/change_visibility/organizations/' . $organization['id'] . "\">" . ((bool) $organization['hidden'] ? 'Show' : 'Hide') . "</a>
		      <a href=\"" . $link_edit . "\">Edit/Show</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";
}

echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/organizations/new", TRUE) . "\">New Record</a>
  		</div>
  	</div>
  ";
