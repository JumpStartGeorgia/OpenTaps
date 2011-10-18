<div class="page-container">
	<h1 style="font-size: 18px;">
		<?php echo $news[0]['title'] ?>
		<?php userloggedin() AND print("<a class='region_link' style='float: right; display: block; font-size: 12px;' href='" . href('admin/news/' . $news[0]['unique'], TRUE) . "'>Edit</a>"); ?>
	</h1>
	<span style="font-size: 15px; text-align: justify"><?php echo $news[0]['body']; ?></span>
        <p style="padding-top: 20px;">
        <font style="font-size: 13px;">Type: <?php echo $news[0]['category']; ?></font><br />
        <font style="font-size: 12px;">Published at: <?php echo $news[0]['published_at']; ?><font>
        </p>

	<div id='project_description'>
		<?php foreach ($data as $d): ?>
			<p class='desc'><?php echo strtoupper($d['key']); ?></p>
			<div><?php echo $d['value']; ?></div>
		<?php endforeach; ?>
	</div>

</div>


	<div style="float: right;"><!--DATA-->
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
		<div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
			<div class='key'>TAG CLOUD</div>
			<div class='value group'>
<?php			foreach($tags as $tag):
			    echo 
				"<a href='".href('tag/project/' . $tag['name'], TRUE)."'>" .
					$tag['name'] . " (" . $tag['total_tags'] . ")".
				"</a><br />"
			    ;
			endforeach;
?>
			</div>
		</div>
	<?php endif; ?>

	</div><!--DATA END-->
