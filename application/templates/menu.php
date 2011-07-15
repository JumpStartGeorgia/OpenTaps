<?
  foreach(Storage::instance()->menu as $menu)
  {
    $submenus = read_menu($menu['id']);
    if(count($submenus) == 0)
    {
        echo "
		<li>
		    <a href=\"" . href('page/' . $menu['short_name']) . "\">". strtoupper($menu['name']) ."</a>
		</li>
        ";
    }
    else
    {
        echo "
		<li>
		   <a href=\"" . href('page/' . $menu['short_name']) . "\">
		       " . strtoupper($menu['name']) . " <span style='font-size:10px;'>▾</span></a>
		    <ul class='submenu' id='ul_{$menu['id']}'>
	";
        foreach($submenus as $submenu)
        {
            echo "
             	       <li>
            		  <a href=\"" . href('page/' . $submenu['id']) . "\">".strtoupper($submenu['name']) ."</a>
            	       </li>
            ";
        }
        echo "
	            </ul>
                </li>
        ";
     }
  }
?>
