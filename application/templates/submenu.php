<div id="sub_projects_dropdown" class="submenu">
    <table>
        <tr>
            <?php
            //PROJECTS
            $idx = 0;
            $num = count($projects);
            $last_row = TRUE;
            foreach ($projects AS $item):

                $breakable = ($idx % 5 == 4);

                $rem = ($num % 5 == 0) ? 5 : 0;
                $last_row = ($idx >= ($num - ($num % 5) - $rem ));

                echo '<td' . ($last_row ? ' style="border-bottom: 0 none"' : NULL) . ' ><a href="' . href('project/' . $item['unique'], TRUE) . '">' . word_limiter($item['title'], 100) . '</a></td>';
                $breakable AND print '</tr><tr>';
                
                $idx++;

                endforeach;
            echo '<td' . ($last_row ? ' style="border-bottom: 0 none"' : NULL) . '><a href="' . href('projects', TRUE) . '" style="font-weight: bold">' . l('all_projects') . '</a></td>';
            ?>
        </tr>
    </table>
</div>

<div id="sub_organizations_dropdown" class="submenu">
    <table>
        <tr>
            <?php
            //ORGANIZATIONS
            $idx = 0;
            $num = count($organizations);
            foreach ($organizations AS $item):
                $breakable = ($idx % 5 == 4);

                $rem = ($num % 5 == 0) ? 5 : 0;
                $last_row = ($idx >= ($num - ($num % 5) - $rem ));

                echo '<td' . ($last_row ? ' style="border-bottom: 0 none"' : NULL) . ' >
	    		<a href="' . href('organization/' . $item['unique'], TRUE) . '">' . word_limiter($item['name'], 90) . '</a>
	    	      </td>';
                $breakable AND print '</tr><tr>';
                $idx++;
            endforeach;
            ?>
        </tr>
    </table>
</div>

<?php foreach ($submenus AS $parent_unique => $items): ?>

    <div id="sub_<?php echo $parent_unique ?>" class="submenu">
        <table><tr><?php
            $idx = 0;
            $num = count($items);
            foreach ($items AS $item):
                $breakable = ($idx % 5 == 4);

                $rem = ($num % 5 == 0) ? 5 : 0;
                $last_row = ($idx >= ($num - ($num % 5) - $rem ));

                echo '<td' . ($last_row ? ' style="border-bottom: 0 none"' : NULL) . ' >
	    		<a href="' . href('page/' . $item['unique'], TRUE) . '">' . $item['name'] . '</a>
	    	  </td>';
                $breakable AND print '</tr><tr>';
                $idx++;
            endforeach;
            ?></tr></table>
    </div>
    <div id='override_border'></div>
<?php endforeach; ?>

