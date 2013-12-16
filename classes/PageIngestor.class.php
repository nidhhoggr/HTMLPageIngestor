<?php

class PageIngestor {

  private 
    $site_domain,
    $content_width = null;

  function __construct($page) {

    $this->page = file_get_html($page);
    $this->_setMeta();
    $this->_setContent();
  }

  private function _setMeta() {

    $meta['desc'] = $this->page->find('meta[name=description]', 0)->content;
    $tags = $this->page->find('meta[name=keywords]', 0)->content;
    $meta['tags'] = explode(',', $tags);
    $this->meta = $meta;
  }

  private function _setContent() {
    $this->content = $this->page->find('div.content', 0);
  }

  public function getMeta() {
    return $this->meta;
  }
  
  public function getTitle() {
    return $this->page->find('title', 0)->innertext;
  }

  public function getContent() {
    return $this->content->innertext;
  }

  public function getLinks() {

    if(is_null($this->site_domain))
      throw new Exception('Must set the site domain');
 
    foreach($this->page->find('a') as $anchor) {
     
      $hrefs[] = $anchor->href;
    }
  
    $links = array_count_values($hrefs);

    foreach($links as $link=>$count) {

      if ((substr($link, 0, 7) == 'http://') || (substr($link, 0, 8) == 'https://')) {
        if(strstr($link, $this->site_domain)) {
          $gl[] = compact('link','count');
        }
      }
      else if(!strstr($link,'mailto:')) { 
        $gl[] = compact('link','count');
      }
    }

    return $gl;
  } 

  public function getBlocksOfFixedDimensions() {

    $blocks = $this->content->find('*[height], *[width]');

    foreach($blocks as $block) {
 
      $info[] = $this->getBOFDInfo($block);
    } 

    return $info;
  }

  public function getBOFDInfo($block) {

    $info['obj'] = $block; 
    $info['tag'] = $block->tag;
    $info['content'] = $block->innertext;
    $info['taginfo'] = $this->_getBOFDTagInfo($block);
    return $info;
  }

  private function _getBOFDTagInfo($block) {
 
    $taginfo = split('>',$block->outertext);
    return $taginfo[0] . '>';
  }

  public function isPixelFix($elObj) {
    $width = $elObj->width;
    return !strstr($width,'%');
  }

  public function getFixedPixelBlocks() {

    $blocks = $this->getBlocksOfFixedDimensions();

    foreach($blocks as $block) {
      if($this->isPixelFix($block['obj'])) {
        $info[] = $block['taginfo'];
        $blocks[$block['taginfo']] = $block['obj'];
      }
    }

    $counted = array_count_values($info);
    
    foreach($counted as $info=>$count) {
      $block = array('obj'=>$blocks[$info]);
      $overall[] = array(
        'info'=>$info, 
        'count'=>$counted[$info],
        'resize'=> $this->getBlockSuggestedPercentage($block)
      );
    }

    return $overall;
  }

  public function getBlockSuggestedPercentage($block) {
    if(is_null($this->content_width)) 
      throw new Exception("Must set the content width");

    $el = $block['obj'];
    $width = $el->width;
    $suggested = ($width / $this->content_width);
    return round($suggested * 100,0) . '%';
  }
 
  public function setFixedContentWidth($width) {
    $this->content_width = $width;
  }

  public function setSiteDomain($domain) {
    $this->site_domain = $domain;
  } 
}
