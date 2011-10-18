<?
  echo "
  	<div class='panel'>
  		<div class='titlepanel'>
  		    <div class='tleft'>Title</div>
  		    "/*<div class='tcenter'>Body</div>-->*/. "
  		    <div class='rright'>Manage</div>
  		</div>
  ";

  $news_all = read_news();
  foreach($news_all as $news)
  {
      $link_edit = href("admin/news/". $news['unique'], TRUE);
      $link_del = href("admin/news/". $news['unique'] . '/delete', TRUE);
      /*$news['body'] = htmlspecialchars($news['body']);
      $news['body'] = ( strlen($news['body']) > 85 ) ? substr($news['body'], 0, 82) . "..." : $news['body'];*/

      echo "
		<div class='record'>
		  <div class='rleft'> " . char_limit($news['title'], 60) . "</div>
		  "/*<div class='rcenter'> " . $news['body'] . "</div>-->*/. "
		  <div class='rright'>
		      <a href=\"" . $link_edit . "\">Edit/Show</a>
		      <a href=\"" . $link_del . "\" onclick='return confirm(\"Are you sure?\");'>Delete</a>
		  </div>
		</div>
      ";
  }

  echo "
  		<div class='newrecord'>
  		    <a href=\"" . href("admin/news/new", TRUE) . "\">New Record</a>
  		</div>
  	</div>
  ";
