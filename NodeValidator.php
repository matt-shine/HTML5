<?php
include_once 'TagsList.php';
include_once 'TagInfo.php';
include_once 'AttributeList.php';
include_once 'AttributeInfo.php';

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
    private $warnings; //stores warnings associated with this tag
    private $tagList;
    private $attributeList;
    private $tagInfo;
    
    
    public function __construct($node) {
        $this->node = $node;
        $this->errors = array();
        $this->warnings = array();
        $this->tagList = new TagsList();
        $this->tagInfo = $this->tagList->getTagInfo($this->node->getValue());
        $this->attributeList = new AttributeList();
    }
    
    /**
     * 'Manages' the validation, by determining what tests should be run on the node
     */
    public function validate() {
        /* Make sure we're dealing with a valid tag */
        $tagValue = $this->node->getValue();
        if ($this->tagInfo === false) {
            array_push($this->errors, "Invalid Tag [$tagValue]. Suggestions: <br/> ". $this->getMisspelledSuggestion($tagValue, $this->validTags));
            $this->node->addErrors($this->errors);
            return;
        }
        
        /* Check if tag is deprecated */
        if ($this->tagInfo->isTagDeprecated()) {
            /* Deprecated Tag: Add the warning and skip further validation */
            array_push($this->warnings, "Deprecated Tag \"&lt$tagValue&gt\": " .  $this->tagInfo->getDescription());
            $this->node->addWarnings($this->warnings);
            return;
        }
        
        /* Check if this tag has required attributes */
        if (count($this->tagInfo->getRequiredAttributes() > 0)) {
            $this->validateRequiredAttributes();
        }
        
        /* Check if the tag has attributes set, if so, validate them */
        foreach ($this->node->getAttr() as $att => $val) {
            if (!$this->validateRequiredAttributeValue($att)) {
                array_push($this->errors, $this->node->getValue() . ' Attribute ' . $att . " has an invalid value. Should be one of the following: "  . implode(",", $this->attributeList->getAttributeInfo($att)). "<br />");
            }
        }
          
        
        $this->node->addErrors($this->errors);
        $this->node->addWarnings($this->warnings);
        
     }
     
    public function validateRequiredAttributes() {
        $tagValue = $this->node->getValue();
        /* Get the list of attributes for this node */
        $nodesAttributes = $this->node->getAttr();

        foreach ($this->tagInfo->getRequiredAttributes() as $att => $val) {
            if (!array_key_exists($val, $nodesAttributes)) {
                /* Not found */
                array_push($this->errors, $tagValue . " tag is missing a required attribute [$val]<br />");
            }
            //If the required attribute is present, it's value will be verified by the next
                //call in validate()
        }
    }
     
     public function validateRequiredAttributeValue($att) {
        $info = $this->attributeList->getAttributeInfo($att);
        if ($info != false) {
            /* There are required values for this attribute */
            if (!in_array($att, $info->getValues())) {
                return false;
            }
        }
        return true;
     }
     
    
   
    
    public function getMisspelledSuggestion($string, $possibilities) {
        $queue = new SplPriorityQueue();
        $sl = strlen($string); //length of the provided string
        foreach ($possibilities as $p) {
            $pl = strlen($p); //length of the possiblity
            /* We only want to consider possiblities near to the provided strings length */
            if ($pl > $sl/2 && $pl < $sl + $sl/2) { 
                $lev = 999999999-levenshtein($string, $p);
                $queue->insert($p, $lev);
            }
        }
 
        /* Generate at most 3 suggestions */
        if ($queue->count() < 3) {
            return $queue->extract();
        } else {
            $retString = "";
            $i = 3;
            while ($i > 0) {
                $retString = $retString . "    " .$queue->extract() . "<br />";
                $i--;
            }
        }
        return $retString;
    }
    
}
?>