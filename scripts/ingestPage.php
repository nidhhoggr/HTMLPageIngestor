<?php

function ingestPage($page) {
  global $PageModel;
 
  $pi = new PageIngestor($page);

  $pi->setFixedContentWidth('604');
  $pi->setSiteDomain('avianweb.com');

  $title = $pi->getTitle();
  $meta = $pi->getMeta();
  $content = $pi->getContent();
  $blocks = $pi->getFixedPixelBlocks();
  $links = $pi->getLinks();
  $images = $pi->getImages();

  $post = array(
    'post_author'    => 1, //The user ID number of the author.
    'post_content'   => $content, //The full text of the post.
    'post_excerpt'   => $meta['desc'], //For all your post excerpt needs.
    'post_status'    => 'publish', //Set the status of the new post.
    'post_title'     => $title, //The title of your post.
    'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
  );


  mysql_select_db('avianweb'); 
  $post_id = wp_insert_post($post, $err);

  if(!$post_id) Throw new Exception("Issue ingesting " . $pi->getFilename() . " with " . $post);

  if($err) Throw new Exception("Wordpress Error: $err " . $pi->getFilename() . " with " . $post);

  $pmr = array();
  $pmr[] = add_post_meta($post_id,'_su_title',$title,true);
  $pmr[] = add_post_meta($post_id,'_su_keywords',implode(', ',$meta['tags']),true);
  $pmr[] = add_post_meta($post_id,'_su_description',$meta['desc'],true);
  //var_dump($pmr);

  $pm = $PageModel;
 
  $pm->filename = $page;
  $pm->post_id = $post_id;
  $pm->links = $links;
  $pm->images = $images;
  $pm->fixedblocks = $blocks;

  $id = $pm->save();

  if(!$id) Throw new Exception("SupraModel err saving: " . $ip->getFilename() . " with " . $post);

  var_dump($page, $post_id, $id); 
}
