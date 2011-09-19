<div id="sub_projects_dropdown" class="submenu">
    <table>
        <tr>
        <?php							//PROJECTS
            $idx = 0;
            $num = count($projects);
//            fb($num, 'Menu Count');
            foreach ($projects AS $item):
                $breakable = ($idx % 5 == 4);

		$rem = ($num % 5 == 0) ? 5 : 0;
 	        $last_row = ($idx >= ($num - ($num % 5) - $rem ));
//		fb($last_row, $idx . ' last row');

	        echo '<td' . ($last_row ? ' style="border-bottom: 0 none"' : NULL) . ' >
	    		<a href="' . href('project/' . $item['unique']) . '">' . $item['title'] . '</a>
	    	      </td>';
	        $breakable AND print '</tr><tr>';
	        $idx++;
            endforeach;
        ?>
	</tr>
    </table>
</div>

<div id="sub_organizations_dropdown" class="submenu">
    <table>
        <tr>
        <?php							//ORGANIZATIONS
            $idx = 0;
 	    $num = count($organizations);
            foreach ($organizations AS $item):
                $breakable = ($idx % 5 == 4);

		$rem = ($num % 5 == 0) ? 5 : 0;
 	        $last_row = ($idx >= ($num - ($num % 5) - $rem ));

	        echo '<td' . ($last_row ? ' style="border-bottom: 0 none"' : NULL) . ' >
	    		<a href="' . href('organization/' . $item['unique']) . '">' . $item['name'] . '</a>
	    	      </td>';
	        $breakable AND print '</tr><tr>';
	        $idx++;
            endforeach;
        ?>
	</tr>
    </table>
</div>

<?php foreach ($submenus AS $parent_id => $items): ?>

<div id="sub_<?php echo $parent_id ?>" class="submenu">
    <table><tr><?php
        $idx = 0;
        $num = count($items);
        foreach ($items AS $item):
            $breakable = ($idx % 5 == 4);

	    $rem = ($num % 5 == 0) ? 5 : 0;
 	    $last_row = ($idx >= ($num - ($num % 5) - $rem ));

	    echo '<td' . ($last_row ? ' style="border-bottom: 0 none"' : NULL) . ' >
	    		<a href="' . href('page/' . $item['id']) . '">' . $item['name'] . '</a>
	    	  </td>';
	    $breakable AND print '</tr><tr>';
	    $idx++;
        endforeach;
    ?></tr></table>
</div>
<div id='override_border'></div>
<?php endforeach; ?>

