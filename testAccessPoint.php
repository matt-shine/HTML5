<?php

include_once 'Parser.php';

$p = new Parser("test.html");
$p->parse();
$p->createParseTree();

?>
