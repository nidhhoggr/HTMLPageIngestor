<?php
require_once(dirname(__FILE__) . '/../config/bootload.php');
require_once(dirname(__FILE__) . '/../classes/PageIngestor.class.php');
require_once( dirname(__FILE__) . '/../../wp-load.php' );

$pi = new PageIngestor();

$pi->setFixedContentWidth('604');
$pi->setSiteDomain('avianweb.com'); 

$conditions = array('post_type = "page"', 'ID > 12213');

$posts = $WordpressModel->findBy(compact('conditions'));

foreach($posts as $post) {

  $content = $post->post_content;

  $blocks = $pi->getFixedPixelBlocks($content);
  $links = $pi->getLinks($content);
  $images = $pi->getImages($content);

  $conditions = array('post_id = ' . $post->ID);

  $page = $PageModel->findOneBy(compact('conditions'));

  $pm = $PageModel;

  $pm->id = $page->id;
  $pm->n_links = $links;
  $pm->n_images = $images;
  $pm->n_fixedblocks = $blocks;

  if($links || $images || $blocks)
    var_dump($pm->save());  
}
