<?
  echo "
  	<div class='panel'>
  ";

  $tags = read_tags();
  foreach($tags as $tag)
  {
      $link_edit = href("admin/tags/". $tag['unique']);
      $link_del = href("admin/tags/". $tag['unique'] . '/delete');

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
  		    <a href=\"" . href("admin/tags/new") . "\">New Record</a>
  		</div>
  	</div>
  ";
