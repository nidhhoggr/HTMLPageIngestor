<?php

function isImage($img_url) {

  $img_formats = array("png", "jpg", "jpeg", "gif", "tiff","pdf","doc");//Etc. . . 
  $path_info = pathinfo($img_url);

  if (in_array(strtolower(@$path_info['extension']), $img_formats)) {
    return true;
  }

  return false;
}

function isFixedLink($page,$link) {

  global $PageModel;

  $levels = array('shop/','photographers/');

  foreach($levels as $level) { 

    if(strstr($page->filename,$level)) {

      $conditions = array('filename LIKE "'.$level.$link.'%"');

      $pg = $PageModel->findOneBy(compact('conditions'));

      if($pg) return $pg->filename;
    }
  }

  foreach($levels as $level) {

    $conditions = array('filename LIKE "'.$level.$link.'%"');

    $pg = $PageModel->findOneBy(compact('conditions'));

    if($pg) return $pg->filename;
  }

  return false;
}


function isBrokenPage($page) {

  if(strstr($page,'css/')) return true;
  if(strstr($page,'browser/')) return true;

    return false;
}

function isExceptionalBrokenLink($brk_link) {
  $brokenLinks = array(
    'shop',
    'photographers',
    'videos',
    'ttp://www.flickr.com/photos/joelnrosenthal/', //fixed on wordpress database
    'ttp://www.flickr.com/photos/hummingbirder/', //fixed on wordpress database
    ''
  );

  if (in_array($brk_link, $brokenLinks))
    return true;
  else
    return false;
}

function getContentOfReplacedPermalinks($page,$pi) {
  global $PageModel, $WordpressModel, $gotchas;

  if(isBrokenPage($page->filename)) {
    $gotchas['brokePage'][] = $page->filename;
    return false;
  }

  $post_content = false;

  //get wordpress content
  $conditions = array("ID = " . $page->post_id);
  $post = $WordpressModel->findOneBy(compact('conditions'));

  if(!$post) {
    var_dump($PageModel->getQuery(),$WordpressModel->getQuery());
    die ("No page found for " . $link["link"]);
  }
  else {
    $post_content = $post->post_content;

    foreach((array)$page->n_links as $link) {

      $link = @$link["link"];

      if($pi->isSiteDomainBased($link)) {
  
        //start maintaining state of oldlink
        $oldlink = $link;

        $link = str_replace('http://www.avianweb.com/','',$link);

        $itsDiv = false;

        if(substr($link,0,1) == "/")
          $link = ltrim($link,'/');

        if(strstr($link,'#')) {
          $linkX = explode('#',$link);
          $link = $linkX[0];
          $itsDiv = '#' . $linkX[1];
        }

        if(isImage($link)) {
          $gotchas['isImage'][$post->ID][] = $oldlink;
          continue;
        }
        if(isExceptionalBrokenLink($link)) {
          $gotchas['brokeLink'][$post->ID][] = $oldlink;
          continue;
        }

        $fl = isFixedLink($page,$link);
        if($fl) {
          $gotchas['fixedLink'][$post->ID][]['old'] = $oldlink;
          $gotchas['fixedLink'][$post->ID][]['new'] = $fl;
          $link = $fl;
        }

        $conditions = array("filename = '". $link ."'");

        $linked_page = $PageModel->findOneBy(compact('conditions'));

        if(!$linked_page) 
          die('Cannot find linked page for ' . $link);

        $conditions = array('ID = ' . $linked_page->post_id);

        $linkedPost = $WordpressModel->findOneBy(compact('conditions'));

        if(!$linkedPost)
          die('Cannot find linked post for ' . $linked_page->filename);

        mysql_select_db('avianweb');

        $permalink = get_permalink($linkedPost->ID);

        if($itsDiv) $permalink .= $itsDiv;

        var_dump("replacing {$linked_page->filename} with $permalink");

        $post_content = str_replace('"' . $oldlink,'"' . $permalink,$post_content);

      } else {
        continue;
      }
    }
  }
  
  $wpm = $WordpressModel;
  $wpm->ID = $post->ID;
  $wpm->post_content = mysql_real_escape_string($post_content);
  return $wpm;
}

