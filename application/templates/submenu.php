<?php
    $submenus = read_submenu();

    $s = "<div style='display:none'>";
    $s.=  "<table>";
    $s.=     "<tr>";

    $old_parent_id = NULL;

    $i = 0;

    foreach($submenus as $submenu)
    {
    	if($old_parent_id != $submenu['parent_id'])
    	    $s.= "
	    	    	</tr>
	    	     </table>
	    	    </div>
	    	    <div id='sub_".$submenu['parent_id']."' class='submenu'>
    	    	     <table>
	            	<tr>";
	else
	    $i ++;
	$s.= "
	    <td>
		<a href='" . href('page/' . $submenu['id']) . "'>" . ucfirst($submenu['name']) . "</a>
	    </td>
	";
	$s.= ($i % 6 == 1) ? "</tr><tr>" : NULL;
	$old_parent_id = $submenu['parent_id'];
    }

    $s.=     "</tr>";
    $s.=  "</table>";
    $s.= "</div>";

    echo $s;
