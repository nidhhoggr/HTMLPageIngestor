<?php
require_once(dirname(__FILE__) . '/../config/bootload.php');
require_once(dirname(__FILE__) . '/../classes/PageIngestor.class.php');
require_once( dirname(__FILE__) . '/../../wp-load.php' );


$pages = $PageModel->find();

$query = $PageModel->getQuery();

error_reporting(0);

foreach($pages as $page) { 
  $pi = new PageIngestor(dirname(__FILE__) . '/../../../../production/' . $page->filename);
  $pi->getContent();

  $post = $WordpressModel->findOneBy(array('conditions'=>array('ID = ' . $page->post_id)));

  if($post->post_content !== $pi->getContent()) {

    $WordpressModel->ID = $post->ID;
    $WordpressModel->post_content = mysql_real_escape_string($pi->getContent());
    var_dump($WordpressModel->save());
  }
}


