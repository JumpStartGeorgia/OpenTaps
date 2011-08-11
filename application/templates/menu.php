<?php

  $span = " <span style='font-size:10px;'>▾</span>";

  foreach(Storage::instance()->menu as $menu)
  {
	$has = has_submenu($menu['id']);
?>
	<li <?php echo $has ? "class='dropdownmenu'" : NULL ?> id='<?php echo $menu['id'] ?>'>
	    <a href="<?php echo href('page/' . $menu['short_name']); ?>">
	    	<?php echo strtoupper($menu['name']) . ($has ? $span : NULL) ?>
	    </a>
	</li>
<?php
  }
