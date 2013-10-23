<?php

/**
 * Description of TagInfo
 *
 * @author matt
 */
class TagInfo {
    
    private $name;
    private $globalAttributes;
    private $requiredAttributes;
    private $eventAttributes;
    private $tagIsDeprecated;
    private $optionalAttributes;
    private $deprecatedAttributes;
    private $description;
    private $within;
    private $closingtag;
    private $selfclosing;
    
    public function __construct($name, $globals, $requiredAtt, $eventAtt, $isDeprecated, $optional, $deprecatedAtt, $description, $within, $closingtag, $selfclosing) {
        $this->name = $name;
        $this->globalAttributes = $globals;
        $this->requiredAttributes = $requiredAtt;
        $this->eventAtt = $eventAtt;
        $this->tagIsDeprecated = $isDeprecated;
        $this->optionalAttributes = $optional;
        $this->deprecatedAttributes = $deprecatedAtt;
        $this->description = $description;
        $this->within = $within;
        $this->closingtag = $closingtag;
        $this->selfclosing = $selfclosing;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function areGlobalAttributesSupported() {
        return $this->globalAttributes;
    }
    
    public function getRequiredAttributes() {
        return $this->requiredAttributes;
    }
    
    public function areEventAttributesSupported() {
        return $this->eventAttributes;
    }
    
    public function isTagDeprecated() {
        return $this->tagIsDeprecated;
    }
    
    public function getOptionalAttributes() {
        return $this->optionalAttributes;
    }
    
    public function getDeprecatedAttributes() {
        return $this->deprecatedAttributes;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getWithin() {
        return $this->within;
    }
    
    public function requiresClosingTag() {
        return $this->closingtag;
    }
    
    public function isSelfClosing() {
        return $this->selfclosing;
    }
    
}

?>
