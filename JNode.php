<?php

/**
 * JNode
 * 
 * This is a simple class to construct a node
 * Please note that each node object will be 
 * eventually stored in a hash table where the 
 * hash will be a UID.
 * 
 * Note that in comparison to thee Doubly Linked List implementation
 * the children are now stored in an array
 * 
 * @package JTree   
 * @author Jayesh Wadhwani
 * @copyright Jayesh Wadhwani
 * @version 2011
 */
class JNode {
   /**
    * @var _value for the value field 
   */
    private $_value;
   /**
    * @var _parent uid of the parent node 
   */
    private $_parent;
   /**
    * @var _children collection of uids for the child nodes 
   */
    private $_children = array();
   /**
    * @var _uid for this node 
   */
    private $_uid;
    
    private $_ln;
    private $_ind;
    private $_selfClosed; /*  boolean, true if self closing tag e.g. <br /> */
    private $_closeTagFound; /* boolean, true if close tag was found during
                                    * parsing */
    private $_closeTagln;
    private $_closeTagInd;
    private $_errors = array();
    private $_warnings = array();
    private $attr = array();

    /**
     * JNode::__construct()
     * 
     * @param mixed $value
     * @param mixed $uid
     * @return void
     */
    public function __construct($value, $ln, $ind, $attr = null, $uid = null, $selfClosed=null) {
        if(!isset($value)) {
            throw new Exception('A value is required to create a node');
        }
        $this->setValue($value);
        $this->setUid($uid);
        $this->setln($ln);
        $this->setInd($ind);
        if (!($attr == null)) {
            $this->attr = $attr;
        }
        if (!($selfClosed) == null) {
            $this->_selfClosed = $selfClosed;
        } else {
            $this->_selfClosed = false;
        }
        $this->_closeTagFound = false;
    }
    
    public function setCloseTagFound() {
        $this->_closeTagFound = true;
    }
    
    public function getCloseTagFound() {
        return $this->_closeTagFound;
    }
    
    public function setCloseTagLn($ln) {
        $this->_closeTagln = $ln;
    }
    
    public function getCloseTagLn() {
        return $this->_closeTagln;
    }
    
    public function setCloseTagInd($ind) {
        $this->_closeTagInd = $ind;
    }
    
    public function getCloseTagInd() {
        return $this->_closeTagInd;
    }
       
    public function getErrors() {
        return $this->_errors;
    }
    
    public function getWarnings() {
        return $this->_warnings;
    }
    
    public function addErrors($errorArray) {
        foreach ($errorArray as $error) {
            array_push($this->_errors, $error);
        }
    }
    
    public function addWarnings($warningArray) {
        foreach ($warningArray as $warning) {
            array_push($this->_warnings, $warning);
        }
    }
      
    
 
    /**
     * JNode::setUid()
     * 
     * @param mixed $uid
     * @return
     */
    public function setUid($uid = null) {
        //if uid not supplied...generate
        if(empty($uid)) {
            $this->_uid = uniqid();
        } else {
            $this->_uid = $uid;
        }
    }
    
    public function getAttr() {
        return $this->attr;
    }
    
//    public function addAttr($att) {
//        array_push($this->attr, $att);
//    }
 
    /**
     * JNode::getUid()
     * 
     * @return string uid
     */
    public function getUid() {
        return $this->_uid;
    }
 
    /**
     * JNode::setValue()
     * 
     * @param mixed $value
     * @return void
     */
    public function setValue($value) {
        $this->_value = $value;
    }
 

    
    /**
     * JNode::getValue()
     * 
     * @return mixed
     */
    public function getValue() {
        return $this->_value;
    }
 
    public function setLn($ln) {
        $this->_ln = $ln;
    }
    
    public function getLn() {
        return $this->_ln;
    }
    
    public function setInd($ind) {
        $this->_ind = $ind;
    }
    
    public function getInd() {
        return $this->_ind;
    }
    
    /**
     * JNode::getParent()
     * 
    * gets the uid of the parent node
    * 
     * @return string uid
     */
    public function getParent() {
        return $this->_parent;
    }
 
    /**
     * JNode::setParent()
     * 
     * @param mixed $parent
     * @return void
     */
    public function setParent($parent) {
        $this->_parent = $parent;
    }
 
    /**
     * JNode::getChildren()
     * 
     * @return mixed
     */
    public function getChildren() {
        return $this->_children;
    }
 
    /**
     * JNode::setChild()
     * 
    * A child node's uid is added to the childrens array
    * 
     * @param mixed $child
     * @return void
     */
    public function setChild($child) {
        if(!empty($child)) {
            $this->_children[] = $child;
        }
    }
 
    /**
     * JNode::anyChildren()
     * 
    * Checks if there are any children 
    * returns ture if it does, false otherwise
    * 
     * @return bool
     */
    public function anyChildren() {
        $ret = false;
 
        if(count($this->_children) > 0) {
            $ret = true;
        }
        return $ret;
    }
 
    /**
     * JNode::childrenCount()
     * 
    * returns the number of children
    * 
     * @return bool/int
     */
    public function childrenCount() {
      $ret = false;
     if(is_array($this->_children)){
      $ret = count($this->_children);
     }
     return $ret;
    }
}

?>
