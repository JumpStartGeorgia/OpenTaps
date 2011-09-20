<div id='project_content'>
    <div style='float:left;width:673px;'>
	<div class='group'>
		<script type="text/javascript">
			/*var region_map_boundsLeft = 4550479.3343998;
			var region_map_boundsRight = 4722921.2701802;
			var region_map_boundsTop = 5183901.869223;
			var region_map_boundsBottom = 5034696.790037;*/
			var region_map_zoom = false;
			var region_make_def_markers = false;
			var region_show_def_buttons = false;
			var region_map_maxzoomout = 8;
			var region_marker_click = false;
			var region_map_longitude = <?php echo isset($region_cordinates[0]) ? $region_cordinates[0]['longitude'] : 'false'; ?>;
			var region_map_latitude = <?php echo isset($region_cordinates[0]) ? $region_cordinates[0]['latitude'] : 'false'; ?>;
		</script>
		<div id='map' style='width:282px;border:1px dotted #a6a6a6;border-top:0;height:244px;float:left;'></div>
		
		<div id='project_details' style='height:244px;'>
			<div id='project_budget'>
				<p>Overall Region Budget</p>
				<p style='font-size:27px;color:#FFF;'><?php echo $region_budget ?></p>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					City :
				</div>
				<div>
					<?php echo $region['city']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Population :
				</div>
				<div>
					<?php echo $region['population']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Square Meters :
				</div>
				<div>
					<?php echo $region['square_meters']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					Settlement Type :
				</div>
				<div>
					<?php echo $region['settlement']; ?>
				</div>
			</div>
			<div class='project_details_line'>
				<div class='line_left'>
					The Village :
				</div>
				<div>
					<?php echo $region['villages']; ?>
				</div>
			</div>
			<div class='project_details_line' style='border-bottom:0px;'>
				<div class='line_left'>
					District :
				</div>
				<div>
					<?php echo $region['districts']; ?>
				</div>
			</div>
		</div>
	</div>
		
	<div id='project_description'>
		<p class='desc'><?php echo $region['name']; ?></p>
		<div><?php echo $region['region_info']; ?></div>

		<p class='desc'>INFO ON PROJECTS</p>
		<div><?php echo $region['projects_info']; ?></div>
	</div>

	<div id='project_description' style="margin-bottom:35px;">
		<p>PROJECTS IN THIS REGION</p>
		<table style="margin-left:0px;margin-bottom:30px;float:left;">
			<?php foreach($projects AS $project): ?>
			<tr>	
			    <td><a style='text-decoration:underline;' href="<?php echo URL.'project/'.$project['unique']; ?>"><font style="font-family:arial;color:#656565;"><?php echo $project['title']; ?></font></a></td>
			</tr>			
			<?php endforeach; ?>
		</table>
	</div>





<?php												//PIE 1
   $width = 165;
   $defh = 203.875;

   $titles = array(NULL, 'PROJECTS BUDGET', 'PROJECTS BUDGET (by year)', 'ORGANIZATIONS BUDGET', 'ORGANIZATIONS BUDGET (by year)');
   for ( $i = 1; $i <= 1; $i ++ ):
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
		<img src="<?php echo $src; ?>" width="<?php echo $width ?>px" height="<?php echo $h ?>px" alt="" />
	</div>

<?php endfor; ?>


<?php										//COLUMN 1


   $defwidth = 265;
   $width = 10;
   $height = 240;

   for ( $i = 2; $i <= 2; $i ++ ):
   	$width += count($values[$i]) * 30;
	$src = "http://chart.googleapis.com/chart?".
		urldecode(http_build_query(array(
			'chxt' => 'x',
			'cht' => 'bvs',
			'chs' => $width.'x'.$height,
			'chco' => '0000FF',
			'chd' => 't:' . implode(',', $values[$i]),
			'chbh' => '13,17',
			'chxl' => '0:|'.implode('|', $names[$i]),
			'chds' => '0,150'
		)))."";

$dw = round(1.5 * $width);
$dh = round(1.5 * $height);

$download_png = href("export/png/".base64_encode(str_replace($width."x".$height, $dw."x".$dh, $src))."/".$titles[$i]);
$download_csv = href("export/csv/".base64_encode(serialize(array('names' => $names[$i],'values' => $real_values[$i])))."/".$titles[$i]);

?>
	<div id="chart_div_<?php echo $i ?>" style="float: left; margin-right: 5px" class='group'>
		<div class="title group" style='display:block; width:180px; text-align:center;'>
			<?php echo $titles[$i] ?>
		</div>
		<div class='export group'>
                	<a href='<?php echo $download_png ?>'>PNG</a> &middot;
                	<a href='<?php echo $download_csv ?>'>CSV</a>
		</div>
		<img src="<?php echo $src; ?>" width="<?php echo $width ?>px" height="<?php echo $height ?>px" alt="" />
	</div>

<? endfor; ?>







<?php												//PIE 2
   $width = 165;
   $defh = 203.875;

   for ( $i = 3; $i <= 3; $i ++ ):
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
	<div id="chart_div_<?php echo $i ?>" style="float: left; width: 160px;">
		<div class="title group" style='display:block; text-align:center;'>
			<?php echo $titles[$i] ?>
		</div>
		<div class='export group'>
                	<a href='<?php echo $download_png ?>'>PNG</a> &middot;
                	<a href='<?php echo $download_csv ?>'>CSV</a>
		</div>
		<img src="<?php echo $src; ?>" width="<?php echo $width ?>px" height="<?php echo $h ?>px" alt="" />
	</div>

<?php endfor; ?>




    </div>
    <div style="float:right;width:240px;border:0px solid #a6a6a6;" >
    	<div class="region_right">
			<div style="border:1px dotted #a6a6a6;width:100%;height:40px;background-color:rgb(30%,75%,100%);border-bottom:0px;">
				<p style="float:left;margin-top:12px;margin-left:20px;color:#FFF;font-size:11pt;font-weight:bold;font-family:arial;">PROJECTS</p>
				<p style="float:right;margin-top:12px;margin-right:25px;"><a href="projects" style="text-decoration:none;color:#FFF;font-size:7.5pt;">►View All</a></p>
			</div>				
			
				<div style="width:100%;height:35px;border:1px dotted #a6a6a6;">
					<p style="foat:left;margin-left:7px;margin-top:5px;"><img src="" /></p>
					<p style="float:left;margin-left:40px;margin-top:-16px;">sdfsdf</p>
				</div>
				<br /><br /><br />
			<div style="border:1px dotted #a6a6a6;width:100%;height:40px;background-color:rgb(30%,75%,100%);border-bottom:0px;">
				<p style="float:left;margin-top:12px;margin-left:20px;color:#FFF;font-size:11pt;font-weight:bold;font-family:arial;">OTHERS</p>
				<p style="float:right;margin-top:12px;margin-right:25px;"><a href="projects" style="text-decoration:none;color:#FFF;font-size:7.5pt;">►View All</a></p>
			</div>
				<div style="width:100%;height:250px;border:1px dotted #a6a6a6;">
					<p style="margin-top:15px;margin-left:10px;font-weight:bold;">sdkfjhsdfhdsf</p>
					<p style="margin-top:10px;">
						<blockquote style="margin-left:10px;width:210px;">
							This is a long quotation.
							 This is a long quotation. This 
							 is a long quotation. This is a long quotation. This is a long quotation.
						</blockquote>
					</p>
				</div>
   	</div>


    </div>
  

</div>
