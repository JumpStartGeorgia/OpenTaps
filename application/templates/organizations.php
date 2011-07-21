
<div class='projects_organization'>
                PROJECTS ORGANIZATION
            </div>

            <div class='spacer'>
            </div>
<div class='news'>
    <img src='<?php echo URL ?>images/news.jpg' />
    <span>Organizations</span>
</div>
<div id="chart" class='chart'>
  <!--<center>
   <img src='images/chart.jpg' />
  </center>-->
</div>
<?php if (empty($organizations)): ?>
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
        foreach ($organizations AS $organization):
        ?>
        	<tr>
			<td style="border:1px solid black;"><?php echo $idx ?></td>        	
			<td style="border:1px solid black;"><?php echo $organization['org_name']; ?></td>
			<td style="border:1px solid black;">
				<?php if (is_admin()): ?>
					<a href="javascript:show_don_edit('<?php echo $organization['id'] ?>', '<?php echo $organization['org_name'] ?>', '<?php echo $organization['don_description'] ?>');">Edit</a>
					<a href="javascript:;" onclick="if (confirm('Are you sure you want to delete?')) window.location = 'organizations/<?php echo $organization['id'] ?>/delete';">Delete</a>
				<?php endif; ?>
				<a href="organization/<?php echo $organization['id'] ?>">more</a>
			</td>
        	</tr>
        <?php
        	$idx++;
        endforeach;
?>
</table>
<?php endif; ?>
