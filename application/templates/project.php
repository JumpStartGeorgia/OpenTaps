<div id='project_content'>

    <div style='float:left;width:673px;'>
	<div class='group'>
		<div id='map' style='width:282px;height:244px;float:left;'></div>
		<div id='project_details'>
			<div id='project_budget'>
				<p>Overall Project Budget</p>
				<p style='font-size:27px;color:#FFF;'><?php echo $project['budget'] ?></p>
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
					District :
				</div>
				<div>
					<?php echo $project['district']; ?>
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
					<?php echo $project['start_at'] . " - " . $project['end_at']; ?>
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

<?php
	$indexes = array(123,423,534,343,777);
	$months = array('dasdas1', 'dasdsa2', 'dsadas3','rame4','asd5');
	$titles = array(NULL, 'ORGANISATIONS', 'PROJECT BUDGET', 'PROJECT', 'PROJECT BUDGET');
?>
    </div>

    <div id='charts'>
<? for ( $i = 1; $i <= 4; $i ++ ): ?>
	<div id="chart_div_<?php echo $i ?>" style="float: left; width: 160px; margin-right: 5px">
		<div class="title" style='display:block; text-align:center;'><?php echo $titles[$i] ?></div>
		<img style="margin-top: 5px" src="http://chart.googleapis.com/chart?<?php
			echo urldecode(http_build_query(array(
				'cht' => 'pc',
				'chs' => '165x222',
				'chco' => '0000FF',
				'chd' => 't:' . implode(',', $indexes),
				'chdl' => implode('|', $months),
				'chdlp' => 'bv'
                        )));
                        ?>" width="165" height="222" alt="" />
	</div>
<? endfor; ?>
    </div>

</div>
