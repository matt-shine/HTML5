<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PTree
 *
 * @author matt - ref: http://phptouch.com/2011/04/17/implementation-of-a-tree-structure-in-php/
 */
class PTree {
    /**
     * @var UID for the header node
     */
     private $_head;
     
     /**
      * @var size of the list
      */
     private $_size;
     
     /**
      * @var hash table to store nodes
      */
     private $_list = array();
     
     /**
      * PTree::construct()
      * 
      * Constructor, initalized an empty Parse Tree
      */
     public function __construct() {
         $this->_head = $this->createNode('HEAD');
         $this->_size = 0;
     }
     
     public function getTree() {
        return $this->_list;
    }
     
     
     /**
      * PTree::getNode()
      * Given a UID get the node object 
      *
      * @param mixed $uid
      * @return PNode/Boolean
      */
     public function getNode($uid) {
         if (empty($uid)) {
             throw new Exception('A unique id is required.');
         }
         $ret = false;
         //look for node in the  hash table
         if (array_key_exists($uid,$this->_list) == true) {
             $ret = $this->_list[$uid];
         }
         return $ret;
     }
     
     
     
     /**
      * PTree::setChild()
      * 
      * Given a UID for a node, set it as the next UID for
      * the node.
      * 
      * @param type $uid
      * @param type $chilUid
      */
     public function setChild($uid, $childUid) {
         if (empty($uid) || empty($childUid)) {
             throw new Exception('Both from and to UIDs are required');
         }
         //get the node object for the parent uid
         $node = $this->getNode($uid);
         
         if ($node !== false) {
             $node->setChild($childUid);
         }
     }
     
     /**
      * PTree::setParent()
      * 
      * Sets the parent of a given to the given node uid.
      * 
      * @param type $uid
      * @param type $parentUid
      * @throws Exception
      */
     public function setParent($uid, $parentUid) {
         if (empty($uid) || empty($parentUid)) {
             throw new Exception('Both from and to UIDs are required');
         }
         //get the child node
         $node = $this->getNode($uid);
         
         if ($node !== false) {
             $node->setParent($parentUid);
         }
     }
     
     /**
      * PTree::createNode()
      * 
      * Creates a node and stores in the hash table
      * 
      * @param mixed $value
      * @param mixed $uid
      * @return string $uid
      * @throws Exception
      */
     public function createNode($value, $uid = null) {
         if (!isset($value)) {
             throw new Exception('A value is required to create a node');
         }
         
         $node = new PNode($value, 0, 0, null, null);
         $node->setUid();
         $uid = $node->getUid();
         $this->_list[$uid] = $node;
         return $uid;
     }
     
     /**
     * PTree::addChild()
     * 
     * @param mixed $parentUid
     * @param mixed $childUid
     * @return
     */
    public function addChild($parentUid = null, $childUid) {
        if(empty($childUid)) {
            throw new Exception('A UID for the child is required.');
        }
      //if no parent assume it is the head
        if(empty($parentUid)) {
            $parentUid = $this->_head;
        }
        //parent points to child
        $this->setChild($parentUid, $childUid);
 
        //child points to parent
        $this->setParent($childUid, $parentUid);
 
        return $childUid;
    }
    
      /**
     * PTree::addFirst()
    * Add the first child right after the head
     * 
     * @param mixed $uid
     * @return void
     */
    public function addFirst($uid) {
        if(empty($uid)) {
            throw new Exception('A unique ID is required.');
        }
        $this->addChild($this->_head, $uid);
    }
 
   /**
    * PTree::getChildren()
    * 
    * This is a helper function to get the child node uids given the node uid
    * 
    * @param mixed $uid
    * @return mixed
    */
    public function getChildren($uid) {
        if(empty($uid)) {
            throw new Exception('A unique ID is required.');
        }
 
        $node = $this->getNode($uid);
 
        if($node !== false) {
            return $node->getChildren();
        }
    }
 
   /**
    * PTree::getParent()
    * 
    * This is a helper function to get the 
    * parent node uid
    * 
    * @param mixed $uid
    * @return string $uid
    */
    public function getParent($uid) {
        if(empty($uid)) {
            throw new Exception('A unique ID is required.');
        }
        $ret = false;
      $node = $this->getNode($uid);
 
        if($node !== false) {
            $ret = $node->getParent();
        }
      return $ret;
    }
 
    /**
     * PTree::getValue()
     * 
     * @param mixed $uid
     * @return
     */
    public function getValue($uid) {
        if(empty($uid)) {
            throw new Exception('A unique ID is required.');
        }
 
        $node = $this->getNode($uid);
        return $node->getValue();
    }
}

?>
