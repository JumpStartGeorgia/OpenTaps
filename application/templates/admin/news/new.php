<?
  echo "
  	<form action='" . href("admin/news/create") . "' method='post'>
  	    <label for='ntitle'>Title: </label>
  	    <br />
  	    <input name='n_title' id='ntitle' type='text' />
  	    <br /><br />
  	    <label for='nbody'>Body: </label>
  	    <br />
  	    <textarea name='n_body' id='nbody' cols='70' rows='5'></textarea>
  	    <br /><br />
  	    <input type='submit' value='Submit' onclick='
  	    	return document.getElementById(\"ntitle\").value != \"\" && document.getElementById(\"nbody\").value != \"\"
  	    	' />
  	    <br /><br />
  	</form>

  	<a href=\"" . href("admin/news") . "\">Back</a>
  ";
