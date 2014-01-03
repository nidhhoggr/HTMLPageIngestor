<?php
require_once(dirname(__FILE__) . '/config/bootload.php');
require_once(dirname(__FILE__) . '/classes/PageIngestor.class.php');
require_once( dirname(__FILE__) . '/../wp-load.php' );


$query = 'hummingbirds';

$conditions = array("post_title like '%".$query."%'");

$posts = $WordpressModel->findBy(compact('conditions'));

foreach($posts as $post) {

  //$seo_desc = get_post_meta($post->ID, '_su_description',true);
  //$seo_keys = get_post_meta($post->ID, '_su_keywords',true);

  $post_content = $post->post_content;
  $post_title = $post->post_title;

  $pc_len = strlen($post_content);
  $pt_len = strlen($post_title);

  $q_len = strlen($query);
  $d_len = strlen($seo_desc);
  $k_len = strlen($seo_keys);

  $seo_desc_count = substr_count($seo_desc,$query);
  $seo_keys_count = substr_count($seo_keys,$query);

  //$count = (($q_len * $seo_keys_count) / $k_len) + (($q_len * $seo_desc_count) / $d_len); 

  $pc_count = substr_count($post_content,$query);
  $pt_count = substr_count($post_title,$query);

  $pc_pc = $q_len * $pc_count / $pc_len;
  $pt_pc = $q_len * $pt_count / $pt_len;

  $count = $pc_pc + $pt_pc;

  var_dump($count);

  $wp_posts[$post->ID] = $post;

  $sortable[$post->ID] = $count;
}

asort($sortable);

foreach(array_keys($sortable) as $post_id) {
  var_dump($wp_posts[$post_id]->post_title,$sortable[$post_id]);
}
