<div id='project_content'>
    <div style='float:left;width:673px;'>
	<div class='group'>
		<?php if($organization['logo'] != NULL):
			  $logo = explode('/',$organization['logo']);
			  $logo = URL.'uploads/organization_photos/'.$logo[count($logo)-1];
		      else:
		      	  $logo = NULL; 
		      endif;
		?>
		<div style="width:282px;height:172px;float:left;<?php echo $logo != NULL ? 'background-image:url(\''.$logo.'\');' : NULL; ?>"><?php echo $logo == NULL ? "<p style='padding-top:50px;'><center><font style='font-size:25pt;'>No Logo</font></center></p>" : NULL; ?></div>
		
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

	<div id='project_description' style="margin-top:245px;">
		<p>ORGANIZATION DESCRIPTION</p>
		<div><?php echo $organization['description']; ?></div>

		<p>INFO ON PROJECTS</p>
		<div><?php echo $organization['projects_info']; ?></div>
	</div>
    </div>
    <div style="float:right;width:240px;border:0px solid #a6a6a6;" >
    	<div class="organization_right">
			<div style="border:1px dotted #a6a6a6;width:100%;height:40px;background-color:rgb(30%,75%,100%);border-top:0px;border-bottom:0px;">
				<p style="float:left;margin-top:12px;margin-left:20px;color:#FFF;font-size:11pt;font-weight:bold;font-family:arial;">ORGANIZATION PROJECTS</p>
				<!--<p style="float:right;margin-top:12px;margin-right:25px;"><a href="projects" style="text-decoration:none;color:#FFF;font-size:7.5pt;">►View All</a></p>-->
			</div>				
			
				<div style="width:100%;height:35px;border:1px dotted #a6a6a6;">
					<p style="foat:left;margin-left:7px;margin-top:5px;"><img src="" /></p>
					<p style="float:left;margin-left:40px;margin-top:-16px;">sdfsdf</p>
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
				<br/><br/><br/>
			<div style="border:1px dotted #a6a6a6;width:100%;height:40px;background-color:rgb(30%,75%,100%);border-bottom:0px;">
				<p style="float:left;margin-top:12px;margin-left:20px;color:#FFF;font-size:11pt;font-weight:bold;font-family:arial;">TAG CLOUD</p>
				<!--<p style="float:right;margin-top:12px;margin-right:25px;"><a href="projects" style="text-decoration:none;color:#FFF;font-size:7.5pt;">►View All</a></p>-->
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
  


    <div id='charts'>
<?php												//PIE
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

<?php										//COLUMN


   $width = 265;
   $height = 240;

   for ( $i = 2; $i <= 2; $i ++ ):
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

$download_png = href("export/png/".base64_encode(str_replace($width."x".$height, (2*$width)."x".(2*$height), $src))."/".$titles[$i]);
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

<? endfor; ?>





    </div>



</div>
