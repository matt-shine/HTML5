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
    private $_attr;
    private $_line;
    private $_ind;
    
    public function __construct($value, $attr, $line, $ind) {
        $this->setValue($value);
        $this->setAttr($attr);
        $this->setLine($line);
        $this->setInd($ind);
    }
    
    public function setValue($value) {
        $this->_value = $value;
    }
    
    public function getValue() {
        return $this->_value;
    }
    
    public function setAttr($attr) {
        $this->_attr = $attr;
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
