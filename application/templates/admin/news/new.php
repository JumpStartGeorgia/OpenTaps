<form method='post' enctype="multipart/form-data" action='<?php echo href("admin/news/create", TRUE); ?>'>
  	    <label for='ntitle'>Title: </label>
  	    <br />
  	    <input name='n_title' id='ntitle' type='text' />
  	    <br /><br />

  	    <label for='nfile'>Picture : </label>
  	    <br/>
  	    <input name='n_file' type='file' id='nfile' />
  	    <br /><br />

  	    <label for='nbody'>Body: </label>
  	    <br />
  	    <textarea name='n_body' id='nbody' cols='70' rows='5'></textarea>
  	    <br /><br />

         <label for='ncategory'>Category: </label>
         <br />
         <select name='n_category' id='ncategory'>
            <!--<option value="-1"></option>-->
            <?php
     foreach( config('news_types') as $type ):
                  ?>
         <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                   <?php
         endforeach;
                    ?>
         </select>
         <br /><br />

         <label for='nplace'>Place: </label>
         <br />
         <select name='n_place' id='nplace'>
            <option value="-1"></option>
            <?php
         foreach( $places as $place ):
                  ?>
         <option value="<?php echo $place['unique']; ?>"><?php echo $place['name']; ?></option>
                   <?php
         endforeach;
                    ?>
         </select>
         <br /><br />
         
  	    <label for='ptags'>Tags: (enter by hand or select tags below)</label>
  	    <br /><br />
  	    <input type="text" id="tag_box" name="p_tag_names" style="width: 150px; border-right: 1px solid #ccc;" value="" />
  	    <span style='font-size:12px;'>separate by comma ",&nbsp"</span>
  	    <br /><br />
  	    <select name='p_tag_uniques[]' id='ptags' multiple='multiple'>
  	      <?php
  	        foreach($all_tags as $tag)
  	        {
  	            ?>
  	            <option value="<?php echo $tag['unique'] ?>" <?php echo (in_array($tag['unique'], $all_tags)) ? "selected = 'selected'" : NULL; ?>><?php echo $tag['name'] ?></option>
  	            <?php
  	        }
  	      ?>
  	    </select>
  	    <br /><br />

  	    <input type='submit' value='Submit' onclick='return document.getElementById("ntitle").value != ""' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/news", TRUE); ?>">Back</a>
