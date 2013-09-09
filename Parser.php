<?php

require 'PNode.php';
require 'PTree.php';
require 'Tag.php';
require 'PTreeRecursiveIterator.php';
require 'PTreeIterator.php';
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
    var $tags; /* Holds tags found in the document (includes open and close tags) */
    var $numlines; /*number of lines in the file */
    var $errors; /* Holds errors detected in the document */
    var $tree; /* The parse tree */
    
    
    public function __construct($filepath) {
        $this->lines = array();
        
        $this->file = file_get_contents("test.html");
        $this->lines = explode("\n", $this->file);
        $this->numlines = count($this->lines);
        $this->tags = array();
        $this->errors = array();
        $this->tree = new PTree();
        $this->parse();
        $this->printTags();
        $this->createParseTree();
        
        $it = new PTreeRecursiveIterator($this->tree, new PTreeIterator($this->tree->getTree()), true);
        foreach ($it as $k => $v) {}
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
            $this->processLine($line, $lineArray, $i);
        }
    }
    
    private function printTags() {
        for ($i = 0; $i < count($this->tags); $i++) {
            $tag = $this->tags[$i];
            echo "Tag: " . $tag->getValue() . ", Line: " . $tag->getLine() . ", Index: " . $tag->getInd() . "<br />";
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
    
    
    private function processLine($line, $lineArr, $ln) {
        for ($i = 0; $i < count($lineArr); $i++) {
            if ($lineArr[$i] == '<') {
                $fullTag = $this->betweenStr($line, '<','>', $i);
                $tagAttr = null;
                $splitTag = explode(' ', $fullTag);
                if (count($splitTag) > 1) {
                    //we have attributes
                    $tagAttr = array();
                    $tagValue = $splitTag[0];
                    if (str_split($splitTag[0])[1] == '/') {
                        //attributes in a closing tag - error here
                    }
                    for ($j = 1; $j < count($splitTag)-1; $j++) {
                        array_push($tagAttr, $splitTag[$j]);
                    }
                } else {
                    $tagValue = $this->betweenStr($line, '<', '>', $i);
                }
          
                $tag = new Tag($tagValue, $tagAttr, $ln, $i);
                
                array_push($this->tags, $tag);
            }
        }
    }
    
    
    //TODO
    private function createParseTree() {
        if (count($this->tags) > 0) {
            $open = new SplStack(); //holds open tags
            $children = new SplStack(); //holds children of open tags
            //Set the first element as the head
            $first = $this->tags[0];            
            $headNode = new PNode($first->getValue(), $first->getLine(), $first->getInd(),null, $first->getAttr());
            $headNode->setUid();
            $this->tree->addFirst($headNode->getUid()); //add first node to tree
            $open->push($first); // push the first tag onto the stack
            for ($i = 1; $i < count($this->tags); $i++) {
                $currentTag = $this->tags[$i];
                if ($this->startsWith($currentTag->getValue(), "/")) { //Closing tag here (e.g. </head>)
                    if (strpos(strtolower($currentTag->getValue()), strtolower($open->top()->getValue())) != 1) {
                        //TODO: Generate an error here - misnested
                    } else {
                        //Closing tag which matches the currently open tag
                        $tagNode = new PNode($currentTag->getValue(), $currentTag->getLine(), 
                        $currentTag->getInd(), null, $currentTag->getAttr());
                        $tagNode->setUid();
                        $tagNode->setParent($tagNode->getUid(), $open->top()->getUid());
                        //add any elements in the children stack as this nodes children
                        while (!$children->isEmpty()) {
                            $tagNode->setChild($tagNode->getUid(), $children->pop()->getUid());
                        }
                        $tempNode = $open->pop(); //remove the current parent
                        if (!$open->isEmpty()){ //check if there are more tags on the stack
                            //don't need to do anything
                            continue;
                        } else {
                            //push the tempnode onto the child stack
                            $children->push($tempNode);
                        }
                    }
                } else {
                    $tnode = new PNode($currentTag->getValue(), $currentTag->getLine(), 
                        $currentTag->getInd(), null, $currentTag->getAttr());
                    $tnode->setUid();
                    $children->push($tnode);
                }
            }
        } else {
            //throw an error - nothing to parse
        }
    }  
    
    /**
     * 
     * Checks if the given string ($haystack) begins with the 
     * given string $needle
     * 
     * @param type $haystack - the string to check
     * @param type $needle - the prefix to check
     * @return boolean - true if haystack begins with needle, false else.
     */
    private function startsWith($haystack, $needle) {
        return $needle === "" || strpos($haystack, $needle) === 0;
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
        return substr($InputString, $StartLoc, ($EndLoc-$StartLoc));
    }
    
}

?>
