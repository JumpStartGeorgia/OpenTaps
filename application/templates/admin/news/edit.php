<?php
  $action = href("admin/news/" . $news[0]['id'] . "/update");
  $img = view_image($news[0]['id']);
?>
    	<form enctype='multipart/form-data' action='<? echo $action; ?>' method='post'>
  	    <label for='ntitle'>Title: </label>
  	    <br />
  	    <input name='n_title' id='ntitle' type='text' value='<?php echo $news[0]['title']; ?>' />
  	    <br /><br />

  	    Picture: <br />
  	<?php
  	    echo (!$img) ?  "No current picture <br/>" : "Current: <br /><image src='" . $img . "' width='100' /><br />";
  	?>
  	    <label for='nfile' onclick='document.getElementById("nfile").style.display = "block";' class='newpiclabel'>
  	        New picture
  	    </label>
  	    <input name='n_file' type='file' id='nfile' style='display:none;' />
  	    <br /><br />

  	    <label for='nbody'>Body: </label>
  	    <br />
  	    <textarea name='n_body' id='nbody' cols='70' rows='5'><?php echo $news[0]['body']; ?></textarea>
  	    <br /><br />

  	    <input type='submit' style='width:90px;' value='Submit' onclick='
	  	    return document.getElementById("ntitle").value != "" && document.getElementById("nbody").value != ""
  	    ' />
  	    <br /><br />
  	</form>

  	<a href="<?php echo href("admin/news"); ?>">Back</a>
  	<br />
  	<a onclick='return confirm("Are you sure?");' href="<?php echo href("admin/news/" . $news[0]['id'] . "/delete"); ?>" >
  	    Delete this record
  	</a>
