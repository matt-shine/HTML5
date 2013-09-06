<?php

require 'PNode.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parser
 *
 * @author matt
 */
class Parser {
    
    var $file; /* the file to parse */
    var $lines; /* array of lines in the file */
    var $elements; /* 2D array holding line number and html tags contained within */
    var $numlines; /*number of lines in the file */
    
    public function __construct($filepath) {
        $this->lines = array();
        
        $this->file = file_get_contents("test.html");
        $this->lines = explode("\n", $this->file);
        $this->numlines = count($this->lines);
        $this->elements = array();

        $this->parse();
        $this->printTags();
    }
    
    public function parse() {
        for ($i = 0; $i < $this->numlines; $i++) { //$i keeps track of line #
            $line = $this->lines[$i];
            //Convet line to an array of characters
            $lineArray = str_split($line);
            
            //Check if the line contains an unfinished tag
            if ($this->betweenStr($line, '<', "\n", $i) != false) {
                //it does, merge the next line with the current one
                $this->lines = $this->mergeLines($this->lines, $lineArray, $i);
                //Need to process this index again, decrement $i and continue
                $i--;
                continue;
            }
            $tags = $this->processLine($line, $lineArray);
            foreach ($tags as $tag) {
                if (!isset($this->elements[$i])) {
                    $this->elements[$i] = array();
                }
                array_push($this->elements[$i], $tag);
            }
        }
    }
    
    private function printTags() {
        for ($i = 0; $i < count($this->elements); $i++) {
            echo "Line " . $i . ":";
            foreach ($this->elements[$i] as $tag) {
                echo " " . htmlspecialchars($tag) . ", ";
            }
            echo '<br />';
        }
    }
    
    
    /**
     * 
     * Merges the $i'th line with its next line
     * 
     * @param type $lines
     * @param type $i
     */
    private function mergeLines($lines, $i) {
        $ind = (int)$i;
        if ($ind+1 > count($lines)) {
            //TODO: unfinished tag error should be raised here
        }
        $newString = $lines[$ind];
        $newString += $lines[$ind+1];
        $lines[$ind] = $newString;
        for ($j = $ind+1; $j < count($lines); $j++) {
            if ($j+1 >= count($lines)) {
                $lines[$j] = null;
            } else {
                $lines[$j] = $lines[$j+1];
            }
        }
        return $lines;
    }
    
    
    private function processLine($line, $lineArr) {
        $tags = array();
        for ($i = 0; $i < count($lineArr); $i++) {
            if ($lineArr[$i] == '<') {
                array_push($tags, $this->betweenStr($line, '<', '>', $i));
            }
        }
        return $tags;
    }
    
    
    
    private function createNode($tag, $location) {
        if (strpos($tag, '</')) {
            //close tag - find out the element
            
            
        }
    }
        
    
    // Grabs the text between two identifying substrings in a string.
    private function betweenStr($InputString, $StartStr, $EndStr=0, $StartLoc=0) {
        if (strlen($InputString) < $StartLoc) {
            return false;
        }
        if (($StartLoc = strpos($InputString, $StartStr, $StartLoc)) === false) {  
            return false; 
        }
        $StartLoc += strlen($StartStr);
        if (!$EndLoc = strpos($InputString, $EndStr, $StartLoc)) { 
            return false; 
        }
        return substr($InputString, $StartLoc-1, ($EndLoc-$StartLoc)+2);
}
    
}

?>
