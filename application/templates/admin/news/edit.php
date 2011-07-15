<?
  $action = href("admin/news/" . $news[0]['id'] . "/update");
  echo "
  	<form action='" . $action . "' method='post'>
  	    <label for='ntitle'>Title: </label>
  	    <br />
  	    <input name='n_title' id='ntitle' type='text' value=\"" . $news[0]['title'] . "\" />
  	    <br /><br />
  	    <label for='nbody'>Body: </label>
  	    <br />
  	    <textarea name='n_body' id='nbody' cols='70' rows='5'>" . $news[0]['body'] . "</textarea>
  	    <br /><br />
  	    <input type='submit' value='Submit' onclick='
	  	    return document.getElementById(\"ntitle\").value != \"\" && document.getElementById(\"nbody\").value != \"\"
  	    ' />
  	    <br /><br />
  	</form>

  	<a href=\"" . href("admin/news") . "\">Back</a>
  ";
