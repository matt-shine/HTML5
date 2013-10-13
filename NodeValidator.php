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
        $this->node->addErrors($this->errors);
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
                $this->checkCloseTag("<P>");
                break;
            case "hr":
                 $this->checkCloseTag("<hr>");
                break;
            case "pre":
                 $this->checkCloseTag("<pre>");
                break;
            case "ul": // Todo
                break;
            case "ol": // Todo
                break;
            case "ol": // Todo
                break;
            case "dl": // Todo
                break;
            case "div":
                 $this->checkCloseTag("<DIV>");
                break;
            case "h1": // add only 1 h1
                 $this->checkCloseTag("<h1>");
                break;
            case "h2":
                 $this->checkCloseTag("<h2>");
                break;
            case "h3":
                 $this->checkCloseTag("<h3>");
                break;
            case "h4":
                 $this->checkCloseTag("<h4>");
                break;
            case "h5":
                 $this->checkCloseTag("<h5>");
                break;
            case "h6":
                 $this->checkCloseTag("<h6>");
                break;
            case "hgroup":
                $this->checkCloseTag("<hgroup>");
                break;
            case "address":
                 $this->checkCloseTag("<address>");
                break;
            case "blockquote":
                 $this->checkCloseTag("<blockquote>");
                break;
            case "ins":
                 $this->checkCloseTag("<ins>");
                break;
            case "del":
                $this->checkCloseTag("<del>");
                break;
            case "object":
                 $this->checkCloseTag("<object>");
                break;
            case "map":
                $this->checkCloseTag("<map>");
                break;
            case "noscript":
                $this->checkCloseTag("<noscript>");
                break;
            case "section":
                 $this->checkCloseTag("<section>");
                break;
            case "nav":
                 $this->checkCloseTag("<nav>");
                break;
            case "article":
                 $this->checkCloseTag("<article>");
                break;
            case "aside":
                 $this->checkCloseTag("<aside>");
                break;
            case "header":
                 $this->checkCloseTag("<header>");
                break;
            case "footer":
                 $this->checkCloseTag("<footer>");
                break;
            case "video":
                 $this->checkCloseTag("<video>");
                break;
            case "audio":
                 $this->checkCloseTag("<audio>");
                break;
            case "figure":
                 $this->checkCloseTag("<figure>");
                break;
            case "table": // TODO
                break;
            case "form":  // TODO
                break;
            case "fieldset": //TODO
                break;
            case "menu":
                 $this->checkCloseTag("<menu>");
                break;
            case "canvas":
                 $this->checkCloseTag("<canvas>");
                break;
            case "details":
                 $this->checkCloseTag("<detail>");
                break;
            case "em":
                 $this->checkCloseTag("<em>");
                break;
            case "strong":
                 $this->checkCloseTag("<strong>");
                break;
            case "small":
                 $this->checkCloseTag("<small>");
                break;
            case "mark":
                 $this->checkCloseTag("<mark>");
                break;
            case "abbr":
                $this->checkCloseTag("<abbr>");
                break;
            case "dfn":
                 $this->checkCloseTag("<dfn>");
                break;
            case "i":
                 $this->checkCloseTag("<i>");
                break;
            case "b":
                 $this->checkCloseTag("<b>");
                break;
            case "s":
                 $this->checkCloseTag("<s>");
                break;
            case "u":
                 $this->checkCloseTag("<u>");
                break;
            case "code":
                 $this->checkCloseTag("<code>");
                break;
            case "var":
                 $this->checkCloseTag("<var>");
                break;
            case "samp":
                 $this->checkCloseTag("<samp>");
                break;
            case "kbd":
                 $this->checkCloseTag("<kbd>");
                break;
            case "sup":
                 $this->checkCloseTag("<sup>");
                break;
            case "sub":
                 $this->checkCloseTag("<sub>");
                break;
            case "q":
                 $this->checkCloseTag("<q>");
                break;
            case "cite":
                 $this->checkCloseTag("<cite>");
                break;
            case "span":
                 $this->checkCloseTag("<span>");
                break;
            case "bdo":
                 $this->checkCloseTag("<bdo>");
                break;
            case "bdi":
                $this->checkCloseTag("<bdi>");
                break;
            case "br":
                 $this->checkCloseTag("<br>");
                break;
            case "wbr":
                 $this->checkCloseTag("<wbr>");
                break;
            case "ins":
                 $this->checkCloseTag("<ins>");
                break;
            case "del":
                 $this->checkCloseTag("<del>");
                break;
            case "img": // TODO
                break;
            case "embed":
                 $this->checkCloseTag("<embed>");
                break;
// dupicate            case "object":
            case "iframe":
                $this->checkCloseTag("<iframe>");
                break;
// dupicate            case "map":
            case "area":
                 $this->checkCloseTag("<area>");
                break;
            case "script":
                 $this->checkCloseTag("<script>");
                break;
// dupicate            case "noscript":
            case "ruby":
                 $this->checkCloseTag("<ruby>");
                break;
// dupicate            case "video":
// dupicate            case "audio":
            case "input":       // todo form
                break;
            case "textarea":    // todo form
                break;
            case "select":      // todo form
                break;
            case "button":      // todo form
                break;
            case "label":       // todo form
                break;
            case "output":      // todo form
                break;
            case "datalist":
                 $this->checkCloseTag("<datalist>");
                break;
            case "keygen":
                 $this->checkCloseTag("<keygen>");
                break;
            case "progress":
                 $this->checkCloseTag("<progress>");
                break;
            case "command":
                $ $this->checkCloseTag("<command>");
                break;
// dupicate            case "canvas":
            case "time":
                 $this->checkCloseTag("<time>");
                break;
            case "meter":
                 $this->checkCloseTag("<meter>");
                break;
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

                  
	              private function checkCloseTag($tag) {
        if (count($this->node->getAttr()) > 0) {
            $close = $this->node->getCloseTagFound();
                if ($close == false) {
                    array_push($this->errors, "No closing tag was found for". $tag. "tag");
                }
        }
      }
}
?>