<center>
<div style="border:1px solid #000;width:500px;height:200px;"> 
	<form method="post" action="">
		<select style="float:left;margin-top:30px;margin-left:50px;" name="region">
			<option></option>
			<?php foreach($regions as $region): ?>
				<option <?php
				 if(isset($raion_id) && !empty($raion_id) && $region['id'] == $region_id) :
				 	?>
				 		selected="selected"
				 	<?php
				 endif;
				 ?> value="<?php echo $region['id']; ?>"><?php echo $region['name']; ?></option>
			<?php endforeach; ?>
		</select>
		<select style="float:left;margin-top:30px;margin-left:20px;" name="raion">
			<option></option>
			<?php foreach($raions as $raion): ?>
				<option <?php
				 if(isset($raion_id) && !empty($raion_id) && $raion['id'] == $raion_id) :
				 	?>
				 		selected="selected"
				 	<?php
				 endif;
				 ?> value="<?php echo $raion['id']; ?>"><?php echo $raion['name']; ?></option>
			<?php endforeach; ?>
		</select>
		<input type="submit" style="float:left;margin-top:30px;margin-left:50px;" value="Show" />
	</form>
		<?php if(isset($raion_data) && !empty($raion_data)):?>
				<table border="1px" id="raion_info" style="width:250px;float:left;margin-top:50px;margin-left:50px;">
					<tr>
						<td><center><strong>Prameter</strong></center></td>
						<td><center><strong>Value</strong></center></td>
					</tr>
					<?php foreach($raion_data as $raion_singular_data): ?>						
						<tr>
							<td><center><?php echo $raion_singular_data['field_name']; ?></center></td>
							<td><center><?php echo $raion_singular_data['field_value']; ?></center></td>
							<td><center><a href="/<?php echo $raion_singular_data['id']; ?>/delete"><button>delete</button></a></center></td>
						</tr>
					<?php endforeach;?>		
				</table>
				<a style="float:left;margin-top:5px;margin-left:150px;" href="<?php echo href('admin/regions/add'); ?>"><button>add</button></a>
		<?php else: ?>
			<br /><br /><br /><br />
			<p style="float:left;margin-left:0px;margin-top:50px;"><h2>No data for this raion</h2></p>
		<?php endif; ?>
		
</div>
</center>
