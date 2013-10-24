<?php

include_once 'TagInfo.php';

/**
 * Description of TagsList
 *
 * @author matt
 */
class TagsList {
    
    private $tags;
    
   public function __construct() {
        $f = file_get_contents('json/tags.json');
        $tags = json_decode($f);
        $this->tags = array();
        foreach ($tags as $tag) {
            array_push($this->tags, new TagInfo($tag->tag, $tag->allowglobals, $tag->requiredattributes, $tag->eventattributes, $tag->isdeprecated, $tag->optionalattributes, $tag->deprecatedattributes, $tag->description, $tag->within, $tag->closingtag, $tag->selfclose));
        }
    }
    
    /**
     * Return the TagInfo class for the given tag, false if
     * tag doesn't exist.
     * 
     * @param type $tagName
     * @return mixed
     */
    public function getTagInfo($tagName) {
        foreach ($this->tags as $tag) {
            if ($tag->getName() === $tagName) {
                return $tag;
            }
        }
        return false;
    }
  
}
    
?>
