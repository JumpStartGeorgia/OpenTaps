<div class="page-container">
	<font style="font-size: 12px;">
	    <?php 
	    	$date = dateformat($news[0]['published_at']);
	    	$date = !strtotime($news[0]['published_at']) ? l('no_time') : $date;
	    ?>
	<font><br />
    <h1 style="font-size: 18px;">
        <?php echo $news[0]['title'] ?>
        <?php userloggedin() AND print("<a class='region_link' style='float: right; display: block; font-size: 12px;' href='" . href('admin/news/' . $news[0]['unique'], TRUE) . "'>Edit</a>"); ?>
    </h1>
    <p style="padding-top:10px;">
        <?php __( l('news_date') . ':  <strong>' . $date . '</strong>' ); ?>
    </p>
    <br />
    <span class="news_text"><?php echo $news[0]['body']; ?></span>

    <div id='project_description'>
        <?php foreach ($data as $d): ?>
            <p class='desc'><?php echo strtoupper($d['key']); ?></p>
            <div><?php echo $d['value']; ?></div>
        <?php endforeach; ?>
    </div>

    <div id="disqus_thread"></div>
    <script type="text/javascript">
        var disqus_shortname = 'opentapsge';
        (function() {
            var dsq = document.createElement('script');
            dsq.type = 'text/javascript';
            dsq.async = true;
            dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>

</div>


<div style="float: right;"><!--DATA-->
    <?php $i = 0;
    foreach ($side_data as $d): $i++; ?>
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
        <div class='data_block group' style="border-top: 0 none;">
            <div class='key'><?php echo l('tag_cloud') ?></div>
	    <div class="value group" style="padding: 0px; border: 0px;">
		<?php
		foreach (array_values($tags) as $key => $tag):
		    $hidden = $key >= config('projects_in_sidebar') ? 'display: none; ' : FALSE; ?>
		    <a style="<?php echo $hidden; ?>padding: 9px 15px;" class="organization_project_link" href="<?php echo href('tag/news/' . $tag['name'], TRUE) ?>">
		    <?php echo char_limit($tag['name'], 28) . " (" . $tag['total_tags'] . ")" ?>
		    </a><?php
		endforeach;
		if ($hidden): ?>
		   <a class="show_hidden_list_items organization_project_link" style="border: 0px;">▾</a><?php
		endif; ?>
	    </div>
        </div>
<?php endif; ?>

</div><!--DATA END-->
