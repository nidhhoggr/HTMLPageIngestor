<?php
require_once(dirname(__FILE__) . '/config/bootload.php');
require_once(dirname(__FILE__) . '/classes/PageIngestor.class.php');
require_once( dirname(__FILE__) . '/../wp-load.php' );

$pi = new PageIngestor();

$pi->setFixedContentWidth('604');
$pi->setSiteDomain('avianweb.com'); 

$conditions = array('post_type = "page"', 'ID > 12213');

$posts = $WordpressModel->findBy(compact('conditions'));

foreach($posts as $post) {
}
