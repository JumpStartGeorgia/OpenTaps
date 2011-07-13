<?
  $menu = read_menu();
  for($i = 0, $c = count($menu); $i < $c; $i ++)
  {
    $style = ($i == 0) ? "style='padding-left:0;'" : "";

    $submenu = read_menu($menu[$i]['id']);
    if(count($submenu) == 0)
    {
        echo "
		<li {$style}>
		    <a href=\"" . href('page/' . $menu[$i]['short_name']) . "\">". strtoupper($menu[$i]['name']) ."</a>
		</li>
        ";
    }
    else
    {
        echo "
		<li {$style}>
		   <a href=\"" . href('page/' . $menu[$i]['short_name']) . "\">" . strtoupper($menu[$i]['name']) . " ▾</a>
		    <ul class='submenu' id='ul_{$menu[$i]['id']}'>
	";
        for($j = 0, $n = count($submenu); $j < $n; $j ++)
        {
            echo "     <li>
            		  <a href=\"" . href('page/' . $submenu[$j]['id']) . "\">".strtoupper($submenu[$j]['name']) ."</a>
            	       </li>";
        }
        echo "      </ul>
                </li>";
     }
  }
?>
