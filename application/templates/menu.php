<?php
//$span = ' <span style="font-size: 10px">▾</span>';
$span = ' <span style="font-size: 10px; float: left; margin-left: 2px; margin-top: 2px">&hearts;</span>';
?>

<li class="dropdownmenu" id="projects_dropdown"><a class="menu-item" href="javascript:;"><div style="float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin(l('tags_projects')) : ucfirst(strtolower(l('tags_projects'))) ?></div><?php echo $span ?></a></li>
<li class="dropdownmenu" id="organizations_dropdown"><a class="menu-item" href="javascript:;"><div style="float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin(l('organizations')) : l('organizations') ?></div><?php echo $span ?></a></li>
<li><a class="menu-item" href="<?php echo href('news', TRUE) ?>"><div style="float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin(l('news')) : l('news') ?></div></a></li>
<li><a class="menu-item" href="<?php echo href('georgia_profile', TRUE) ?>"><div style="float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin(l('admin_georgia_profile')) : l('admin_georgia_profile') ?></div></a></li>
<?php
foreach (Storage::instance()->menu AS $menu):
    $has = has_submenu($menu['unique']);
    ?>
    <li<?php $has AND print ' class="dropdownmenu"' ?> id="<?php echo $menu['unique'] ?>">
        <a class="menu-item" href="<?php echo href('page/' . $menu['short_name'], TRUE) ?>"><div style="float: left"><?php echo LANG == 'ka' ? geo_utf8_to_latin($menu['name']) : strtoupper($menu['name']) ?></div><?php echo $has ? $span : NULL ?></a>
    </li>
<?php endforeach; ?>
