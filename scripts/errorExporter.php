<?php
require_once(dirname(__FILE__) . '/../config/bootload.php');
require_once(dirname(__FILE__) . '/../classes/PageIngestor.class.php');
require_once( dirname(__FILE__) . '/../../wp-load.php' );

$lem = $LinksErroredModel;

$condition = array();

$error_results = $lem->find(compact('condition'));

foreach($error_results as $error) {

  foreach($error->errors as $err) {

    extract($err);
 
    if(strstr($link, 'avianweb.kom')) {
   
      $pl = get_permalink($error->post_id);
      $pl = str_replace('avianweb.kom','supraliminalsolutions.net',$pl);

      $link = str_replace('avianweb.kom','supraliminalsolutions.net',$link);
 
      echo $pl . ', ' . $link . "\r\n";
    }

  }
}
