<?php

require_once(dirname(__FILE__) . '/../libs/HTML-DOM-Parser/simple_html_dom.php');
require_once(dirname(__FILE__) . '/../libs/SupraModel/SupraModel.class.php');

$dbuser = 'root';
$dbpassword  = 'root';
$dbname = 'avianweb_conversion';
$wpdbname = 'avianweb';
$dbhost = 'localhost';
$driver = 'mysql';

$connection_args = compact('dbuser','dbname','dbpassword','dbhost','driver');

$dbname = 'avianweb';
$wp_conn_args = compact('dbuser','dbname','dbpassword','dbhost','driver');


//EXTEND THE BASE MODEL
class PageModel extends SupraModel {

    //SET THE TABLE OF THE MODEL AND THE IDENTIFIER
    public function configure() {

        $this->setTable("page");
    }
}

class WordpressModel extends SupraModel {
  public function configure() {

    $this->setTable("wp_posts");
    $this->setTableIdentifier("ID");
  }
}

$PageModel = new PageModel($connection_args);

$WordpressModel = new WordpressModel($wp_conn_args); 
