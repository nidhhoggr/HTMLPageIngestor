<?php
require_once(dirname(__FILE__) . '/../config/bootload.php');
require_once(dirname(__FILE__) . '/../classes/PageIngestor.class.php');
require_once( dirname(__FILE__) . '/../../wp-load.php' );

$pi = new PageIngestor();

$pi->setFixedContentWidth('604');
$pi->setSiteDomain('avianweb.com'); 

$conditions = array('post_type = "page"');

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

die();

foreach($page->links as $link) {


  if(!$pi->isSiteDomainBased($link["link"])) { 
    if($page) { 
      $conditions = array("filename = '". $link["link"]."'");
      $page = $PageModel->findOneBy(compact('conditions'));
      $conditions = array("ID = " . $page->post_id);
      $post = $WordpressModel->findOneBy(compact('conditions'));

      
      if(!$post) {
        var_dump($PageModel->getQuery());
        var_dump($WordpressModel->getQuery());
        die ("No page found for " . $link["link"]);
      }
      else {

        $permalink = get_permalink($post->ID);
 
        if(!$post_content) $post_content = $post->post_content;

        var_dump("replacing {$page->filename} with $permalink");

        $post_content = str_replace($page->filename,$permalink,$post_content);

      }
    }
    else {
      die("No page found for " . $link["link"]);
    }
  } else {

    var_dump("Found absolute link: " . $link["link"]);
  }
}

var_dump($post_content);
