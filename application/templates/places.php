<center>
<div>

 <a href="javascript:hideOthers(['place_list'],['add_places'])"><?php echo l('pl_add_place') ?></a>
 <a href="javascript:hideOthers(['add_places'],['place_list'])"><?php echo l('pl_places') ?></a>
</div>
<div id="add_places" style="display:block;border:1px solid #000;width:500px;height:100px;"> 
	<div style="background-color:#CCC;">Add Places</div>	
	<div>
		<form method="POST" action="">
		Place Longitude:<input  type="text" name="lon"/><br />
		Place Latitude:&nbsp;&nbsp;&nbsp;<input type="text" name="lat"/><br />
		<input type="submit" value="Add"/>
		</form>
	</div>
</div>

<div id="place_list" style="overflow:auto;display:none;border:1px solid #000;width:500px;height:500px;">
	<?php list_places(); ?>
</div>

</center>
