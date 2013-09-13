<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NodeValidator
 *
 * @author matt
 */

class NodeValidator {
    
    private $validTags = array("!--","--","!DOCTYPE","a","abbr","address",
        "area","article","aside","audio","b","base","bdi","bdo","blockquote",
        "body","br","button","canvas","caption","cite","code","col","colgroup",
        "command","data","datagrid","datalist","dd","del","details","dfn","div",
        "dl","dt","em","embed","eventsource","fieldset","figcaption","figure",
        "footer","form","h1","h2","h3","h4","h5","h6","head","header","hgroup",
        "hr","html","i","iframe","img","input","ins","kbd","keygen","label",
        "legend","li","link","mark","map","menu","meta","meter","nav",
        "noscript","object","ol","optgroup","option","output","p","param",
        "pre","progress","q","ruby","rp","rt","s","samp","script","section",
        "select","small","source","span","strong","style","sub","summary",
        "sup","table","tbody","td","textarea","tfoot","th","thead","time",
        "title","tr","track","u","ul","var","video","wbr");
    
    private $singularTags = array("!DOCTYPE", "head", "body", "header", "footer");
    
    private $headTags = array("title", "style", "meta", "link", "script", "noscript", "base");
    
    private $bodyTags = array("a", "p", "hr", "pre", "ul", "ol", "ol", "dl", 
        "div", "h1", "h2", "h3", "h4", "h5", "h6", "hgroup", "address", "blockquote",
        "ins", "del", "object", "map", "noscript", "section", "nav", "article", 
        "aside", "header", "footer", "video", "audio", "figure", "table", 
        "form", "fieldset", "menu", "canvas", "details", "em", "strong", 
        "small", "mark", "abbr", "dfn", "i", "b", "s", "u", "code", "var", 
        "samp", "kbd", "sup", "sub", "q", "cite", "span", "bdo", "bdi", "br", 
        "wbr", "ins", "del", "img", "embed", "object", "iframe", "map", "area", 
        "script", "noscript", "ruby", "video", "audio", "input", "textarea", 
        "select", "button", "label", "output", "datalist", "keygen", "progress",
        "command", "canvas", "time", "meter");
    
    private $globalAttributes = array("accesskey", "class", "contenteditable", 
        "contextmenu", "dir", "draggable", "dropzone", "hidden", "id", "lang", 
        "spellcheck", "style", "tabindex", "title", "translate");
         
    private $node; //the tag to validate
    private $errors; //stores errors associated with this tag (multiple errors are possible)
    
    public function __construct($node) {
        $this->node = $node;
    }
    
    /**
     * 'Manages' the validation, by determining what tests should be run on the node
     */
    public function validate() {
        /* check if tag is valid */
        if (!in_array($this->node->getValue(), $this->validTags)) {
            array_push($this->errors, "Invalid tag");
        }
        
        if (in_array($this->node->getValue(), $this->singularTags)) {
            //call function to validate these tags (Note: checking for multiple 
            // instances of these tags will covered by StructureValidator (to be implemented)
        }
        elseif (in_array($this->node->getValue(), $this->headTags)) {
            $this->validateHeadTag();
        }
        elseif (in_array($this->node->getValue(), $this->bodyTags)) {
            $this->validateBodyTag();
        }
     }
    
    private function validateHeadTag() {
        switch ($this->node->getValue())
        {
            case "title":
                $this->validateTitleTag();
                break;
            case "style":
                $this->validateStyleTag();
                break;
            case "meta":
                $this->validateMetaTag();
                break;
            case "link":
                $this->validateLinkTag();
                break;
            case "script":
                $this->validateScriptTag();
                break;
            case "noscript":
                $this->validateNoScriptTag();
                break;
            case "base":
                $this->validateBaseTag();
                break;
        }
    }
    
    private function validateTitleTag() {
        $f = fopen("testing.txt", "a");
        if (count($this->node->getAttr()) > 0) {
            fwrite($f, "titleTag attr: " . $this->node->getAttr()[0] . "\n");
            fclose($f);
        } else {
        }   
    }
    
    
    private function validateBodyTag() {
        switch ($this->node->getValue())
        {
            case "a":
            case "p":
            case "hr":
            case "pre":
            case "ul":
            case "ol":
            case "ol":
            case "dl":
            case "div":
            case "h1":
            case "h2":
            case "h3":
            case "h4":
            case "h5":
            case "h6":
            case "hgroup":
            case "address":
            case "blockquote":
            case "ins":
            case "del":
            case "object":
            case "map":
            case "noscript":
            case "section":
            case "nav":
            case "article":
            case "aside":
            case "header":
            case "footer":
            case "video":
            case "audio":
            case "figure":
            case "table":
            case "form":
            case "fieldset":
            case "menu":
            case "canvas":
            case "details":
            case "em":
            case "strong":
            case "small":
            case "mark":
            case "abbr":
            case "dfn":
            case "i":
            case "b":
            case "s":
            case "u":
            case "code":
            case "var":
            case "samp":
            case "kbd":
            case "sup":
            case "sub":
            case "q":
            case "cite":
            case "span":
            case "bdo":
            case "bdi":
            case "br":
            case "wbr":
            case "ins":
            case "del":
            case "img":
            case "embed":
            case "object":
            case "iframe":
            case "map":
            case "area":
            case "script":
            case "noscript":
            case "ruby":
            case "video":
            case "audio":
            case "input":
            case "textarea":
            case "select":
            case "button":
            case "label":
            case "output":
            case "datalist":
            case "keygen":
            case "progress":
            case "command":
            case "canvas":
            case "time":
            case "meter":
        }
    }
    
    
    private function validateDoctype($node) {
        
        
    }
    
    
    
    
}

?>
