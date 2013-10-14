<?php

/**
 * Description of TagsList
 *
 * @author matt
 */
class TagsList {
    
    private $tags;
    
    public function __construct() {
        $f = file_get_contents('json/tags.json');
        $this->tags = json_decode($f);
        var_dump($f);
    }
    
    
    
    
}
    
?>
