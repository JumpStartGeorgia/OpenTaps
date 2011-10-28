<?

echo "
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Menu</div>
  		    <div class='rright'>Manage</div>
  		</div>
  ";

$parents = read_menu(0, NULL, $readhidden = TRUE);
foreach ($parents as $parent)
{
    $link_edit = href("admin/menu/" . $parent['unique'], TRUE);
    if (in_array($parent['unique'], $undeletable_menus))
    {
        $button_del = "<a style='color: #888; cursor: default;'>Delete</a>";
    }
    else
    {
        $link_del = href("admin/menu/" . $parent['unique'] . '/delete', TRUE);
        $button_del = "<a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>";
    }

    echo "
		<div class='record'" . ((bool) $parent['hidden'] ? ' style="background: #90DAF3"' : NULL) . ">
		  <div class='rleft'> " . $parent['name'] . "</div>
		  <div class='rright'>
                      <a href=\"" . href('admin/change_visibility/menu/' . $parent['id'], TRUE) . "\">" . ((bool) $parent['hidden'] ? 'Show' : 'Hide') . "</a>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      " . $button_del . "
		  </div>
		</div>
      ";

    $children = read_menu($parent['unique'], NULL, TRUE);

    foreach ($children as $child)
    {
        $link_edit = href("admin/menu/" . $child['unique'], TRUE);
        if (in_array($child['unique'], $undeletable_menus))
        {
            $button_del = "<a style='color: #888; cursor: default;'>Delete</a>";
        }
        else
        {
            $link_del = href("admin/menu/" . $child['unique'] . '/delete', TRUE);
            $button_del = "<a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>";
        }
        echo "
		<div class='record'" . ((bool) $child['hidden'] ? ' style="background: #90DAF3"' : NULL) . ">
		  <div class='rleftsub'>↳ " . $child['name'] . "</div>
		  <div class='rright'>
                  <a href=\"" . href() . 'admin/change_visibility/menu/' . $child['id'] . "\">" . ((bool) $child['hidden'] ? 'Show' : 'Hide') . "</a>
		      <a href=\"" . $link_edit . "\">Edit</a>
		      " . $button_del . "
		  </div>
		</div>
          ";
    }
}

echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/menu/new", TRUE) . "\">New Record</a>
  		</div>
  	</div>
  ";
