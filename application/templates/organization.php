
<div id='project_content'>
    <div style='float:left;width:673px;'>
	<div class='group'>
		<?php if($organization['logo'] != NULL):
			  if(substr($organization['logo'], 0, 4) == "http")
			  	$logo = $organization['logo'];
			  else
			  	$logo = URL . "uploads/" . $organization['logo'];
		      else:
		      	  $logo = NULL; 
		      endif;
		?>
		<div style="width:282px;height:170px;float:left;<?php echo $logo != NULL ? 'background-image:url(\''.$logo.'\');' : NULL; ?>"><?php echo $logo == NULL ? "<p style='padding-top:50px;'><center><font style='font-size:25pt;'>No Logo</font></center></p>" : NULL; ?></div>
		
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

		<p class='desc'>INFO ON PROJECTS</p>
		<div><?php echo $organization['projects_info']; ?></div>
		<p class='desc'>ORGANIZATION PROJECTS</p>
		
			<table style="margin-left:0px;margin-bottom:30px;float:left;">
				<?php foreach($projects AS $project): ?>
				<tr>	
					<td><a style='text-decoration:underline;' href="<?php echo href('project/'.$project['id'], TRUE); ?>"><font style="font-family:arial;color:#656565;"><?php echo $project['title']; ?></font></a></td>
				</tr>			
				<?php endforeach; ?>
			</table>		
		
	</div>
    </div>
    <div style="float:right;width:240px;border:0px solid #a6a6a6;" >
    	<div class="organization_right">
			<div style="border:1px dotted #a6a6a6;width:100%;height:40px;background-color:rgb(30%,75%,100%);border-top:0px;border-bottom:0px;">
				<p style="float:left;margin-top:12px;margin-left:20px;color:#FFF;font-size:11pt;font-weight:bold;font-family:arial;">ORGANIZATION PROJECTS</p>
				<!--<p style="float:right;margin-top:12px;margin-right:25px;"><a href="projects" style="text-decoration:none;color:#FFF;font-size:7.5pt;">►View All</a></p>-->
			</div>				
			
				<div style="width:100%;border:1px dotted #a6a6a6;" class='group'>
					<p style="display:inline-block;foat:left;margin-left:7px;margin-top:5px;"><img width='225px' src="http://media.strategywiki.org/images/thumb/5/57/Angry_Birds_logo.jpg/250px-Angry_Birds_logo.jpg" /></p>
					<p style="padding:5px;display:inline-block">Curabitur a enim in ipsum bibendum pellentesque vitae et orci. Phasellus metus erat, bibendum id dignissim quis, interdum sit amet lectus.</p>
				</div>
				<br /><br /><br />
				<div style="border:1px dotted #A6A6A6;">
				    
					<blockquote style="margin-top:25px;margin-left:20px;margin-bottom:25px;">
						<p><font style="font-weight:bold;">CONTACT INFORMATION</font></p><br/>
						<p style="margin-top:-10px;"><font>Aaron Mason</font></p><br/>
						<p style="margin-top:-5px;"><font>Communication Officer</font></p><br/>
						<p style="margin-top:-5px;"><font>+995 - 93 - 5610 - 989</font></p><br/>
						<p style="margin-top:-5px;"><a href="mailto:" style="color:rgb(5%,71%,96%);text-decoration:none;"><font>aaron@gmail.com</font></a></p><br/>
						<p style="margin-top:-5px;"><a href="" style="color:rgb(5%,71%,96%);text-decoration:none;"><font>unknown.com</font></a></p>
					</blockquote>
				    
				</div>
				<br /><br />
	<div class='data_block group'>
		<div class='key'>
			TAG CLOUD
		</div>
		<div class='value' style='line-height:25px;'>
		    <?php
			foreach($tags as $tag):
				echo 
					"<a href='".href('tag/organization/' . $tag['name'], TRUE)."'>" .
						$tag['name'] . " (" . $tag['total_tags'] . ")".
					"</a><br />"
				;
			endforeach;
		    ?>
		</div>
	</div>
   	</div>
    	
    </div>
  

<?php /*
    <div id='charts'>
<?php												//PIE 1
   $width = 165;
   $defh = 203.875;

   $titles = array(NULL, 'ORGANISATIONS', 'PROJECT BUDGET', 'PROJECT', 'PROJECT BUDGET');
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
$download_csv = href("export/csv/".base64_encode(serialize(array(
    'names' => $names[$i],
    'values' => $real_values[$i]
)))."/".$titles[$i]);

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
	<div id="chart_div_<?php echo $i ?>" style="float: left; width: 160px; margin-right: 5px">
		<div class="title group" style='display:block; text-align:center;'>
			<?php echo $titles[$i] ?>
		</div>
		<div class='export group'>
                	<a href='<?php echo $download_png ?>'>PNG</a> &middot;
                	<a href='<?php echo $download_csv ?>'>CSV</a>
		</div>
		<img src="<?php echo $src; ?>"
		     width="<?php echo $width ?>px" height="<?php echo $height ?>px" alt="" />
	</div>

<? endfor; ?>





    </div>

*/ ?>

</div>
