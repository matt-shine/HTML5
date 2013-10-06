<?php
session_start();
require 'JNode.php';
require 'JTree.php';
require 'Tag.php';
require 'JTreeRecursiveIterator.php';
require 'JTreeIterator.php';

/**
 * Description of Parser
 *
 * @author matt
 */
class Parser {
    
    var $file; /* the file to parse */
    var $lines; /* array of lines in the file */
    var $preservedLines;
    var $tags; /* Holds tags found in the document (includes open and close tags) */
    var $numlines; /*number of lines in the file */
    var $nodesWithErrors; /* Holds errors detected in the document */
    var $tree; /* The parse tree */
    private $_open;
    private $_children;
    private $firstNodeUid;
    /**
     * Constructor
     * 
     * @param type $filepath - path to the file to be validated
     * @throws Exception
     */
    public function __construct($filepath) {
        $this->lines = array();
        if (file_exists($filepath)) {
            $this->file = file_get_contents($filepath);
        } else {
            throw new Exception("Error, File not found!");
        }
        $this->lines = explode("\n", $this->file);
        $this->numlines = count($this->lines);
        $this->preservedLines = explode("\n", $this->file);
        if (!isset($this->numlines) || $this->numlines < 2) {
            throw new Exception("File was empty!");
        }
        $this->tags = array();
        $this->nodesWithErrors = array();
        $this->tree = new JTree();
    }
    
    public function runValidator() {
        //Iterate through the tree - the iterator currently calls NodeValidator on each node
        $it = new JTreeRecursiveIterator($this->tree, 
                new JTreeIterator($this->tree->getTree()), true);
        
        
        foreach ($it as $v) {
            if ($v->getUid() == $this->firstNodeUid) {
                $validator = new NodeValidator($v, $this->tree, true);
            } else {
                $validator = new NodeValidator($v, $this->tree);
            }
            $validator->validate();
            $errors = $v->getErrors();
            if (!empty($errors)) {
                if (!empty($errors)) {
                    array_push($this->nodesWithErrors, $v);
                }
                
            }
        }
        $_SESSION['lines'] = $this->preservedLines;
        $_SESSION['nodesWithErrors'] = $this->nodesWithErrors;
        header('Location: results.php');
    }
    
    
    /**
     * Parses the document (as an array of lines) and extract
     * html tags.
     */
    public function parse() {
        $count = $this->numlines;
        for ($i = 0; $i < $count; $i++) { //$i keeps track of line #
            $line = $this->lines[$i];
            //Convet line to an array of characters
            $lineArray = str_split($line);
            
            //Check if the line contains an unfinished tag
            if ($this->betweenStr($line, "<", ">") == false) {
                //it does, merge the next line with the current one;
                $this->lines = $this->mergeLines($this->lines, $i);
                //Need to process this index again, decrement $i and continue
                $i--;
                $count--;
                continue;
            }
        $this->processLine($line, $lineArray, $i);
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
        $ind = (int)$i+1;
        if ($ind > count($lines)) {
            //TODO: unfinished tag error should be raised here
        }
        $newString = $lines[$i];
        $newString += $lines[$ind];
        
        $lines[$i] = $newString;
        for ($j = $ind; $j < count($lines); $j++) {
            if ($j+1 >= count($lines)) {
                $lines[$j] = null;
            } else {
                $lines[$j] = $lines[$j+1];
            }
        }
        return $lines;
    }
    
    /**
     * Process a line from the html file, adding any tags found to the 
     * array of tags.
     * 
     * @param type $line
     * @param type $lineArr
     * @param type $ln
     */
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
                    $test = str_split($splitTag[0]);
                    if ($test[1] == '/') {
                        //attributes in a closing tag - error here
                    }
                    for ($j = 1; $j < count($splitTag); $j++) {
                        array_push($tagAttr, $splitTag[$j]);
                    }
                } else {
                    $tagValue = $this->betweenStr($line, '<', '>', $i);
                }
                $selfClosing = false;
                if (strripos($fullTag, "/") == strlen(($fullTag)-1)) {
                    $selfClosing = true;
                }
                if (isset($tagAttr)) {
                    $tag = new Tag($tagValue, $ln, $i, $tagAttr, $selfClosing);
                } else {
                    $tag = new Tag($tagValue, $ln, $i, null, $selfClosing);
                }
                
                array_push($this->tags, $tag);
            }
        }
    }
    
    
    /**
     * 
     */
    public function createParseTree() {
        if (count($this->tags) > 0) {
            
            
            $this->_open = new SplStack(); //holds open tags
            $this->_children = new SplStack(); //holds children of open tags

            //Set the first element as the head
            $first = $this->tags[0];            
            
            $uid = $this->tree->createNode($first->getValue(), $first->getLine(), $first->getInd(), $first->getAttr(), null);
            $this->tree->addChild(null, $uid);          
            $this->firstNodeUid = $uid; //Store the first nodes UID
            
            for ($i = 1; $i < count($this->tags); $i++) {
                $currentTag = $this->tags[$i];
                                
                if ($this->startsWith($currentTag->getValue(), "/")) { //Closing tag here (e.g. </head>)
                        $this->processEndTag($currentTag);
                } else {
                    $this->processStartTag($currentTag);
                }
            }
        } else {
            //throw an error - nothing to parse
        }
    }  
    
    /**
     * 
     * @param type $tag
     * @param type $open
     * @param type $empty
     */
    private function processStartTag($tag) {
        $tagUid = $this->tree->createNode($tag->getValue(), $tag->getLine(), $tag->getInd(), $tag->getAttr(), null, $tag->wasSelfClosed());
        $this->_open->push($tagUid);
    }
    
    /**
     * 
     * @param type $tag
     * @param type $open
     * @param type $children
     * @param type $head
     * @param type $empty
     */
    private function processEndTag($tag) {
        if ($this->_open->isEmpty()) {
         //TODO: closing tag without a corresponding open tag - error here
        } else {
            if (strcmp(ltrim($tag->getValue(), '/'), $this->tree->getValue($this->_open->top())) != 0) {
                //TODO: Generate an error here - misnested
            } else {
                /* Closing tag which matches the currently open tag */
                $currentTag = $this->_open->pop();
                $node = $this->tree->getNode($currentTag);
                $node->setCloseTagLn($tag->getLine());
                $node->setCloseTagInd($tag->getInd());

               /* add any elements in the children stack as this nodes children */
                while (!$this->_children->isEmpty()) {
                    $child = $this->tree->getNode($this->_children->pop());
                    //Add as a parent
                    $this->tree->setChild($currentTag, $child->getUid());
                }

                /* Check if there are more tags on the open stack */
                if ($this->_open->isEmpty()){ 
                    /* Top level tag */
                    $this->tree->addChild(null, $currentTag);
                } else {
                    /* Push the tempnode onto the child stack */
                    $this->_children->push($currentTag);                 
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
    
    

    /**
     * Grabs the text between two identifying substrings in a string.
     * 
     * @param type $InputString
     * @param type $StartStr
     * @param type $EndStr
     * @param type $StartLoc
     * @return boolean
     */
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
