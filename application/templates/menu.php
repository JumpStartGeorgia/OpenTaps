<?php
  foreach(Storage::instance()->menu as $menu)
  {
    $submenus = read_menu($menu['id']);
    if(count($submenus) == 0)
    {
        ?>
		<li>
		    <a href="<?php echo href('page/' . $menu['short_name']); ?>"><?php echo strtoupper($menu['name']); ?></a>
		</li>
        <?php
    }
    else
    {
        ?>
		<li>
		   <a href="<?php echo href('page/' . $menu['short_name']); ?>">
		       <?php echo strtoupper($menu['name']); ?>
		       <span style='font-size:10px;'>▾</span>
		   </a>
		   <ul class='submenu' id='ul_<?php echo $menu['id']; ?>'>
	<?php
        foreach($submenus as $submenu)
        {
            ?>
             	       <li>
            		  <a href="<?php href('page/' . $submenu['id']); ?>">
            		      <?php echo strtoupper($submenu['name']); ?>
            		  </a>
            	       </li>
            <?php
        }
        ?>
	            </ul>
                </li>
        <?php
     }
  }
