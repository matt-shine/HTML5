<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AttributeList
 *
 * @author matt
 */
class AttributeList {
    
    private $attributes;
    
       public function __construct() {
        $f = file_get_contents('json/attributes.json');
        $attributes = json_decode($f);
        $this->attributes = array();
        foreach ($attributes as $attribute) {
            array_push($this->attributes, new AttributeInfo($attribute->attribute, $attribute->possiblevalues));
        }
    }
    
    /**
     * Return the AttributeInfo class for the given attribute, false if
     * the attribute doesn't have specific required values.
     * 
     * @param type $attName
     * @return mixed
     */
    public function getAttributeInfo($attName) {
        foreach ($this->attributes as $att) {
            if ($att->getName() === $attName) {
                return $att;
            }
        }
        return false;
    }
}

?>
