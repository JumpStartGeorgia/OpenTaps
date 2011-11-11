<?php
//$span = ' <span style="font-size: 10px">▾</span>';
$span = ' <span style="font-size: 7px; float: left; margin-left: 2px; margin-top: 6px">&#x25BC;</span>';
?>


<li class="dropdownmenu" id="projects_dropdown"><a class="menu-item" href="javascript:;"><div style="<?php echo LANG == 'ka' ? 'font-size:11pt;' : NULL; ?>float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin(l('tags_projects')) : strtoupper(strtolower(l('tags_projects'))) ?></div><?php echo $span ?></a></li>
<li class="dropdownmenu" id="organizations_dropdown"><a class="menu-item" href="javascript:;"><div style="<?php echo LANG == 'ka' ? 'font-size:11pt;' : NULL; ?>float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin(l('organizations')) : strtoupper(strtolower(l('organizations'))) ?></div><?php echo $span ?></a></li>
<li><a class="menu-item" href="<?php echo href('news', TRUE) ?>"><div style="<?php echo LANG == 'ka' ? 'font-size:11pt;' : NULL; ?>float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin(l('news')) : strtoupper(strtolower(l('news'))) ?></div></a></li>
<li><a class="menu-item" href="<?php echo href('georgia_profile', TRUE) ?>"><div style="<?php echo LANG == 'ka' ? 'font-size:11pt;' : NULL; ?>float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin(l('admin_georgia_profile')) : strtoupper(strtolower(l('admin_georgia_profile'))) ?></div></a></li>
<?php
foreach (Storage::instance()->menu AS $menu):
    $has = has_submenu($menu['unique']);
    ?>
    <li<?php $has AND print ' class="dropdownmenu"' ?> id="<?php echo $menu['unique'] ?>">
        <a class="menu-item" href="<?php echo href('page/' . $menu['short_name'], TRUE) ?>"><div style="<?php echo LANG == 'ka' ? 'font-size:11pt;' : NULL; ?>float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin($menu['name']) : strtoupper(strtolower($menu['name'])) ?></div><?php echo $has ? $span : NULL ?></a>
    </li>
<?php endforeach; ?>
