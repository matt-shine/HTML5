<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HtmlTree
 *
 * @author matt
 */
class HtmlTree {
    
    private $head;
    
    private $list = array();
    
    public function __construct() {
        $this->head = new Tag('HEAD', null, -1, -1);
    }
    
    public function getHead() {
        return $this->head;
    }
    
    public function getTree(){
        return $this->tree;
    }
    
    public function addTag($tagId, $parentId) {
        if (!array_key_exists($parentId, $this->list)) {
            array_push($this->list, $parentId);
        }
        $this->list[$parentId]->addChild($tagId);
    }
    
    public function getTag($tagId) {
        return $this->list[$tagId];
    }
     
}

?>
