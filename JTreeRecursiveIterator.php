<?php

/**
 * JTreeRecursiveIterator
 * 
 * To use a recursive iterator you have to extend of the RecursiveIteratorIterator
 * As an example I have built an unordered list 
 * For detailed information on please see RecursiveIteratorIterator
 * http://us.php.net/manual/en/class.recursiveiteratoriterator.php
 * 
 * @package   JTree
 * @author Jayesh Wadhwani 
 * @copyright Jayesh Wadhwani
 * @license  GNU GENERAL PUBLIC LICENSE 3.0
 * @version 1.0 2011
 */
class JTreeRecursiveIterator extends RecursiveIteratorIterator {
   /**
   * @var _jTree the JTree object 
   */
    private $_jTree;
   /**
   * @var _str string with ul/li string 
   */
    private $_str;
 
    /**
     * JTreeRecursiveIterator::__construct()
     * 
     * @param mixed $jt - the tree object
     * @param mixed $iterator - the tree iterator
     * @param mixed $mode 
     * @param integer $flags
     * @return
     */
    public function __construct(JTree $jt, $iterator, $mode = LEAVES_ONLY, $flags = 0) {
 
        parent::__construct($iterator, $mode, $flags);
        $this->_jTree = $jt;
        $this->_str = "******<br />";
    }
 
    /**
     * JTreeRecursiveIterator::endChildren()
     * Called when end recursing one level.(See manual) 
     * @return void
     */
    public function endChildren() {
        parent::endChildren();
        $this->_str .= "******<br />";
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
            $this->_str .= "*{$value}<br />";
        } else {
            $this->_str .= "*{$value}<br />";
        }
        return $ret;
    }
 
    /**
     * JTreeRecursiveIterator::__destruct()
     * On destruction end the list and display.
     * @return void
     */
    public function __destruct() {
        $this->_str .= "******<br />";
                echo $this->_str;
    }
 
}

?>
