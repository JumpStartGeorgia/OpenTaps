<?php if (isset($title) AND !empty($title)): ?>
<h1><?php echo $title ?></h1>
<?php endif; ?>

<div class="page-container"><?php
    if (isset($text) AND !empty($text))
        echo $text;
    else
        echo 'Under Construction';
?></div>
