<?php

/**
 * Description of Error
 *
 * @author matt
 */
class Error {
    //put your code here
    
    private $id;        /* error id (see http://validator.w3.org/docs/errors.html#noverbose) */
    private $message;   /* message given with error */
    private $line;      /* line number where the error occured */
    private $col;       /* column where the error occured */
    private $source;    /* source snippet of error */
    
    public function __construct($id, $message, $line, $col, $source) {
        $this->id = $id;
        $this->message = $message;
        $this->line = $line;
        $this->col = $col;
        $this->source = $source;
    }
    
    public function getId() { return $this->id; }
    public function setId($x) { $this->id = $x; }
    public function getMessage() { return $this->message; }
    public function setMessage($x) { $this->message = $x; }
    public function getLine() { return $this->line; }
    public function setLine($x) { $this->line = $x; }
    public function getCol() { return $this->col; }
    public function setCol($x) { $this->col = $x; }
    public function getSource() { return $this->source; }
    public function setSource($x) { $this->source = $x; }
    
}
