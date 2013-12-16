<?php
require_once(dirname(__FILE__) . '/config/bootload.php');
require_once(dirname(__FILE__) . '/classes/PageIngestor.class.php');

$page = dirname(__FILE__) . '/pages/AverageBirdWeights.htm';
$pi = new PageIngestor($page);

$pi->setFixedContentWidth('604');
$pi->setSiteDomain('avianweb.com');

//var_dump($pi->getTitle());

//print_r($pi->getMeta());
//var_dump($pi->getContent());

//$blocks = $pi->getFixedPixelBlocks();
//print_r($blocks); 

$links = $pi->getLinks();
var_dump($links); 
