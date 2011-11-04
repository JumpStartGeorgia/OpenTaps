    	<form action="<?php echo href('admin/georgia_profile/', TRUE); ?>" method='post' enctype="multipart/form-data">
	    <h3>Georgia Profile Data</h3>
	    <div id="data_fields_container">


	    <div style="margin: 25px 0px;">
	        <?php if (empty($image['value'])): ?>
			Photo: <br />
			<input type="file" name="image" />
		<?php else: ?>
			<div id="prevphoto">
			    Current Photo: <br />
			    <img src="<?php echo href() . $image['value'] ?>" width="200px" /><br />
			</div>
			<span style="cursor: pointer;" onclick="$(this).parent().find('#prevphoto').remove(); $(this).parent().append('<input type=\'file\' name=\'image\' />');">New Photo</span>
		<?php endif; ?>
	    </div>

	    <div style="margin: 25px 0px;">
		Content:
		<textarea name="content"><?php empty($content['value']) OR print $content['value']; ?></textarea>
	    </div>

	    <p style="font-weight: bold;">Data</p>
<?php foreach ($data as $idx => $item):
		$main = ($item['main'] == 1);
	    	$bg = ($idx & 1) ? 'url(' . href() . 'images/bg.jpg) repeat' : 'white'; ?>
		    <div class='group' style='background: <?php echo $bg; ?>; padding: 13px; border-bottom: 2px solid #ccc;'>
			<label style="cursor: pointer">
  	    			Title: <br />
  	    			<input name='data_key[]' value="<?php empty($item['key']) OR print $item['key'] ?>" type='text' />
  	    		</label><br /><br />
			<label style="cursor: pointer">
  	    			Value: <br />
  	    			<input name='data_value[]' value="<?php empty($item['value']) OR print $item['value'] ?>" type='text' />
	    		</label><br /><br />
			<label style="cursor: pointer" onmouseup="$(this).parent().parent().find('.hidden_radio').val('no'); $(this).find('.hidden_radio').val('yes');">
  	    			<input name='main' type='radio' <?php $main AND print 'checked="checked"'; ?> /> Main
  	    			<input type="hidden" class='hidden_radio' name="data_main[]" <?php $main AND print 'value="yes"'; ?> />
	    		</label><br /><br />
	    		<a style="color: red; cursor: pointer; font-size: 13px;"
	    		   onclick='$(this).parent().slideUp(function(){ $(this).remove(); })'>
	    			- Remove data
	    		</a><br /><br />
	    	    </div>
<?php endforeach; ?>

	    </div>

	    <a id="gp_add_data_field">+Add data</a>

  	    <input type='submit' value='Save' />
  	</form>

  	<br /><br />
  	<a href="<?php echo href("admin", TRUE); ?>">Back</a>
