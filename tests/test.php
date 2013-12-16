<?php
require_once(dirname(__FILE__) . '/../config/bootload.php');
require_once(dirname(__FILE__) . '/../classes/PageIngestor.class.php');

$page = dirname(__FILE__) . '/../pages/AverageBirdWeights.htm';
$pi = new PageIngestor($page);

$test1 = '<table width="90%" border="1" align="center">';
$test2 = '<td width="159" bgcolor="#003300">';

var_dump($pi->isPixelFix(str_get_html($test1)));  //false
var_dump($pi->isPixelFix(str_get_html($test2)));  //true

//var_dump(array_unique($info));

