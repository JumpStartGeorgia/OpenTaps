<div style="float: left; line-height: 27px;">
	Title: <br />
	Text: <br />
</div>
<div style="display: inline-block; margin-left: 50px; line-height: 27px;">
	<input type='text' id='p_key' value="<?php echo $data['key']; ?>" /><br />
	<textarea id='p_value'><?php echo $data['value']; ?></textarea><br />
	<input type="submit" value="Save" id="admin_save_button" datatype="project_data" data_unique="<?php echo $data['unique'] ?>" style="cursor: pointer" />
	<span id='message_container'></span>
</div>

<!--<script type="text/javascript" language="javascript">tinymceinit();</script>-->
