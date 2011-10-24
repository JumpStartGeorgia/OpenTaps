<?php $span = ' <span style="font-size: 10px">▾</span>'; ?>

<li class="dropdownmenu" id="projects_dropdown"><a href="javascript:;"><?php echo strtolower(ucfirst(l('tags_projects'))) . $span ?></a></li>
<li class="dropdownmenu" id="organizations_dropdown"><a href="javascript:;"><?php echo l('organizations') . $span ?></a></li>
<li><a href="<?php echo href('news', TRUE) ?>"><?php echo l('news') ?></a></li>
<li><a href="<?php echo href('georgia_profile', TRUE) ?>"><?php echo l('admin_georgia_profile') ?></a></li>
<?php
foreach (Storage::instance()->menu AS $menu):
    $has = has_submenu($menu['unique']);
    ?>
    <li<?php $has AND print ' class="dropdownmenu"' ?> id="<?php echo $menu['unique'] ?>">
        <a href="<?php echo href('page/' . $menu['short_name'], TRUE) ?>"><?php echo strtoupper($menu['name']) . ($has ? $span : NULL) ?></a>
    </li>
<?php endforeach; ?>

