 
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Title</div>
  		    <?php /* <div class='tcenter'>Description</div>*/ ?>
  		    <div class='rright'>Manage</div>
  		</div>
  
<?php

  foreach($districts as $district)
  {
		$link_supply = href("admin/districts/".$district['unique'].'/water_supply', TRUE);
  ?>

		<div class='record'>
		  <div class='rleft'> <?php echo char_limit($district['name'], 60) ?></div>
		  <div class='rright' style='width:133px'>
		  		<a href="<?php echo $link_supply ?>">Water Supply</a>
		  </div>
		</div>
		
<?php

  }

?>
  
  
