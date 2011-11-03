<?php $num = count($data) - 1; ?>

<div id='project_content'>
	<div class='group' style='float: left; width: 673px;'>
		<div class="group">
		    <img src="<?php echo href() . $image['value'] ?>" style="width: 282px; border: 1px dotted #a6a6a6; padding: 0px; border-top: 0; float: left;" />
		
		    <div id='project_details' style="min-height: 93px;">

			<?php if (!empty($main_data)): ?>
			<div id='project_budget'>
				<p><?php echo $main_data['key'] ?></p>
				<p style='font-size: 27px; color: #FFF;'><?php echo $main_data['value'] ?></p>
			</div>
			<?php else: ?>
			<div id='project_budget' style="height: 93px">
				<p style='font-size: 22px; color: #FFF;'><?php echo strtoupper(l('gp_no_data')) ?></p>
			</div>
			<?php endif; ?>

			<?php foreach ($data as $index => $item): ?>

				<div class='project_details_line' <?php $index == $num AND print 'style="border: 0;"'; ?>>
					<div class='line_left'><?php echo $item['key']; ?> :</div>
					<div><?php echo $item['value']; ?></div>
				</div>

			<?php endforeach; ?>

		    </div>

		<?php userloggedin() AND print("<a class='region_link' style='float: right; display: block; margin-right: 5px;' href='" . href('admin/georgia_profile/', TRUE) . "'>Edit</a>"); ?>

		</div>

		<div style="margin: 25px 0px;">
		    <?php empty($content['value']) OR print $content['value']; ?>
		</div>

	</div>
</div>
