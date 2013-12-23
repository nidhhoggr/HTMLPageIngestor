<?php
require_once(dirname(__FILE__) . '/../config/bootload.php');
require_once(dirname(__FILE__) . '/../classes/PageIngestor.class.php');
require_once( dirname(__FILE__) . '/../../wp-load.php' );

$pi = new PageIngestor();

$pi->setSiteDomain('avianweb.com'); 

$conditions = array("post_content LIKE '%services.mercantec.com%'");

$gotchas = array();

$posts = $WordpressModel->findBy(compact('conditions'));
//$pages = $PageModel->find();

foreach($posts as $post) { 

  $html = str_get_html($post->post_content);

  /*

  $formAxs = $html->find('form[action*=services.mercantec.com]');

  foreach($formAxs as $formAx) {

    var_dump($formAx->action);
  }

  */

  $scriptSrcs = $html->find('script[src*=services.mercantec.com]');

  foreach($scriptSrcs as $obj) {
    $inst['js'][] = $obj->src; 
  }

  /*

  $anchorHrefs = $html->find('a[href*=services.mercantec.com]');

  foreach($anchorHrefs as $obj) {
    $inst['a'][] = $obj->href;
  }

  */
}

//avianweb.kom%2fimages%2fproducts%2faddtocart.gif
//avianweb.kom%2favianwebs-shopping-cart-2


$uniqueJss = array_unique($inst['js']);

foreach($uniqueJss as $uj) {

  if(!strstr($uj, 'images')) continue;

  if(
    strstr($uj, 'avianweb.com%2fimages%2fproducts%2faddtocart.gif')
    && strstr($uj, 'avianweb.com%2fshoppingcart.html')
  )
    
    $ujs[] = $uj;
//  else
//    var_dump($uj);
}

var_dump(count($ujs),count($uniqueJss));

//var_dump($gotchas);
