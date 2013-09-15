<?php

require_once('../simpletest/autorun.php');
include ('../Parser.php');

/**
 * Tests the Parser.php class 
 *
 * @author matt
 */
class ParserTest extends UnitTestCase {
    
    function testConstructorWithValidFilePath() {
        $parser = new Parser('files/test.html');
        $this->assertTrue(is_a($parser, "Parser"));
    }
    
    function testConstructorWithInvalidFilePath() {
        $this->expectException();
        $parser = new Parser('invalid.html');
        $this->assertFalse(is_a($parser, "Parser"));
    }
    
    function testConstructorWithEmptyFile() {
        $this->expectException();
        $parser = new Parser('files/empty.html');
        $this->assertFalse(is_a($parser, "Parser"));
    }
    
    function testConstructorArrays() {
        $parser = new Parser('files/test.html');
        $this->assertEqual(count($parser->lines), 14);
        $this->assertEqual($parser->numlines, 14);
        $this->assertIsA($parser->errors, "array");
        $this->assertEqual(count($parser->errors), 0);
        $this->assertIsA($parser->tags, "array");
        $this->assertEqual(count($parser->tags), 0);
    }
    
    function testConstructorTree() {
        $parser = new Parser('files/test.html');
        $this->assertIsA($parser->tree, "JTree");
        $this->assertTrue(count($parser->tree->getTree()), 0);
    }
    
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
    
    function testParseWithMultiLineTag() {
        $parser = new Parser('files/testMultiLineTag.html');
        $parser->parse();
        $this->assertEqual(count($parser->tags), 11);
    }
    
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
    
}

?>
