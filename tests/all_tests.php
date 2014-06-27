<?php


require_once 'ShowPasses.php';
SimpleTest::prefer(new ShowPasses());
require_once'../simpletest/autorun.php';

class AllTests extends TestSuite {
    function __construct() {
        parent::__construct('All tests');
        $this->TestSuite('All tests for SimpleTest ' . SimpleTest::getVersion());
        $this->addFile('NewParserTest.php');
    }
}
?>

