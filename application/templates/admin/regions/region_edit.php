<center>
<div style="border:1px dashed #000;width:300px;margin-top:10px;">
			<div style="margin-top:2px;border:1px dotted #000;width:275px;height:30px;background-color:#CCC;">
				<p style="padding-top:5px;"><center><strong>Edit Info</strong></center></p>
			</div>
			
			<form method="POST" action="<?php echo URL.'admin/regions/'.$edit_id.'/edit'; ?>">
				<br />
				<select style="float:left;margin-top:0px;margin-left:10px;" name="region">
					<option></option>
						<?php foreach($regions as $region): ?>
							<option <?php if(isset($region_edit_id) && !empty($region_edit_id) && $region['id'] == $region_edit_id) : ?>
				 					selected="selected"
				 				<?php endif; ?>
				 			 	value="<?php echo $region['id']; ?>"><?php echo $region['name']; ?></option>
						<?php endforeach; ?>
				</select>
				<select style="float:right;margin-top:0px;margin-right:10px;" name="raion">
					<option></option>
					<?php foreach($raions as $raion): ?>
						<option <?php if(isset($raion_edit_id) && !empty($raion_edit_id) && $raion['id'] == $raion_edit_id) : ?>
				 				selected="selected"
				 			<?php	endif; ?>
				 		 value="<?php echo $raion['id']; ?>"><?php echo $raion['name']; ?></option>
					<?php endforeach; ?>
				</select><br /><br />
				<input type="hidden" name="id" value="<?php echo $edit_id; ?>"/>
				<p style="float:left;padding-left:10px;padding-top:5px;">Parameter:</p>
				<input value="<?php echo $edit_parameter; ?>" style="margin-top:5px;margin-left:10px;" type="text" name="parameter_name"/><br />
				<p style="float:left;padding-left:10px;padding-top:5px;">Value:</p>
				<textarea style="margin-left:90px;margin-top:0px;resize:none;" name="value_name" rows="5" cols="19"><?php echo $edit_value; ?></textarea><br />
				<center><input style="margin-top:10px;margin-bottom:10px;" type="submit" value="Edit"/>
				        <a style="text-decoration:none;color:#000;font-size:10pt;" href="<?php echo href('admin/regions'); ?>">Regions</a></center>
			</form>
			
		</div>
</center>
