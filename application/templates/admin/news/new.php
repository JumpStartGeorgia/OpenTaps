<form method='post' enctype="multipart/form-data" action='<?php echo href("admin/news/create", TRUE); ?>'>
    	   Language: &nbsp;
	   <select style="width: 70px;" name="record_language">
	   <?php foreach (config('languages') AS $lang): $s = 'selected="selected"';?>
	   	<option <?php LANG == $lang AND print $s; ?> value="<?php echo $lang; ?>"><?php echo $lang; ?></option>
	   <?php endforeach; ?>
	   </select><br /><br />

  	    <label style="cursor: pointer;">
		<input type="checkbox" name="hidden" /> Hidden
	    </label><br /><br />


  	    <label for='ntitle'>Title: </label>
  	    <br />
  	    <input name='n_title' id='ntitle' type='text' />
  	    <br /><br />

  	    <label style="cursor: pointer;">
		<input name='n_show_in_slider' id='ntitle' type='checkbox' value="yes" />
		Show in top slider
  	    </label>
  	    <br /><br />

  	    <div>
		Published at<br />
		<?php
		list($y, $m, $d, $h, $min) = array(date("Y"), date("m"), date("d"), date("H"), date("i"));
		$months = array(NULL, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		?>
		<input type="text" style="width: 20px;" value="<?php echo $d; ?>" name="published_at[day]" />&nbsp;-
		<select class="chosen_deselector" name="published_at[month]">
		<?php for ($i = 1; $i <= 12; $i ++): $ii = $i < 10 ? '0' . $i : $i; ?>
		    <option <?php $i == $m and print 'selected="selected"' ?> value="<?php echo $ii; ?>"><?php echo $months[$i]; ?></option>
		<?php endfor; ?>
		</select>&nbsp;-
		<input type="text" style="width: 35px;" value="<?php echo $y; ?>" name="published_at[year]" />&nbsp;&nbsp;&nbsp;&nbsp;
		<select class="chosen_deselector" name="published_at[hour]">
		<?php for ($i = 0; $i < 24; $i ++): $ii = $i < 10 ? '0' . $i : $i; ?>
		    <option <?php $i == $h and print 'selected="selected"' ?> value="<?php echo $ii; ?>"><?php echo $ii; ?></option>
		<?php endfor; ?>
		</select>&nbsp;:
		<select class="chosen_deselector" name="published_at[minute]">
		<?php for ($i = 0; $i < 60; $i ++): $ii = $i < 10 ? '0' . $i : $i; ?>
		    <option <?php $i == $min and print 'selected="selected"' ?> value="<?php echo $ii; ?>"><?php echo $ii; ?></option>
		<?php endfor; ?>
		</select>
		<?php /*<input type="text" style="width: 23px;" value="<?php echo $min; ?>" name="published_at[minute]" onfocus="if (this.value == 'min') this.value = '';" onblur="if (this.value == '') this.value = 'min';" />*/ ?>
	    </div><br />

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

	    <h3>News Data</h3>
	    <div id="data_fields_container" style="padding-left: 55px;">
	    </div>
	    <a style="color: #4CBEFF; cursor: pointer; font-size: 13px;" id="add_data_field">+Add data</a><br /><br />

  	    <input type='submit' value='Submit' onclick='return document.getElementById("ntitle").value != ""' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/news", TRUE); ?>">Back</a>
