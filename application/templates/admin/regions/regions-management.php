<fieldset class="clearfix" style="clear:both;min-height:500px;">
	<legend style="margin-left:10px;">Regions</legend>
<center>
<div style="width:550px;border:1px dashed #000;margin-top:20px;height:36px;"> 
	<!--	 	REGIONS HEADER		 -->
	<div style="border:1px dotted #000;width:495px;height:30px;margin-top:2px;background-color:#CCC;">
		<p style="padding-top:5px;">
			<center>
				<strong>Regions</strong>
			</center>
		</p>
	</div>
	<!--	REGIONS SELECTION	-->
	<form style="height:30px;margin-left:-45px;" method="post" action="">
		
		<select style="float:left;margin-top:30px;margin-left:50px;" name="region">
			<option></option>
			<?php foreach($regions as $region): ?>
				<option <?php
				 if(isset($region_id) && !empty($region_id) && $region['id'] == $region_id) :
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
		<input type="submit"  style="float:left;margin-top:30px;margin-left:25px;" value="Show" />
		
	</form>
		<a href="<?php echo href('admin/regions/add'); ?>"><button>Add Region/Raion</button></a>
		<!--	REGIONS TABLE	-->
		<?php if(isset($raion_data) && !empty($raion_data)):?>
				<table border="0px" id="raion_info">
					<tr>
						<td><center><strong>&nbsp;&nbsp;Parameter&nbsp;&nbsp;</strong></center></td>
						<td><center><strong>Value</strong></center></td>
						<td class="raion_options"><center><strong>Options</strong></center></td>
					</tr>
					<?php foreach($raion_data as $raion_singular_data): ?>						
						<tr>
							<td><center><?php echo $raion_singular_data['field_name']; ?></center></td>
							<td><center><?php echo $raion_singular_data['field_value']; ?></center></td>
							<td>
								<center>
									<a href="<?php echo URL; ?>admin/regions/<?php echo $raion_singular_data['id']; ?>/edit">
										<button>
											edit
										</button>
									</a>
									<a href="<?php echo URL; ?>admin/regions/<?php echo $raion_singular_data['id']; ?>/delete">
										<button>
											delete
										</button>
									</a>
								</center>
							</td>
								
						</tr>
					<?php endforeach;?>		
				</table>
		<?php else: ?>
			<br /><br /><br /><br />
			<p style="float:left;margin-left:0px;margin-top:50px;"><h2>No data for this raion</h2></p>
		<?php endif; ?>
		
</div>

</center>
</fieldset>
