<?php

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
        $this->errors = array();
    }
    
    public function getErrors() {
        return $this->errors;
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
        $f = fopen("testing.txt", "a");
        foreach ($this->errors as $err) {
            fwrite($f, $err . ": " . $this->node->getValue() . "\n");
        }
        fclose($f);
     }
    
    private function validateHeadTag() {
        switch ($this->node->getValue())
        {   
            case "!DOCTYPE":
                $this->validateDoctype();
                break;
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
    
      private function validateBodyTag() {
        switch ($this->node->getValue())
        {
            case "a":
            case "p":
                $this->validatePTag();
                break;
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
    
    
    private function validateDoctype() {
        if (count($this->node->getAttr()) < 1)  {
            array_push($this->errors, "Doctype is missing required specification.");
        }
        if (count($this->node->getAttr()) > 1) {
            array_push($this->errors, "Doctype must have only one attribute.");
        }
        if (count($this->node->getAttr()) == 1) {
            $attr = $this->node->getAttr();
            if ($attr[0] != "html") {
                array_push($this->errors, "Declared Doctype is not HTML5.");
        }
    }
    }
    
      private function validateTitleTag() {
        if (count($this->node->getAttr()) > 0) {
            $att = $this->node->getAttr();
            foreach ($att as $at) {
                if (!in_array($at, $this->globalAttributes)) {
                    array_push($this->errors, "Invalid Title Tag Attribute: " . $at);
                }
                
            }
           
        } 
      }
      private function validateMetaTag() 
      {
          if(count($this->node->getAttr()) > 0) {
              if(!in_array("name",$this->node->getAttr())){
                  array_push($this->errors, "Meta Tag requires a name attribute");
              }
              
          }
          else{
              array_push($this->errors, "Meta Tag requires a name attribute");
          }
           
      }
    
     
    private function validateLinkTag()
    {
        if (count($this->node->getAttr()) > 0) {
            $attlink = $this->node->getAttr();
            foreach ($attlink as $atlink) {
                if (!in_array($atlink, $this->headTags)) {
                    array_push($this->errors, "Invalid Link Tag Attribute: " . $atlink);
                }
            }
           
        } 
      }
        private function validateStyleTag() {
        if (count($this->node->getAttr()) > 0) {
            $attstyle = $this->node->getAttr();
            foreach ($attstyle as $atstyle) {
                if (!in_array($atstyle, $this->headTags)) {
                    array_push($this->errors, "Invalid Style Tag Attribute: " . $atstyle);
                }
            }
           
        } 
      }  
    
      private function validateScriptTag() {
        if (count($this->node->getAttr()) > 0) {
            $attscript = $this->node->getAttr();
            foreach ($attscript as $atscript) {
                if (!in_array($atscript, $this->headTags)) {
                    array_push($this->errors, "Invalid Script Tag Attribute: " . $atscript);
                }
            }
           
        } 
      }

            private function validateNoScriptTag() {
        if (count($this->node->getAttr()) > 0) {
            $attnoscript = $this->node->getAttr();
            foreach ($attnoscript as $atnoscript) {
                if (!in_array($atnoscript, $this->headTags)) {
                    array_push($this->errors, "Invalid No Script Attribute: " . $atnoscript);
                }
            }
           
        } 
      }
 
            private function validateBaseTag() {
        if (count($this->node->getAttr()) > 0) {
            $attbase = $this->node->getAttr();
            foreach ($attbase as $atbase) {
                if (!in_array($atbase, $this->headTags)) {
                    array_push($this->errors, "Invalid Base Tag Attribute: " . $atbase);
                }
            }
        
        } 
      }
  /* Capturing tags for body tags*/
      
            private function validatePTag() {
        if (count($this->node->getAttr()) > 0) {
            $attp = $this->node->getAttr();
            foreach ($attp as $atp) {
                if (!in_array($atp, $this->bodyTags)) {
                    array_push($this->errors, "Invalid P Tag Attribute: " . $atp);
                }
            }
        } 
      }
}
?>
