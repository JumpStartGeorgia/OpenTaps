<?
  echo "
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Tag</div>
  		    <div class='rright'>Manage</div>
  		</div>
  ";

  $tags = read_tags();
  foreach($tags as $tag)
  {
      $link_edit = href("admin/tags/". $tag['unique'], TRUE);
      $link_del = href("admin/tags/". $tag['unique'] . '/delete', TRUE);

      echo "
		<div class='record'>
		  <div class='rleft'> " . $tag['name'] . "</div>
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/tags/new", TRUE) . "\">New Record</a>
  		</div>
  	</div>
  ";
