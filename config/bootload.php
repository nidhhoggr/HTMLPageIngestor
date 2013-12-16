<?php

require_once(dirname(__FILE__) . '/../libs/HTML-DOM-Parser/simple_html_dom.php');
require_once(dirname(__FILE__) . '/../libs/SupraModel/SupraModel.class.php');

$dbuser = 'root';
$dbpassword  = 'root';
$dbname = 'avianweb_conversion';
$dbhost = 'localhost';
$driver = 'mysql';

$connection_args = compact('dbuser','dbname','dbpassword','dbhost','driver');

//EXTEND THE BASE MODEL
class PageModel extends SupraModel {

    //SET THE TABLE OF THE MODEL AND THE IDENTIFIER
    public function configure() {

        $this->setTable("pages");
    }
}

$PageModel = new PageModel($connection_args);
