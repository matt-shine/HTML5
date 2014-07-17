<?php

require_once 'TagInfo.php';

/**
 * Description of TagsList
 *
 * @author matt
 */
class TagsList {
    
    private $tags;
    /**
     * Returns the *Singleton* instance of this class.
     *
     * @staticvar Singleton $instance The *Singleton* instances of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        $f = file_get_contents('json/tags.json');
        $tags = json_decode($f);
        $this->tags = array();
        foreach ($tags as $tag) {
            array_push($this->tags, new TagInfo($tag->tag, $tag->allowglobals, $tag->requiredattributes, $tag->eventattributes, $tag->isdeprecated, $tag->optionalattributes, $tag->deprecatedattributes, $tag->description, $tag->within, $tag->closingtag, $tag->selfclose));
        }
    }
    
    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
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
