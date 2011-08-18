<?php foreach ($submenus AS $parent_id => $items): ?>

<div id="sub_<?php echo $parent_id ?>" class="submenu">
    <table><tr><?php
        $idx = 0;
        $num = count($items);
        foreach ($items AS $item):
            $breakable = ($idx % 6 == 5);

 	    $last_row = ($idx >= ($num - ($num % 6) - 6 ));

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

