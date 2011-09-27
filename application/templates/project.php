
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
		<div class="group" style="width: 640px; padding: 8px 0px; margin-top: 30px; line-height: 18px;">
			<div>
				<span class="expand_title">
					<span class="racxa">▼</span> Project Name: <?php echo $project['title'] ?>
				</span>
				<div class="expandable" style="display: block;">
					Location - Region:
					<a id="region_link" href="<?php echo href('region/'.$project['region_unique'], TRUE); ?>">
						<?php echo $project['region_name']; ?>
					</a><br />
					Location - City/Town: <?php echo $project['city']; ?><br />
					Grentee: <?php echo $project['grantee']; ?><br />
					Sector: <?php echo $project['sector']; ?><br />
					Budget: <?php echo $project['budget']; ?><br />
					Beginning: <?php echo $project['start_at']; ?><br />
					Ending: <?php echo $project['end_at']; ?><br />
					Type: <?php echo $project['type']; ?>
				</div>
			</div>

			<div>
				<span class="expand_title"><span class="racxa">►</span> Project Description</span>
				<div class="expandable"><?php echo $project['description']; ?></div>
			</div>

			<div>
				<span class="expand_title"><span class="racxa">►</span> Project Info</span>
				<div class="expandable"><?php echo $project['info']; ?></div>
			</div>

		<?php foreach ($data AS $d): ?>
			<div>
				<span class="expand_title"><span class="racxa">►</span> <?php echo $d['key'] ?></span>
				<div class="expandable"><?php echo $d['value']; ?></div>
			</div>
		<?php endforeach; ?>

		</div>



<?php /*
<div id="disqus_thread"></div>
<script type="text/javascript">
    //  * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * 
    var disqus_shortname = 'opentaps'; // required: replace example with your forum shortname

    //   * * * DON'T EDIT BELOW THIS LINE * *
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
*/ ?>




	</div>
	<div style="float: right;">
	<?php $i = 0; foreach ( $side_data as $d ): $i ++; ?>

		<div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
			<div class='key'>
				<?php echo strtoupper($d['key']); ?>
			</div>
			<div class='value group'>
				<?php echo $d['value']; ?>
			</div>
		</div>

	<?php endforeach; ?>

		<?php if (!empty($tags)): ?><div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
			<div class='key'>TAG CLOUD</div>
			<div class='value group'>
<?php
			foreach($tags as $tag):
			    echo 
				"<a href='".href('tag/project/' . $tag['name'], TRUE)."'>" .
					$tag['name'] . " (" . $tag['total_tags'] . ")".
				"</a><br />"
			    ;
			endforeach;
?>
			</div>
		</div><?php endif; ?>

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
