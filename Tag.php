<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tag
 *
 * @author matt
 */
class Tag {
    
    private $_value;
    private $_attr = array();
    private $_line;
    private $_ind;
 
    
    public function __construct($value, $line, $ind, $attr=null) {
        $this->setValue($value);
        $this->setAttr($attr);
        $this->setLine($line);
        $this->setInd($ind);
        if ($attr != null) {
            
            $this->_attr = $attr;
            
        }
    }
    
    
    
    public function setValue($value) {
        $this->_value = $value;
    }
    
    public function getValue() {
        return $this->_value;
    }
    
    public function setAttr($attr) {
        array_push($this->_attr, $attr);
    }
   
    public function getAttr() {
        return $this->_attr;
    }
    
    public function setLine($ln) {
        $this->_line = $ln;
    }
    
    public function getLine() {
        return $this->_line;
    }
    
    public  function setInd($ind) {
        $this->_ind = $ind;
    }
    
    public function getInd() {
        return $this->_ind;
    }
    
    
    
}

?>
