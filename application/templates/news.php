<?php
  foreach($news_all as $news)
  {
      $img = ( strlen($news['image']) > 0 ) ? "<img src=\"" . URL . $news['image'] . "\" width='100px' /> <br/>" : "";
      echo
          "<b>" . $news['title'] . "</b> <br />" .
          $img .
          $news['body'] . "<hr />
          <br /><br /><br />"
      ;
  }
?>    

