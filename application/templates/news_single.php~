<div class="page-container">
	 <font style="font-size: 12px;"><?php echo l('news_date') ?>: <?php echo date('F d, Y H:i',strtotime($news[0]['published_at'])); ?><font><br />
    <h1 style="font-size: 18px;">
        <?php echo $news[0]['title'] ?>
        <?php userloggedin() AND print("<a class='region_link' style='float: right; display: block; font-size: 12px;' href='" . href('admin/news/' . $news[0]['unique'], TRUE) . "'>Edit</a>"); ?>
    </h1>
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
        <div class='data_block group' <?php ($i == 1) AND print("style='border-top: 0 none;'"); ?>>
            <div class='key'><?php echo l('tag_cloud') ?></div>
            <div class='value group'>
                <?php
                foreach ($tags as $tag):
                    echo
                    "<a href='" . href('tag/project/' . $tag['name'], TRUE) . "'>" .
                    $tag['name'] . " (" . $tag['total_tags'] . ")" .
                    "</a><br />"
                    ;
                endforeach;
                ?>
            </div>
        </div>
<?php endif; ?>

</div><!--DATA END-->
