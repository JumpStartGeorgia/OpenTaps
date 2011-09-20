<?php

  $span = " <span style='font-size:10px;'>▾</span>";

?>

  <li class='dropdownmenu' id='projects_dropdown'>
      <a href="#">
	  <?php echo strtoupper('projects') .$span ?>
      </a>
  </li>

  <li class='dropdownmenu' id='organizations_dropdown'>
      <a href="#">
	  <?php echo strtoupper('organizations') .$span ?>
      </a>
  </li>


<?php

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
