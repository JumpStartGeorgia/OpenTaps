<center>
<div>

 <a href="<?php echo URL; ?>admin/places/add">add place</a>
 <a href="<?php echo URL; ?>admin/places/list">places</a>
</div>

<?php if(strcmp($places,'add') == 0 || strcmp($places,'edit') == 0): ?>
<div id="add_places" style="display:block;border:1px solid #000;width:500px;height:200px;"> 
	<div style="background-color:#CCC;"><?php echo (strcmp($places,'add') == 0) ? 'Add' : 'Edit'; ?> Places</div>	
		
		<form method="POST" action="<?php echo (strcmp($places,'add') == 0) ? NULL : href('admin/places/list')  ; ?>">
		<?php if(strcmp($places,'edit') == 0): ?>
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<?php endif; ?>
		<div style="margin-top:10px;margin-left:-105px;">
		Place Name:<input style="margin-left:41px;" type="text" <?php echo (strcmp($places,'add') == 0) ? NULL : 'value="'.$place_name.'"'; ?> name="place_name"/><br /><br />
		Place Longitude:<input style="margin-left:11px;"  type="text" name="lon" <?php echo (strcmp($places,'add') == 0) ? NULL : 'value="'.$place_lon.'"'; ?> /><br /><br />
		Place Latitude:<input style="margin-left:24px;" type="text" name="lat" <?php echo (strcmp($places,'add') == 0) ? NULL : 'value="'.$place_lat.'"'; ?>/><br />
		</div>
		
			<select style="float:left;margin-top:30px;margin-left:50px;" name="region">
				<?php foreach($regions as $region): ?>
					<option value="<?php echo $region['id']; ?>"><?php echo $region['name']; ?></option>
				<?php endforeach; ?>
			</select>
			<select style="float:left;margin-top:30px;margin-left:20px;" name="raion">
				<?php foreach($raions as $raion): ?>
					<option value="<?php echo $raion['id']; ?>"><?php echo $raion['name']; ?></option>
				<?php endforeach; ?>
			</select>
			<input type="submit" style="float:left;margin-top:30px;margin-left:30px;" value="<?php echo (strcmp($places,'add') == 0) ? 'add' : 'edit'; ?>" />
		</form>
</div>
<?php elseif(strcmp($places,'list') == 0): ?>
<div id="place_list" style="overflow:auto;border:1px solid #000;width:500px;height:500px;">
	<?php   $sql = "SELECT * FROM places";
		$results = fetch_db($sql);
		if(empty($results)):
	?>
			<h2>No places</h2>
	<?php	else:
		foreach($results as $result):	?>
			<br />
			<div id="<?php echo $result['id']; ?>" style="background-color:#CCC;border:1px solid #000;width:300px;height:120px;">
				<center><strong><?php echo $result['name']; ?></strong></center>
				<p align="left" style="padding-left:10px;">
					<font size="2pt">
						Longitude: <?php echo $result['longitude']; ?>
						<br />
						Latitude: <?php echo $result['latitude']; ?>
						<br />
							<?php 
							$sql_region = "SELECT * FROM regions WHERE id =".$result['region_id']."";
							$sql_raion = "SELECT * FROM raions WHERE id=".$result['raion_id']."";
								$region_result = fetch_db($sql_region); 
								$raion_result = fetch_db($sql_raion);
							?>
							
						Region: <?php echo $region_result[0]['name']; ?>
						<br />
						Raion: <?php echo $raion_result[0]['name']; ?>
					</font>
				</p>
				<p align="right" style="padding-right:10px;">
				   <font size="2pt">
					<a href="<?php echo URL; ?>admin/places/list/<?php echo $result['id']; ?>/edit">edit</a>
					&nbsp;
					<a href="<?php echo URL; ?>admin/places/list/<?php echo $result['id']; ?>/delete">delete</a>
				    </font>
				</p>
			</div>
		<?php
		endforeach;
	endif;
		?>
</div>
<?php endif; ?>

</center>
