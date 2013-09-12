<?php

require 'ParseError.php';

class HtmlValidator {
    
    private $tags;
    private $errors;
    
    public function __construct($tags) {
        $this->tags = $tags;
        $this->errors = array();
        $this->validateDoctype();
        $f = fopen("testing.txt", "a");
        foreach ($this->errors as $error) {
            
            fwrite($f, $error->getErrorMsg() . "\n");
            fwrite($f, count($this->tags[0]->getAttr()));
        }
    }
    
    private function validateDoctype() {
        $tag = $this->tags[0];
        if ($tag->getValue() != '!DOCTYPE') {
            /* !DOCTYPE not first tag */
            if ($tag->getValue() == 'DOCTYPE') {
                array_push($this->errors, new ParseError("DOCTYPE tag is missing an exclamation mark!", 0 ,0));
                return;
            }
            if (array_key_exists('DOCTYPE', $this->tags) && 
                    !array_key_exists('!DOCTYPE', $this->tags)) { 
                    /* !DOCTYPE not first tag + no '!' */
                    array_push($this->errors, new ParseError("DOCTYPE incorrectly 
                        formatted and in the wrong place!"), 0, 0); //include the place here
                    return;
            }
            if (!array_key_exists('!DOCTYPE', $this->tags)) {
                /* No !DOCTYPE in document */
                array_push($this->errors, new ParseError("DOCTYPE Declaration not found", 0, 0));
                return;
            }
            //multiple doctype declarations covered by validateSingular() 
        }
        $attArray = $tag->getAttr();
        if (count($attArray) != 1) {
            array_push($this->errors, new ParseError("DOCTYPE declarations should have a single attribute", 0, 0));
            return;
        }
        if (strtolower($attArray[0]) != 'html') {
            array_push($this->errors, new ParseError("DOCTYPE attribute does not match HTML5 specifications", 0, 0));
            return;
        }
        
    }
    
    
    
}


?>
