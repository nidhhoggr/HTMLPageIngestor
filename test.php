<?php
require_once(dirname(__FILE__) . '/bootload.php');
require_once(dirname(__FILE__) . '/PageIngestor.class.php');

$page = 'AverageBirdWeights.htm';
$pi = new PageIngestor($page);

$test1 = '<table width="90%" border="1" align="center">';
$test2 = '<td width="159" bgcolor="#003300">';

var_dump($pi->isPixelFix($test1));  //false
var_dump($pi->isPixelFix($test2));  //true

//var_dump(array_unique($info));

