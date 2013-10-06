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
    
    private $firstLevel = array("!DOCTYPE","head","body");
    
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
    private $tree;
    private $first;
    
    public function __construct($node, $tree, $first = false) {
        $this->node = $node;
        $this->errors = array();
        $this->tree = $tree;
        if ($first) {
            $this->first = true;
        } else {
            $this->first = false;
        }
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * 'Manages' the validation, by determining what tests should be run on the node
     */
    public function validate() {
        
        
        /* Check if the node is a first level node */
        if (in_array($this->node->getUid(), $this->tree->getChildren($this->tree->getHeadNode()->getUid()))) {
            $this->validateFirstLevelNode();
        }
        
        /* check if tag is valid */
        if (!in_array($this->node->getValue(), $this->validTags)) {
            array_push($this->errors, "Invalid tag");
        }
    
        if (in_array($this->node->getValue(), $this->headTags)) {
            
            $this->validateHeadTag();
        }
        if (in_array($this->node->getValue(), $this->bodyTags)) {
            $this->validateBodyTag();
        }
        foreach ($this->errors as $err) {
            $this->node->addError($err);
        }
     }
     
     
     private function validateFirstLevelNode() {
         if (!in_array($this->node->getValue(), $this->firstLevel)) {
             /* Non-First level node in first-level position.
              *     First level nodes - <!DOCTYPE>, <head>, <body>
              *     Non: e.g <p><b>... etc.
              */
             
             //TODO: function to deal with this
         }
         
         if ($this->first) {
             $this->validateDoctype();
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
    
    
      private function validateBodyTag() {
        switch ($this->node->getValue())
        {
            case "a":
            case "p":
                $this->validatePTag();
                break;
            case "hr":
                $this->validateX($hr, $hr2, "hr");
                break;
            case "pre":
                $this->validateX($pre, $pre2, "pre");
                break;
            case "ul": // Todo
            case "ol": // Todo
            case "ol": // Todo
            case "dl": // Todo
            case "div":
                $this->validateX($div, $div2, "div");
                break;
            case "h1": // add only 1 h1
                $this->validateX($h1, $hr12, "h1");
                break;
            case "h2":
                $this->validateX($h2, $hr22, "h2");
                break;
            case "h3":
                $this->validateX($h3, $hr32, "h3");
                break;
            case "h4":
                $this->validateX($h4, $hr42, "h4");
                break;
            case "h5":
                $this->validateX($h5, $hr52, "h5");
                break;
            case "h6":
                $this->validateX($h6, $hr62, "h6");
                break;
            case "hgroup":
                $this->validateX($hgroup, $hgroup2, "hgroup");
                break;
            case "address":
                $this->validateX($address, $address2, "address");
                break;
            case "blockquote":
                $this->validateX($blockquote, $blockquote2, "blockquote");
                break;
            case "ins":
                $this->validateX($ins, $ins2, "ins");
                break;
            case "del":
                $this->validateX($del, $del2, "del");
                break;
            case "object":
                $this->validateX($object, $object2, "object");
                break;
            case "map":
                $this->validateX($map, $map2, "map");
                break;
            case "noscript":
                $this->validateX($noscript, $noscript2, "noscript");
                break;
            case "section":
                $this->validateX($section, $section2, "section");
                break;
            case "nav":
                $this->validateX($nav, $nav2, "nav");
                break;
            case "article":
                $this->validateX($article, $article2, "article");
                break;
            case "aside":
                $this->validateX($aside, $aside2, "aside");
                break;
            case "header":
                $this->validateX($header, $herder2, "header");
                break;
            case "footer":
                $this->validateX($footer, $footer2, "footer");
                break;
            case "video":
                $this->validateX($video, $video2, "video");
                break;
            case "audio":
                $this->validateX($audio, $audio2, "audio");
                break;
            case "figure":
                $this->validateX($figure, $figure2, "figure");
                break;
            case "table": // TODO
            case "form":  // TODO
            case "fieldset": //TODO
            case "menu":
                $this->validateX($menu, $menu2, "menu");
                break;
            case "canvas":
                $this->validateX($canvas, $canvas2, "canvas");
                break;
            case "details":
                $this->validateX($detail, $detail2, "detail");
                break;
            case "em":
                $this->validateX($em, $em2, "em");
                break;
            case "strong":
                $this->validateX($strong, $strong2, "strong");
                break;
            case "small":
                $this->validateX($small, $small2, "small");
                break;
            case "mark":
                $this->validateX($mark, $mark2, "mark");
                break;
            case "abbr":
                $this->validateX($abbr, $abbr2, "abbr");
                break;
            case "dfn":
                $this->validateX($dfn, $dfn2, "dfn");
                break;
            case "i":
                $this->validateX($i, $i2, "i");
                break;
            case "b":
                $this->validateX($b, $b2, "b");
                break;
            case "s":
                $this->validateX($s, $s2, "s");
                break;
            case "u":
                $this->validateX($u, $u2, "u");
                break;
            case "code":
                $this->validateX($code, $code2, "code");
                break;
            case "var":
                $this->validateX($var, $var2, "var");
                break;
            case "samp":
                $this->validateX($samp, $samp2, "samp");
                break;
            case "kbd":
                $this->validateX($kbd, $kbd2, "kbd");
                break;
            case "sup":
                $this->validateX($sup, $sup2, "sup");
                break;
            case "sub":
                $this->validateX($sub, $sub2, "sub");
                break;
            case "q":
                $this->validateX($q, $q2, "q");
                break;
            case "cite":
                $this->validateX($cite, $cite2, "cite");
                break;
            case "span":
                $this->validateX($span, $span2, "span");
                break;
            case "bdo":
                $this->validateX($bdo, $bdo2, "bdo");
                break;
            case "bdi":
                $this->validateX($bdi, $bdi2, "bdi");
                break;
            case "br":
                $this->validateX($br, $br2, "br2");
                break;
            case "wbr":
                $this->validateX($wbr, $wbr2, "wbr");
                break;
            case "ins":
                $this->validateX($ins, $ins2, "ins");
                break;
            case "del":
                $this->validateX($del, $del2, "del");
                break;
            case "img": // TODO
            case "embed":
                $this->validateX($embed, $embed2, "embed");
                break;
// dupicate            case "object":
            case "iframe":
                $this->validateX($iframe, $iframe2, "iframe");
                break;
// dupicate            case "map":
            case "area":
                $this->validateX($area, $area2, "area");
                break;
            case "script":
                $this->validateX($script, $script2, "script");
                break;
// dupicate            case "noscript":
            case "ruby":
                $this->validateX($ruby, $ruby2, "ruby");
                break;
// dupicate            case "video":
// dupicate            case "audio":
            case "input":       // todo form
            case "textarea":    // todo form
            case "select":      // todo form
            case "button":      // todo form
            case "label":       // todo form
            case "output":      // todo form
            case "datalist":
                $this->validateX($datalist, $datalist2, "datalist");
                break;
            case "keygen":
                $this->validateX($keygen, $keygen2, "keygen");
                break;
            case "progress":
                $this->validateX($progess, $progess2, "progess");
                break;
            case "command":
                $this->validateX($command, $command2, "command");
                break;
// dupicate            case "canvas":
            case "time":
                $this->validateX($time, $time2, "time");
                break;
            case "meter":
                $this->validateX($meter, $meter2, "meter");
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
<<<<<<< HEAD
    }
=======
    
     
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
>>>>>>> origin/A-team

                  private function validateX($A,$B,$C) {
        if (count($this->node->getAttr()) > 0) {
            $A = $this->node->getAttr();
            foreach ($A as $B) {
                if (!in_array($B, $this->bodyTags)) {
                    array_push($this->errors, "Invalid $C Tag Attribute: " . $B);
                }
            }
        }
      }
}
?>
