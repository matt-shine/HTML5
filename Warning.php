<?php

/**
 * Description of Error
 *
 * @author matt
 */
class Warning {
    //put your code here
    
    private $id;        /* warning id (see http://validator.w3.org/docs/errors.html#noverbose) */
    private $message;   /* message given with warning */
    private $line;      /* line number where the warning occured */
    private $col;       /* column where the warning occured */
    private $source;    /* source snippet of warning */
    
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