<?
  echo "
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Title</div>
  		    "/*<div class='tcenter'>Description</div>*/. "
  		    <div class='rright'>Manage</div>
  		</div>
  ";

  foreach($projects as $project)
  {
      $link_edit = href("admin/projects/". $project['unique'], TRUE);
      /*$link_add_data = href("admin/project-data/". $project['unique'] . "/new", TRUE);
      $link_edit_data = href("admin/project-data/". $project['unique'], TRUE);*/
      $link_del = href("admin/projects/". $project['unique'] . '/delete', TRUE);
      
      echo "
		<div class='record'" . ((bool) $project['hidden'] ? ' style="background: #90DAF3"' : NULL) . ">
		  <div class='rleft'> " . char_limit($project['title'], 60) . "</div>
		  "/*<div class='rcenter' style='width:60%;'> " . word_limiter(strip_tags($project['description']), 50) . "</div>*/. "
		  <div class='rright' style='width: auto'>
                      <a href=\"" . href() . 'admin/change_visibility/projects/' . $project['id'] . "\">" . ((bool) $project['hidden'] ? 'Show' : 'Hide') . "</a>
		      <a href=\"" . $link_edit . "\">Edit/Show</a>
		      " /*<a href=\"" . $link_add_data . "\">Add Data</a>
		      <a href=\"" . $link_edit_data . "\">List Data</a>*/ . "
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/projects/new", TRUE) . "\">New Record</a>
  		</div>
  	</div>
  ";
