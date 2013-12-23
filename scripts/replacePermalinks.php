<?php
require_once(dirname(__FILE__) . '/../config/bootload.php');
require_once(dirname(__FILE__) . '/../classes/PageIngestor.class.php');
require_once( dirname(__FILE__) . '/../../wp-load.php' );
require_once(dirname(__FILE__) . '/getContentOfReplacedPermalinksAbs.php');

$pi = new PageIngestor();

$pi->setSiteDomain('avianweb.com'); 

$order = "ORDER BY post_id ASC";

$condition = "post_id in (
  8749,
  8840,
  8964,
  9639,
  9640,
  9641,
  9642,
  9643,
  11642,
  11825,
  12674,
  12814,
  13569,
  13701,
  14041
)";

$conditions = array($condition);

$gotchas = array();

$pages = $PageModel->findBy(compact('conditions','order'));
//$pages = $PageModel->find();

foreach($pages as $page) { 

  $WorpressModel = getContentOfReplacedPermalinks($page, $pi);

  if($WorpressModel)
    $id = $WordpressModel->save();
  
  var_dump($id);
}

var_dump($gotchas);
