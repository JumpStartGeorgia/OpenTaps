<?php
    
    
?>


    
    <form action="<?php echo href('admin/places/'.$unique.'/water_supply/update', TRUE) ?>" method="POST">
        <textarea name="pl_water_supply">
            <?php echo $water_supply['text']; ?>
        </textarea><br />
        <input type="submit" value="Update" />
    </form>
<br />
<a href="<?php echo href("admin/places", TRUE); ?>">Back</a>
