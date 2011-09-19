
<div id='project_content'>
	<script type="text/javascript">
		/*var region_map_boundsLeft = 4550479.3343998;
			var region_map_boundsRight = 4722921.2701802;
			var region_map_boundsTop = 5183901.869223;
			var region_map_boundsBottom = 5034696.790037;*/
			var region_map_zoom = false;
			var region_make_def_markers = false;
			var region_show_def_buttons = false;
			var region_map_maxzoomout = 8;
			var region_map_longitude = <?php echo isset($project) ? $project['longitude'] : 'false'; ?>;
			var region_map_latitude = <?php echo isset($project) ? $project['latitude'] : 'false'; ?>;
			var region_marker_click = false; 
			console.log(region_map_longitude);
			console.log(region_map_latitude);
	</script>
    <div style='float:left;width:673px;'>
	<div class='group'>
		<div id='map' style='width:282px;height:244px;float:left;'></div>
		<div id='project_details'>
			<div id='project_budget'>
				<p>Overall Project Budget</p>
				<p style='font-size:27px;color:#FFF;'><?php echo number_format($project['budget']) ?></p>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Title :
				</div>
				<div>
					<?php echo $project['title']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Region :
				</div>
				<div>
					<a id="region_link" href="<?php echo URL.'region/'.$project['region_id']; ?>">	<?php echo $project['region_name']; ?> </a>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					City/Town :
				</div>
				<div>
					<?php echo $project['city']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Grantee :
				</div>
				<div>
					<?php echo $project['grantee']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Sector :
				</div>
				<div>
					<?php echo $project['sector']; ?>
				</div>
			</div>
			<div class='project_details_line' style='border:0;'>
				<div class='line_left'>
					Time line :
				</div>
				<div>
                <?php echo date('M.d.Y',strtotime($project['start_at'])) . " - " . date('M.d.Y',strtotime($project['end_at'])); ?>
				</div>
			</div>
		</div>
	</div>

	<div id='project_description'>
		<p>PROJECT DESCRIPTION</p>
		<div><?php echo $project['description']; ?></div>

		<p>INFO ON PROJECT</p>
		<div><?php echo $project['info']; ?></div>
	</div>
    </div>

    <div style='float:right;'>

<?php $i = 0; foreach ( $data as $d ): $i ++; ?>

	<div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
		<div class='key'>
			<?php echo strtoupper($d['key']); ?>
		</div>
		<div class='value'>
			<?php echo $d['value']; ?>
		</div>
	</div>

<?php endforeach; ?>

	<div class='data_block group'>
		<div class='key'>
			TAG CLOUD
		</div>
		<div class='value' style='line-height:25px;'>
		    <?php
			foreach($tags as $tag):
				echo 
					"<a href='".href('tag/project/' . $tag['name'])."'>" .
						$tag['name'] . " (" . $tag['total_tags'] . ")".
					"</a><br />"
				;
			endforeach;
		    ?>
		</div>
	</div>

    </div>

<?php
	$titles = array(NULL, 'ORGANISATIONS', 'PROJECT BUDGET', 'PROJECT', 'PROJECT BUDGET');
?>

    <div id='charts'>
<?php
   $width = 165;
   $defh = 203.875;
   for ( $i = 1; $i <= 2; $i ++ ):
	$height = $defh + count($names[$i]) * 18.125;
	$h = round($height);
	$src = "http://chart.googleapis.com/chart?".
		urldecode(http_build_query(array(
			'cht' => 'pc',
			'chs' => $width.'x'.$h,
			'chco' => '0000FF',
			'chd' => 't:' . implode(',', $values[$i]),
			'chdl' => implode('|', $names[$i]),
			'chdlp' => 'bv'
		)))."";
		
$download_png = href("export/png/".base64_encode(str_replace($width."x".$h, (2*$width)."x".(round(2*$height)), $src))."/".$titles[$i]);
$download_csv = href("export/csv/".base64_encode(serialize(array('names' => $names[$i],'values' => $real_values[$i])))."/".$titles[$i]);

?>
	<div id="chart_div_<?php echo $i ?>" style="float: left; width: 160px; margin-right: 5px">
		<div class="title group" style='display:block; text-align:center;'>
			<?php echo $titles[$i] ?>
		</div>
		<div class='export group'>
                	<a href='<?php echo $download_png ?>'>PNG</a> &middot;
                	<a href='<?php echo $download_csv ?>'>CSV</a>
		</div>
		<img src="<?php echo $src; ?>"
		     width="<?php echo $width ?>px" height="<?php echo $h ?>px" alt="" />
	</div>

<? endfor; ?>

    </div>

</div>
