<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PTreeIterator
 *
 * @author matt - ref: http://phptouch.com/2011/04/17/implementation-of-a-tree-structure-in-php/
 */
class PTreeIterator extends ArrayIterator implements RecursiveIterator {
   /**
    * @var _list this is the hash table 
   */
    private $_list = array();
   /**
    * @var _next this is for the children 
   */
    private $_next = array();
   /**
    * @var _position the iterator position 
   */
    private $_position;
 
    /**
     * PTreeIterator::__construct()
     * 
     * @param mixed $list - the hash table
     * @param mixed $tree - 
     * @return PTreeIterator
   */
    public function __construct(array $list, array $tree = null) {
        $this->_list = $list;
 
        if(is_null($tree)) {
            reset($this->_list);
            $next = current($this->_list);
            $this->_next = $next->getChildren();
        } else {
            $this->_next = $tree;
        }
 
        parent::__construct($this->_next);
    }
 
    /**
     * PTreeIterator::current()
     * 
     * @return
   */
    public function current() {
      //get the object uid from the hash table
      //then get the object
        $current = parent::current();
        $nObj = $this->_list[$current];
        return $nObj;
    }
 
    /**
     * PTreeIterator::key()
     * 
     * @return
     */
    public function key() {
        $key = parent::key();
        $key = $this->_next[$key];
        return $key;
    }
 
    /**
     * PTreeIterator::hasChildren()
     * 
     * @return mixed
     */
    public function hasChildren() {
        $next = $this->_list[$this->key()];
        $next = $next->anyChildren();
        return $next;
    }
 
    /**
     * PTreeIterator::getChildren()
     * 
     * @return PTreeIterator
     */
    public function getChildren() {
        $childObj = $this->_list[$this->key()];
        $children = $childObj->getChildren();
        return new PTreeIterator($this->_list, $children);
    }
}

?>
