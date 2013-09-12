<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ParseError
 *
 * @author matt
 */
class ParseError {
    
    private $errorMsg;
    private $tagLine;
    private $tagIndex;
    private $endLine;
    private $endIndex;

    public function __construct($errorMsg, $tagLine = null, $tagIndex = null, $endLine = null, $endIndex = null) {
        $this->errorMsg = $errorMsg;
        $this->tagLine = $tagLine;
        $this->tagIndex = $tagIndex;
        $this->endLine = $endLine;
        $this->endIndex = $endIndex;
    }

    public function getErrorMsg() {
        return $this->errorMsg;
    }
    
    public function setErrorMsg($msg) {
        $this->errorMsg = $msg;
    }
    
    public function getTagLine() {
        return $this->tagLine;
    }
    
    public function setTagLine($ln) {
        $this->tagLine = $ln;
    }
    
    public function getTagIndex() {
        return $this->tagIndex;
    }
    
    public function setTagIndex($index) {
        $this->tagIndex = $index;
    }
    
    public function getEndLine() {
        return $this->endLine;
    }
    
    public function setEndLine($endline) {
        $this->endLine = $endline;
    }
    
    public function getEndIndex() {
        return $this->endIndex;
    }
    
    public function setEndIndex($index) {
        $this->endIndex = $index;
    }
    

    
}


?>
