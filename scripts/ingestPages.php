<?php
require_once(dirname(__FILE__) . '/../config/bootload.php');
require_once(dirname(__FILE__) . '/../classes/PageIngestor.class.php');
require_once(dirname(__FILE__) . '/ingestPage.php');
require_once( dirname(__FILE__) . '/../../wp-load.php' );


//pases a list of pages and ingests one by one 
function ingestFiles($listFile,$fileLocation) { 

  $handle = @fopen($listFile, "r");

  if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
      $file = $fileLocation . trim($buffer);
      ingestPage($file);
    }
    if (!feof($handle)) {
      echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
  }
}

//ingestFiles("results",dirname(__FILE__) . '/../../../../production/');

ingestPage( dirname(__FILE__) . '/../../../../production/duckinfo.html');
