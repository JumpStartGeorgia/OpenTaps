<div class="page-container">

	<?php if (empty($menu) OR empty($menu['title'])): ?>
		<h1 style="font-size: 18px;">Under construction</h1>
	<?php else: ?>
		<h1 style="font-size: 18px;">
			<?php echo $menu['title'] ?>
			<?php userloggedin() AND print("<a class='region_link' style='float: right; display: block; font-size: 12px;' href='" . href('admin/menu/' . $menu['unique'], TRUE) . "'>Edit</a>"); ?>
		</h1>
		<span style="font-size: 15px; text-align: justify"><?php echo $menu['text']; ?></span>
	<?php endif; ?>

</div>
