<?php



/**
 * Description of PTreeRecursiveIterator
 *
 * @author matt
 */
class PTreeRecursiveIterator extends RecursiveIteratorIterator {
    /**
   * @var _jTree the JTree object 
   */
    private $_pTree;
   /**
   * @var _str string with ul/li string 
   */
    private $_str;
 
    /**
     * PTreeRecursiveIterator::__construct()
     * 
     * @param mixed $jt - the tree object
     * @param mixed $iterator - the tree iterator
     * @param mixed $mode 
     * @param integer $flags
     * @return
     */
    public function __construct(PTree $pt, $iterator, $mode = LEAVES_ONLY, $flags = 0) {
 
        parent::__construct($iterator, $mode, $flags);
        $this->_pTree = $pt;
        $this->_str = "<ul>\n";
    }
 
    /**
     * JTreeRecursiveIterator::endChildren()
     * Called when end recursing one level.(See manual) 
     * @return void
     */
    public function endChildren() {
        parent::endChildren();
        $this->_str .= "</ul></li>\n";
    }
 
    /**
     * JTreeRecursiveIterator::callHasChildren()
     * Called for each element to test whether it has children. (See Manual)
    * 
     * @return mixed
     */
    public function callHasChildren() {
        $ret = parent::callHasChildren();
        $value = $this->current()->getValue();
 
        if($ret === true) {
            $this->_str .= "<li>{$value}<ul>\n";
        } else {
            $this->_str .= "<li>{$value}</li>\n";
        }
        return $ret;
    }
 
    /**
     * JTreeRecursiveIterator::__destruct()
     * On destruction end the list and display.
     * @return void
     */
    public function __destruct() {
        $this->_str .= "</ul>\n";
                echo $this->_str;
    }
}

?>
