<?php

require '../JNode.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-06-29 at 16:09:27.
 */
class JNodeTest extends PHPUnit_Framework_TestCase {

    /**
     * @var JNode
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers JNode::setCloseTagFound
     */
    public function testGetCloseTagFoundTrue() {
        $node = new JNode('test',1,1);
        $node->setCloseTagFound();
        $this->assertTrue($node->getCloseTagFound());
    }

    /**
     * @covers JNode::getCloseTagFound
     */
    public function testGetCloseTagFoundFalse() {
        $node = new JNode('test',1,1);
        $this->assertFalse($node->getCloseTagFound());
    }

    /**
     * @covers JNode::setCloseTagLn
     */
    public function testSetCloseTagLn() {
        $node = new JNode('test',1,1);
        $node->setCloseTagFound();
        $this->assertTrue($node->getCloseTagFound());
    }

    /**
     * @covers JNode::getCloseTagLn
     */
    public function testGetCloseTagLn() {
        $node = new JNode('test',1,1);
        $this->assertFalse($node->getCloseTagFound());
    }   
    
    /**
     * @covers JNode::setCloseTagInd
     */
    public function testSetCloseTagInd() {
        $node = new JNode('test',1,1);
        $node->setCloseTagInd(1);
        $this->assertEquals(1,$node->getCloseTagInd(), 'Close tag index didnt match.');
    }

    /**
     * @covers JNode::getCloseTagInd
     */
    public function testGetCloseTagInd() {
        $node = new JNode('test',1,1);
        $this->assertEquals(null,$node->getCloseTagInd(),'Close tag index was incorrect.');
    }

    /**
     * @covers JNode::getErrors
     * @covers JNode::addErrors
     */
    public function testGetErrors() {
        $node = new JNode('test',1,1);
        $errors = ['1'];
        $node->addErrors($errors);
        $this->assertEquals($errors,$node->getErrors(), 'Error arrays didnt match.');
    }

    /**
     * @covers JNode::getErrors
     */
    public function testGetErrorsNull() {
        $node = new JNode('test',1,1);
        $this->assertEquals(0,count($node->getErrors()), 'Error count didnt match.');
    }
    
    /**
     * @covers JNode::getWarnings
     * @covers JNode::addWarnings
     */
    public function testGetWarnings() {
        $node = new JNode('test',1,1);
        $warnings = ['1'];
        $node->addWarnings($warnings);
        $this->assertEquals($warnings,$node->getWarnings());
    }

    /**
     * @covers JNode::getWarnings
     */
    public function testGetWarningsNull() {
        $node = new JNode('test',1,1);
        $this->assertEquals(0,count($node->getErrors()), 'Warning arrays didnt match.');
    }

    /**
     * @covers JNode::setUid
     * @covers JNode::getUid
     */
    public function testSetUid() {
        $node = new JNode('test',1,1);
        $node->setUid(123);
        $this->assertEquals(123,$node->getUid(), 'UID\'s didn\'t match.');
    }
    
     /**
     * @covers JNode::getUid
     */
    public function testGetUid() {
        $node = new JNode('test',1,1);
        $this->assertNotNull($node->getUid(), 'UID wasn\'t null.');
    }

    /**
     * @covers JNode::getAttr
     */
    public function testGetAttrCon() {
        $attributes = array();
        $att = 'href';
        $val = 'testing';
        $attributes[$att] = $val;
        $node = new JNode('test',1,1,$attributes);
        $this->assertEquals($attributes, $node->getAttr(), 'Attribute arrays were not equal.');
    }

   
    /**
     * @covers JNode::addAttr
     * @todo   Implement testAddAttr().
     */
    public function testAddAttr() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::setValue
     * @todo   Implement testSetValue().
     */
    public function testSetValue() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::getValue
     * @todo   Implement testGetValue().
     */
    public function testGetValue() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::setLn
     * @todo   Implement testSetLn().
     */
    public function testSetLn() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::getLn
     * @todo   Implement testGetLn().
     */
    public function testGetLn() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::setInd
     * @todo   Implement testSetInd().
     */
    public function testSetInd() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::getInd
     * @todo   Implement testGetInd().
     */
    public function testGetInd() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::getParent
     * @todo   Implement testGetParent().
     */
    public function testGetParent() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::setParent
     * @todo   Implement testSetParent().
     */
    public function testSetParent() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::getChildren
     * @todo   Implement testGetChildren().
     */
    public function testGetChildren() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::setChild
     * @todo   Implement testSetChild().
     */
    public function testSetChild() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::anyChildren
     * @todo   Implement testAnyChildren().
     */
    public function testAnyChildren() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JNode::childrenCount
     * @todo   Implement testChildrenCount().
     */
    public function testChildrenCount() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}