<center>
<div style="border:1px dashed #000;width:300px;">
			<div style="margin-top:2px;border:1px dotted #000;width:275px;height:30px;background-color:#CCC;">
				<p style="padding-top:5px;"><center><strong>Add Info</strong></center></p>
			</div>
			
			<form method="POST" action="<?php echo href('admin/regions/add'); ?>">
				<br />
				<select style="float:left;margin-top:0px;margin-left:10px;" name="region">
					<option></option>
						<?php foreach($regions as $region): ?>
							<option <?php if(isset($region_id) && !empty($region_id) && $region['id'] == $region_id) : ?>
				 					selected="selected"
				 				<?php endif; ?>
				 			 	value="<?php echo $region['id']; ?>"><?php echo $region['name']; ?></option>
						<?php endforeach; ?>
				</select>
				<select style="float:right;margin-top:0px;margin-right:10px;" name="raion">
					<option></option>
					<?php foreach($raions as $raion): ?>
						<option <?php if(isset($raion_id) && !empty($raion_id) && $raion['id'] == $raion_id) : ?>
				 				selected="selected"
				 			<?php	endif; ?>
				 		 value="<?php echo $raion['id']; ?>"><?php echo $raion['name']; ?></option>
					<?php endforeach; ?>
				</select><br /><br />
				<p style="float:left;padding-left:10px;padding-top:5px;">Parameter:</p>
				<input style="margin-top:5px;margin-left:10px;" type="text" name="parameter_name"/><br />
				<p style="float:left;padding-left:10px;padding-top:5px;">Value:</p>
				<textarea style="margin-left:90px;margin-top:0px;resize:none;" name="value_name" rows="5" cols="19"></textarea><br />
				<center><input style="margin-top:10px;margin-bottom:10px;" type="submit" value="Add"/>
					<a style="text-decoration:none;color:#000;font-size:10pt;" href="<?php echo href('admin/regions'); ?>">Regions</a></center>
			</form>
			
		</div>
</center>
