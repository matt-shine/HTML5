<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AttributeInfo
 *
 * @author matt
 */
class AttributeInfo {
    private $name;
    private $possibleValues;
    
    public function __construct($name, $possibleValues) {
        $this->name = $name;
        $this->possibleValues = $possibleValues;
    }
    
    public function getName() {
        return $this->name;
    }
    
   public function getValues() {
       return $this->possibleValues;
   }
}

?>
