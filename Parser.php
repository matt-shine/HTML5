<?php

require 'JNode.php';
require 'JTree.php';
require 'Tag.php';
require 'JTreeRecursiveIterator.php';
require 'JTreeIterator.php';
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
        $this->tree = new JTree();
        $this->parse();
        $this->printTags();
        $this->createParseTree();
                  
        
        $it = new JTreeRecursiveIterator($this->tree, new JTreeIterator($this->tree->getTree()), true);
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
            if (count($tag->getAttr()) > 0) {
                for ($j = 0; $j < count($tag->getAttr()); $j++) {
                    echo "tag: " . $tag->getValue() . ", Location: " . $tag->getLine(). " " . $tag->getInd() . ", Attr: " . $tag->getAttr()[$j] . "<br />";
                    }
            } else {
                echo "Tag: " . $tag->getValue() . ", Line: " . $tag->getLine() . ", Index: " . $tag->getInd() . "<br />";
            }
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
                    for ($j = 1; $j < count($splitTag); $j++) {
                        array_push($tagAttr, $splitTag[$j]);
                    }
                } else {
                    $tagValue = $this->betweenStr($line, '<', '>', $i);
                }
                if (isset($tagAttr)) {
                    $tag = new Tag($tagValue, $ln, $i, $tagAttr);
                } else {
                    $tag = new Tag($tagValue, $ln, $i, null);
                }
                
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
            
            $uid = $this->tree->createNode($first->getValue(), $first->getLine(), $first->getInd(), $first->getAttr(), null);
            //$this->tree->addFirst($uid);
            $this->tree->addChild(null, $uid);
            
            //$f = fopen("testing.txt", "a");
            //fwrite($f, "First node: " . $uid . "\n");
            
            
            if ($this->tree->getValue($uid) != "!DOCTYPE") {
                //TODO: error here
                $open->push($first); // push the first tag onto the stack
            }
            
            
            
            for ($i = 1; $i < count($this->tags); $i++) {
                $currentTag = $this->tags[$i];
                                
                if ($this->startsWith($currentTag->getValue(), "/")) { //Closing tag here (e.g. </head>)
                        $this->processEndTag($currentTag, $open, $children, $uid, $open->isEmpty());
                } else {
                    $this->processStartTag($currentTag, $open, $open->isEmpty());               
                }
            }
        } else {
            //throw an error - nothing to parse
        }
    }  
     
    private function processStartTag(&$tag, &$open, $empty) {
        
        $tagUid = $this->tree->createNode($tag->getValue(), $tag->getLine(), $tag->getInd(), $tag->getAttr(), null);
        if ($empty) {
             $this->tree->addChild(null, $tagUid);
        } else {
            $this->tree->addChild($open->top(), $tagUid);
        }
        $open->push($tagUid);

    }
    
    private function processEndTag(&$tag, &$open, &$children, &$head, $empty) {
        if ($open->isEmpty()) {
         //TODO: closing tag without a corresponding open tag - error here
        } else {
            if (strcmp(ltrim($tag->getValue(), '/'), $this->tree->getValue($open->top())) != 0) {
                //TODO: Generate an error here - misnested
            } else {
             /* Closing tag which matches the currently open tag */
             $tagUid = $this->tree->createNode(ltrim($tag->getValue(), '/'), $tag->getLine(), $tag->getInd(), $tag->getAttr(), null);  
             $this->tree->setParent($tagUid, $open->top());
            
            /* add any elements in the children stack as this nodes children */
             while (!$children->isEmpty()) {
                 $this->tree->setChild($tagUid, $this->tree->getNode($children->pop()));
             }
             
             /* Remove the current parent */
             $tempNode = $open->pop();
             
             /* Check if there are more tags on the open stack */
             if ($empty){ 
                 /* Top level tag */
                 $this->tree->addChild(null, $tempNode);
             } else {
                 /* Push the tempnode onto the child stack */
                 $children->push($tempNode);                 
                }
            }
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
