<?php
require_once(dirname(__FILE__) . '/bootload.php');
require_once(dirname(__FILE__) . '/PageIngestor.class.php');

$page = 'AverageBirdWeights.htm';
$pi = new PageIngestor($page);

$pi->setFixedContentWidth('604');
$pi->setSiteUrl('604');

//var_dump($pi->getTitle());

//print_r($pi->getMeta());
//var_dump($pi->getContent());

//$blocks = $pi->getFixedPixelBlocks();
//print_r($blocks); 

//$links = $pi->getLinks();
//var_dump($links); 
