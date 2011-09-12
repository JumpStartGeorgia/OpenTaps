<?
  echo "
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Title</div>
  		    <div class='tcenter'>Description</div>
  		    <div class='rright'>Manage</div>
  		</div>
  ";

  foreach($projects as $project)
  {
      $link_edit = href("admin/projects/". $project['id']);
      $link_add_data = href("admin/project-data/". $project['id'] . "/new");
      $link_edit_data = href("admin/project-data/". $project['id']);
      $link_del = href("admin/projects/". $project['id'] . '/delete');
      $project['title'] = ( strlen($project['title']) > 12 ) ? substr($project['title'], 0, 9) . "..." : $project['title'];
      $project['description'] = ( strlen($project['description']) > 70 )
      		? substr($project['description'], 0, 65) . "..."
      		: $project['description'];

      echo "
		<div class='record'>
		  <div class='rleft'> " . $project['title'] . "</div>
		  <div class='rcenter' style='width:60%;'> " . $project['description'] . "</div>
		  <div class='rright' style='width:290px'>
		      <a href=\"" . $link_edit . "\">Edit/Show</a>
		      <a href=\"" . $link_add_data . "\">Add Data</a>
		      <a href=\"" . $link_edit_data . "\">Edit Data</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/projects/new") . "\">New Record</a>
  		</div>
  	</div>
  ";
