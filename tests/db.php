<?php
require_once(dirname(__FILE__) . '/../config/bootload.php');
require_once(dirname(__FILE__) . '/../classes/PageIngestor.class.php');
require_once( dirname(__FILE__) . '/../../wp-load.php' );

$page = dirname(__FILE__) . '/../pages/AverageBirdWeights.htm';
$pi = new PageIngestor($page);

$pi->setFixedContentWidth('604');
$pi->setSiteDomain('avianweb.com');

$title = $pi->getTitle();
$meta = $pi->getMeta();
$content = $pi->getContent();
$blocks = $pi->getFixedPixelBlocks();
$links = $pi->getLinks();
$images = $pi->getImages();
//print_r($images);
$filename = $pi->getFilename();


function getTagsInput($tags) {
  if(!count($tags)) return null;

  foreach($tags as $tag) {
    $tagstrArr[] = '<'.trim($tag).'>';
  }
  $tags = implode(',',$tagstrArr);
  return $tags;
}

$post = array(
  'post_author'    => 1, //The user ID number of the author.
  'post_content'   => $content, //The full text of the post.
  'post_excerpt'   => $meta['desc'], //For all your post excerpt needs.
  //'post_name'      => $title, // The name (slug) for your post
  'post_status'    => 'publish', //Set the status of the new post.
  'post_title'     => $title, //The title of your post.
  'post_type'      => 'page', //You may want to insert a regular post, page, link, a menu item or some custom post type
  'tags_input'     => getTagsInput($meta['tags']), //For tags.
);



//$post_id = wp_insert_post($post);

//if(!$post_id) Throw new Exception("Issue ingesting " . $ip->getFilename() . " with " . $post);


$pm = $PageModel;

var_dump($pm);

/* 
$pm->filename = $filename;
$pm->post_id = $post_id;
$pm->links = $links;
$pm->images = $images;
$pm->fixedblocks = $blocks;
$id = $pm->save();
*/

//$page = $pm->findOneBy(array('conditions'=>array("id=4")));
