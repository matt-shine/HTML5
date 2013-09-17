<?php

require_once('../simpletest/autorun.php');
include ('../Parser.php');

/**
 * Tests the Parser.php class 
 *
 * @author matt
 */
class ParserTest extends UnitTestCase {
    
    /**
     * Check instantiating Parser with valid filepath
     * results in an instance of Parser.
     */
    function testConstructorWithValidFilePath() {
        $parser = new Parser('files/test.html');
        $this->assertTrue(is_a($parser, "Parser"));
    }
    
    /**
     * Test that exception is thrown when instantiating
     * Parser with invalid filepath.
     */
    function testConstructorWithInvalidFilePath() {
        $this->expectException();
        $parser = new Parser('invalid.html');
        $this->assertFalse(is_a($parser, "Parser"));
    }
    
    /**
     * Check exception is thrown when instantiating Parser
     * with empty file.
     */
    function testConstructorWithEmptyFile() {
        $this->expectException();
        $parser = new Parser('files/empty.html');
        $this->assertFalse(is_a($parser, "Parser"));
    }
    
    /**
     * Check that the constructor correclty initializes the
     * lines, errors, and tags arrays.
     */
    function testConstructorArrays() {
        $parser = new Parser('files/test.html');
        $this->assertEqual(count($parser->lines), 14);
        $this->assertEqual($parser->numlines, 14);
        $this->assertIsA($parser->errors, "array");
        $this->assertEqual(count($parser->errors), 0);
        $this->assertIsA($parser->tags, "array");
        $this->assertEqual(count($parser->tags), 0);
    }
    
    /**
     * Check the constructor correctly initializes a new JTree
     * instance for the $tree variable.
     */
    function testConstructorTree() {
        $parser = new Parser('files/test.html');
        $this->assertIsA($parser->tree, "JTree");
        $this->assertTrue(count($parser->tree->getTree()), 0);
    }
    
    /**
     * Tests that when given a file with valid html, the parse() function
     * correctly extracts the html tags.
     */
    function testParseValidFile() {
        $parser = new Parser('files/test.html');
        $this->assertEqual(count($parser->tags), 0);
        $parser->parse();
        $this->assertEqual(count($parser->tags), 18);
        $this->assertEqual($parser->tags[0]->getValue(), "!DOCTYPE");
        $this->assertEqual($parser->tags[5]->getValue(), "/head");
        $this->assertEqual($parser->tags[5]->getLine(), 4);
        $this->assertEqual($parser->tags[5]->getInd(), 4);
    }
    
    /**
     * Checks that a html file with a tag that extends over multiple lines
     *  is parsed as expected.
     */
    function testParseWithMultiLineTag() {
        $parser = new Parser('files/testMultiLineTag.html');
        $parser->parse();
        $this->assertEqual(count($parser->tags), 11);
    }
    
    /**
     * Check the createParseTree() creates a valid tree from
     * from the array of tags when given a valid html file.
     */
    function testCreateParseTree() {
        $parser = new Parser('files/testValid.html');
        $parser->parse();
        $parser->createParseTree();
        $this->assertEqual($parser->tree->getHeadNode()->getValue(), "HEAD");
        $firstChildren = $parser->tree->getChildren($parser->tree->getHeadNode()->getUid());
        $this->assertTrue(sizeof($firstChildren) == 2);
        $this->assertTrue($parser->tree->getValue($firstChildren[0]) == "!DOCTYPE");
        $this->assertEqual($parser->tree->getChildren($firstChildren[0]), null);
        $this->assertTrue($parser->tree->getValue($firstChildren[1]) == "html");
    }
    
    /**
     * Check the createParseTree() creates a valid tree structure
     * despite given a html document containing errors.
     */
    function testCreateParseTreeInvalid(){
        $parser = new Parser('files/test.html');
        $parser->parse();
        $parser->createParseTree();
        $this->assertEqual($parser->tree->getHeadNode()->getValue(), "HEAD");
        $firstChildren = $parser->tree->getChildren($parser->tree->getHeadNode()->getUid());
        $this->assertTrue(sizeof($firstChildren) == 2);
        $this->assertTrue($parser->tree->getValue($firstChildren[0]) == "!DOCTYPE");
        $this->assertEqual($parser->tree->getChildren($firstChildren[0]), null);
        $this->assertTrue($parser->tree->getValue($firstChildren[1]) == "html");
    }
    
}

?>
