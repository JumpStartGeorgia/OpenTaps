
<div class='projects_organization'>
                PROJECTS ORGANIZATION
            </div>

            <div class='spacer'>
            </div>
<div class='news'>
    <img src='<?php echo URL ?>images/news.jpg' />
    <span>Donors</span>
</div>
<div id="chart" class='chart'>
  <!--<center>
   <img src='images/chart.jpg' />
  </center>-->
</div>
<?php if (empty($donors)): ?>
	<h2>No donors</h2>
<?php else: ?>
<table border='0px' style='font-size:9pt;'>
	<tr>
		<td style="text-align: center">N.</td>
		<td style="text-align: center">Name</td>
		<td style="text-align: center">Actions</td>
	</tr>
<?php
        $idx = 1;
        foreach ($donors AS $donor):
        ?>
        	<tr>
			<td style="border:1px solid black;"><?php echo $idx ?></td>        	
			<td style="border:1px solid black;"><?php echo $donor['don_name']; ?></td>
			<td style="border:1px solid black;">
				<?php if (is_admin()): ?>
					<a href="javascript:show_don_edit('<?php echo $donor['id'] ?>', '<?php echo $donor['don_name'] ?>', '<?php echo $donor['don_description'] ?>');">Edit</a>
					<a href="javascript:;" onclick="if (confirm('Are you sure you want to delete?')) window.location = 'donor/<?php echo $donor['id'] ?>/delete';">Delete</a>
				<?php endif; ?>
				<a href="donor/<?php echo $donor['id'] ?>">more</a>
			</td>
        	</tr>
        <?php
        	$idx++;
        endforeach;
?>
</table>
<?php endif; ?>
