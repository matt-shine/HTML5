<?php

require_once '../JNode.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-06-29 at 16:09:27.
 */
class JNodeTest extends PHPUnit_Framework_TestCase {

    /**
     * @covers JNode::__construct
     * @expectedException Exception
     */
    public function testConstructWithoutValue() {
        $node = new JNode(null,1,1);
    }
    
    /**
     * @covers JNode::__construct
     */
    public function testConstructorFunctionCalls() {
        $classname = 'JNode';
        $mock = $this->getMockBuilder($classname)
            ->disableOriginalConstructor()
            ->getMock();
        
        // set expectations for constructor calls
        $mock->expects($this->once())
          ->method('setValue')
          ->with(
                  $this->equalTo('test')
                );
        
        $mock->expects($this->once())
                ->method('setUid')
                ->with(
                        $this->equalTo(null)
                    );
        
        $mock->expects($this->once())
                ->method('setln')
                ->with(
                        $this->equalTo(1)
                    );
        
        $mock->expects($this->once())
                ->method('setInd')
                ->with(
                        $this->equalTo(2)
                    );
        
        // now call the constructor
      $reflectedClass = new ReflectionClass($classname);
      $constructor = $reflectedClass->getConstructor();
      $constructor->invoke($mock, 'test',1,2);
    }
    
    /**
     * @covers JNode::__construct
     */
    public function testConstrcutorWithAttributes() {
        $attributes = array();
        $attributes['testAtt'] = 'value';
        $node = new JNode('test',1,1,$attributes,null,null);
        $this->assertEquals($attributes, $node->getAttr());
    }
    
    /**
     * @covers JNode::__construct
     * @covers JNode::isSelfClosed
     */
    public function testConstructorSelfClosing() {
        $node = new JNode('test',1,1,null,null,true);
        $this->assertTrue($node->isSelfClosed());
    }
    
    /**
     * @covers JNode::__construct
     * @covers JNode::isSelfClosed
     */
    public function testConstructorNotSelfClosed() {
        $node = new JNode('test',1,1);
        $this->assertFalse($node->isSelfClosed());
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
     * @covers JNode::getCloseTagLn
     */
    public function testSetCloseTagLn() {
        $node = new JNode('test',1,1);
        $node->setCloseTagLn(2);
        $this->assertEquals(2, $node->getCloseTagLn());
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
     * @covers JNode::setValue
     * @covers JNode::getValue
     * 
     */
    public function testSetValue() {
        $node = new JNode('foo',1,1);
        $node->setValue('bar');
        $this->assertEquals('bar',$node->getValue(), 'JNodes value was incorrect. ');
    }

    /**
     * @covers JNode::setLn
     * @covers JNode::getLn
     */
    public function testSetLn() {
        $node = new JNode('test',1,1);
        $node->setLn(3);
        $this->assertEquals(3,$node->getLn(), 'Line Number was not as expected. ');
    }

    /**
     * @covers JNode::setInd
     * @covers JNode::getInd
     */
    public function testSetInd() {
        $node = new JNode('test',1,1);
        $node->setInd(3);
        $this->assertEquals(3,$node->getInd(), 'JNodes index was not as expected. ');
    }

    /**
     * @covers JNode::getParent
     * @covers JNode::setParent
     */
    public function testGetParent() {
        $child = new JNode('child',1,1);
        $parent = new JNode('parent',2,2);
        $child->setParent($parent->getUid());
        $this->assertEquals($parent->getUid(), $child->getParent());
    }

    /**
     * @covers JNode::getChildren
     * @covers JNode::setChild
     */
    public function testGetChildren() {
        $child = new JNode('child',1,1);
        $parent = new JNode('parent',2,2);
        $parent->setChild($child->getUid());
        $this->assertTrue(in_array($child->getUid(), $parent->getChildren()));
    }

    /**
     * @covers JNode::anyChildren
     */
    public function testAnyChildrenTrue() {
        $node = new JNode('test',1,1);
        $child = new JNode('test2',2,2);
        $node->setChild($child->getUid());
        $this->assertTrue($node->anyChildren());
    }

    /**
     * @covers JNode::anyChildren
     */
    public function testAnyChildrenFalse() {
        $node = new JNode('test',1,1);
        $this->assertFalse($node->anyChildren());
    }
    
    /**
     * @covers JNode::childrenCount
     */
    public function testChildrenCountFalse() {
        $node = new JNode('test',1,1);
        $this->assertEquals(0, $node->childrenCount(), 'Children count was incorrect. ');
    }
    
        /**
     * @covers JNode::childrenCount
     */
    public function testChildrenCountTrue() {
        $node = new JNode('test',1,1);
        $child = new JNode('test2',2,2);
        $node->setChild($child->getUid());
        $this->assertEquals(1, $node->childrenCount(), 'Children count was incorrect. ');
    }

}
