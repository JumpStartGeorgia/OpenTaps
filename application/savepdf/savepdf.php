<?php

	





$html = file_get_contents('http://www.opentaps.ge');

require_once("../dompdf/dompdf_config.inc.php");


/*  if ( get_magic_quotes_gpc() )
    $html = stripslashes($html);*/
  
//  $old_limit = ini_set("memory_limit", "16M");
  
  $dompdf = new DOMPDF();
  $dompdf->load_html($html);
  $dompdf->set_paper("letter","portrait");
	
  $dompdf->render();

  $dompdf->stream("irakli.pdf");

  exit(0);





?>
