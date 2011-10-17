<?php $num = count($data) - 1; ?>

<div id='project_content'>
	<div class='group' style='float: left; width: 673px;'>
		<div id="map" style="width:282px;border:1px dotted #a6a6a6;border-top:0;height:244px;float:left;"></div>
		
		<div id='project_details' style="min-height: 93px;">

			<?php if (!empty($main_data)): ?>
			<div id='project_budget'>
				<p><?php echo $main_data['key'] ?></p>
				<p style='font-size: 27px; color: #FFF;'><?php echo $main_data['value'] ?></p>
			</div>
			<?php else: ?>
			<div id='project_budget' style="height: 93px">
				<p style='font-size: 22px; color: #FFF;'>No Data</p>
			</div>
			<?php endif; ?>

			<?php foreach ($data as $index => $item): ?>

					<div class='project_details_line' <?php $index == $num AND print 'style="border: 0;"'; ?>>
						<div class='line_left'><?php echo $item['key']; ?> :</div>
						<div><?php echo $item['value']; ?></div>
					</div>

			<?php endforeach; ?>
			
		</div>
	</div>
</div>
