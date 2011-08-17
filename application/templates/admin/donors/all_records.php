<?
  echo "
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Title</div>
  		    <div class='tcenter'>Body</div>
  		    <div class='rright'>Manage</div>
  		</div>
  ";

  $donors = read_donors();
  foreach($donors as $donor)
  {
      $link_edit = href("admin/donors/". $donor['id']);
      $link_del = href("admin/donors/". $donor['id'] . '/delete');
      $donor['don_name'] = ( strlen($donor['don_name']) > 12 ) ? substr($donor['don_name'], 0, 9) . "..." : $donor['don_name'];
      $donor['don_desc'] = ( strlen($donor['don_desc']) > 85 ) ? substr($donor['don_desc'], 0, 81) . "..." : $donor['don_desc'];

      echo "
		<div class='record'>
		  <div class='rleft'> " . $donor['don_name'] . "</div>
		  <div class='rcenter'> " . $donor['don_desc'] . "</div>
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit/Show</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/donors/new") . "\">New Record</a>
  		</div>
  	</div>
  ";
