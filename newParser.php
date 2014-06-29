<?php

require_once 'Services/W3C/HTMLValidator.php';
require 'Error.php';
require 'Warning.php';

class newParser {
    
    var $file;
    var $filepath; 
    var $errors;
    var $warnings; 
    
    public function __construct($filepath) {
        $this->errors = array();
        $this->warnings = array();
        if (file_exists($filepath)) {
            $this->file = file_get_contents($filepath);
            $this->filepath = $filepath;
            if (0 == filesize($this->filepath)) {
                throw new Exception("Error, File was empty!");
            }
        } else {
            throw new Exception("Error, File not found!");
        }
    }
    
    public function parse() {
        $v = new Services_W3C_HTMLValidator();
        //$v->doctype = 'HTML 4.01 Strict';
        $v->doctype = 'HTML5';
        $v->uploaded_file = $this->file;
        $v->output =  'soap12';
        $r = $v->validateFile($this->filepath);
        if ($r->isValid()) {
          return true;
        } else {
            foreach ($r->errors as $e) {
                $error = new Error($e->messageid, $e->message, $e->line, $e->col, $e->source);
                array_push($this->errors, $error);
            }
            foreach ($r->warnings as $w) {
             $warning = new Warning($w->messageid, $w->message, $w->line, $w->col, $w->source);
             array_push($this->warnings, $warning);
            }
            return false;
        }
    }
       
    public function getErrors() {
        return $this->errors;
    }
    
    public function getWarnings() {
        return $this->warnings;
    }
}

?>