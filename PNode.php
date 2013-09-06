<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PNode
 *
 * @author matt
 */
class PNode {
    
    /**
     * @var _type - the type of the node
     */
    private $_type;
   
    /**
    * @var _parent uid of the parent node 
    */
    private $_parent;
   
    /**
    * @var _children collection of uids for the child nodes 
    */
    private $_children = array();
   
    /**
     * @var _attr array of the nodes attributes, if any
     */
    private $_attr = array();
    
    /**
     *
     * @var type int - the linenumber of this node
     */
    private $_ln;
    
    /**
    * @var _uid for this node 
    */
    private $_uid;
 
    /**
     * PNode::__construct()
     * 
     * @param mixed $value
     * @param mixed $uid
     * @return void
     */
    public function __construct($value = null, $uid = null, $attr = null, $ln) {
        if(!isset($value)) {
            throw new Exception('A value is required to create a node');
        }
        $this->setValue($value);
        $this->setUid($uid);
        $this->setAttr($attr);
        $this->setLn($ln);
    }
 
    /**
     * PNode::setUid()
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
    
    /**
     * PNode::setAttr()
     * 
     * @param array $attr
     * @return
     */
    public function setAttr($attr = null) {
       $this->_attr = $attr;
    }
 
    /**
     * PNode::getUid()
     * 
     * @return string uid
     */
    public function getUid() {
        return $this->_uid;
    }
 
    
    public function setLn($ln) {
        $this->_ln = $ln;
    }
    
    /**
     * PNode::setValue()
     * 
     * @param mixed $value
     * @return void
     */
    public function setValue($value) {
        $this->_value = $value;
    }
 
    /**
     * PNode::getValue()
     * 
     * @return mixed
     */
    public function getValue() {
        return $this->_value;
    }
 
    /**
     * PNode::getParent()
     * 
    * gets the uid of the parent node
    * 
     * @return string uid
     */
    public function getParent() {
        return $this->_parent;
    }
 
    /**
     * PNode::setParent()
     * 
     * @param mixed $parent
     * @return void
     */
    public function setParent($parent) {
        $this->_parent = $parent;
    }
 
    /**
     * PNode::getChildren()
     * 
     * @return mixed
     */
    public function getChildren() {
        return $this->_children;
    }
 
    /**
     * PNode::setChild()
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
     * PNode::anyChildren()
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
     * PNode::childrenCount()
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
