<?php if (isset($news) AND !empty($news)): ?>
<h1><?php echo $news[0]['title']; ?></h1>
<?php endif; ?>

<div class="page-container"><?php
     if (isset($news) AND !empty($news)):
        echo $news[0]['body'];
        ?>
        <p style="padding-top:20px;">
        <font style="font-size:10pt;">Type: <?php echo $news[0]['category']; ?></font><br />
        <font style="font-size:10pt;">Published at: <?php echo $news[0]['published_at']; ?><font>
        </p>
        <?php
     else:
        echo 'Under Constriction';
     endif;
?></div>