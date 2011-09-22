
<div id='project_content'>
	<script type="text/javascript">
			/*var region_map_boundsLeft = 4550479.3343998,
			region_map_boundsRight = 4722921.2701802,
			region_map_boundsTop = 5183901.869223,
			region_map_boundsBottom = 5034696.790037;*/
			var region_map_zoom = false,
			region_make_def_markers = false,
			region_show_def_buttons = false,
			region_map_maxzoomout = 8,
			region_map_longitude = <?php echo isset($project) ? $project['longitude'] : 'false'; ?>,
			region_map_latitude = <?php echo isset($project) ? $project['latitude'] : 'false'; ?>,
			region_marker_click = false;
			console.log(region_map_longitude);
			console.log(region_map_latitude);
	</script>


	<div style="float: left;">
		<div id="map" style="width: 638px; height: 160px; border-top: 0;"></div>
		<div style="background: url(<?php echo href() . "images/bg.jpg" ?>) repeat; width: 610px; height: 35px; padding: 8px 15px;">
			<span style="font-size: 16px;"><?php echo $project['title'] ?></span>
			<span style="font-size: 10px; display: block; margin-top: 2px;"><?php echo $project['start_at'] ?></span>
		</div>
		<div class="group" style="width: 640px; padding: 8px 0px; margin-top: 30px;">
			<div>
				<span style="width: 625px; display: block; font-weight: bold; font-size: 14px; padding: 0px 0px 10px 15px; border-bottom: 1px dotted #a6a6a6;">►▼ Project Name: <?php echo $project['title'] ?></span>
				<span style="">
					Location - Region:
					<a id="region_link" href="<?php echo href('region/'.$project['region_unique'], TRUE); ?>">
						<?php echo $project['region_name']; ?>
					</a>
					Location - City/Town: <?php echo $project['city']; ?>
				</span>
			</div>
		</div>
	</div>
	<div style="float: right;">
	</div>





<?php /*
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

    </div>*/ ?>

</div>
