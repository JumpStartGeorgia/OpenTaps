
<div id='project_content'>
    <div style='float:left;width:673px;'>
	<div class='group'>
		<?php
		    if (!empty($organization['logo']))
		    {
			$p = substr($organization['logo'], 0, 7);
			if ($p != 'http://' AND $p != 'https:/')
				$logo = URL . $organization['logo'];
			?><div style="width: 282px; float: left;">
				<img width="282px" src="<?php echo $logo; ?>" />
			</div><?php
		    }
		    else
		    {
			?>
			<div style="width: 282px; height: 170px; background: url(<?php echo URL ?>images/bg.jpg); float: left;">
			    <div style="width: 100%; padding-top: 65px; height: 105px; text-align: center; color: #FFF; font-weight: bold; background: rgba(12, 181, 245, 1); letter-spacing: 1px; font-size: 25px;">
				NO LOGO
			    </div>
			</div>
			<?php
		    }
		?>

		
		<div id='project_details' style="min-height:150px;">
			<div id='project_budget'>
				<p>Overall Project Budget</p>
				<p style='font-size:27px;color:#FFF;'><?php echo $organization_budget ?></p>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					District :
				</div>
				<div>
					<?php echo $organization['district']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					City/Town :
				</div>
				<div>
					<?php echo $organization['city_town']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Grante :
				</div>
				<div>
					<?php echo $organization['grante']; ?>
				</div>
			</div>
			<div class='project_details_line' style='border-bottom:0px;'>
				<div class='line_left'>
					Sector :
				</div>
				<div>
					<?php echo $organization['sector']; ?>
				</div>
			</div>
			
		</div>
	</div>

	<div id='project_description' style="margin-top:75px;">
		<p class='desc'>ORGANIZATION DESCRIPTION</p>
		<div><?php echo $organization['description']; ?></div>

		<div style="width: 100%; border-top: 1px solid rgba(12, 181, 245, .5); height: 0px"></div>

		<?php /*<p class='desc'>INFO ON PROJECTS</p>*/ ?>
		<div><?php echo $organization['projects_info']; ?></div>

		<?php foreach ($data as $d): ?>
			<p class='desc'><?php echo strtoupper($d['key']); ?></p>
			<div><?php echo $d['value']; ?></div>
		<?php endforeach; ?>

		<?php if ($count !== FALSE AND is_array($count)): ?>
		    <div id="organization_project_types" class="group">
		    <?php foreach (config('project_types') AS $type): ?>
			    <?php if ($count[$type] == 0) continue; ?>
			    <a href="<?php echo href('projects', TRUE) /*filter link here*/ ?>">
				<img src="<?php echo href('images') . str_replace(' ', '-', strtolower(trim($type)))  ?>" />
				<?php echo $type . " (" . $count[$type] . ")" ?>
			    </a>
			<?php endforeach; ?>
		    </div>
		<?php endif; ?>

	</div>
    </div>

    <?php if (!empty($tags) OR !empty($projets) OR !empty($side_data)): ?>
    <div style="float: right; width: 240px; border:0px solid #a6a6a6;" >
    	<div class="organization_right">

	<div class='data_block group' style="border-bottom: 0px;">
	    <?php if (!empty($projects)): ?>
		<div class='key'>
			ORGANIZATION PROJECTS
		</div>
		<div class='value' style='padding: 0px;'>
		<?php foreach ($projects AS $project):
			$ptype = str_replace(" ", "-", strtolower(trim($project['type']))); ?>
			<a class="organization_project_link" href="<?php echo href('project/' . $project['unique'], TRUE) ?>">
				<img src="<?php echo href('images') . $ptype ?>.png" />
				<?php echo $project['title'] ?>
			</a>
		<?php endforeach; ?>
		</div>
	    <?php endif; ?>
	</div>

	<?php $i = 0; foreach ($side_data as $d): $i ++; ?>

		<div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
			<div class='key'>
				<?php echo strtoupper($d['key']); ?>
			</div>
			<div class='value group'>
				<?php echo $d['value']; ?>
			</div>
		</div>

	<?php endforeach; ?>

	<?php if (!empty($tags)): ?>
	<div class='data_block group'>
		<div class='key'>
			TAG CLOUD
		</div>
		<div class='value' style="line-height: 25px;">
		<?php foreach ($tags as $tag):
				echo 
					"<a href='".href('tag/organization/' . $tag['name'], TRUE)."'>" .
						$tag['name'] . " (" . $tag['total_tags'] . ")".
					"</a><br />"
				;
			endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

	</div>

    </div>
    <?php endif; ?>

</div>
