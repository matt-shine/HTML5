<?php

require_once '../JTree.php';
require_once '../JNode.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-06-30 at 12:16:23.
 */
class JTreeTest extends PHPUnit_Framework_TestCase {

    /**
     * @covers JTree::getTree
     */
    public function testGetTree() {
        $tree = new JTree();
        $this->assertTrue(count($tree->getTree()) == 1);
    }

    /**
     * @covers JTree::getNode
     * @expectedException Exception
     */
    public function testGetNodeNullArg() {
        $tree = new JTree();
        $tree->getNode();
    }
    
    /**
     * @covers JTree::getNode
     */
    public function testGetNodeInvalidUid() {
        $tree = new JTree();
        $this->assertFalse($tree->getNode('lalala'));
    }
    
    /**
     * @covers JTree::getNode
     */
    public function testGetNodeValidUid() {
        $tree = new JTree();
        $newNode = new JNode('test',1,1);
        $uid = $newNode->getUid();
        $tree->addFirst($uid);
        $this->assertEquals($uid, $tree->getHeadNode()->getChildren()[0]);
    }
    
    /**
     * @covers JTree::getHeadNode
     */
    public function testGetHeadNode() {
        $tree = new JTree();
        $head = $tree->getHeadNode();
        $this->assertEquals('HEAD',$head->getValue());
    }

    /**
     * @covers JTree::setChild
     * @expectedException Exception
     */
    public function testSetChild() {
        $tree = new JTree();
        $tree->setChild('','');
    }
    
    /**
     * @covers JTree::setChild
     */
    public function testSetChildMissingNode() {
        $tree = new JTree();
        $parent = new JNode('parent',1,1);
        $node = new JNode('child',1,1);
        $tree->addFirst($parent->getUid());
        $tree->setChild($node->getUid(),$parent->getUid());
        $this->assertEquals(0,count($parent->getChildren()));
    }

    /**
     * @covers JTree::setParent
     * @expectedException Exception
     */
    public function testSetParentNullUid() {
        $tree = new JTree();
        $node = new JNode('test',1,1);
        $tree->setParent(null,$node);
    }
    
    /**
     * @covers JTree::setParent
     * @expectedException Exception
     */
    public function testSetParentNullParent() {
        $tree = new JTree();
        $node = new JNode('test',1,1);
        $tree->setParent($node,null);
    }
    
    /**
     * @covers JTree::setParent
     */
    public function testSetParentMissingNode() {
        $tree = new JTree();
        $node = new JNode('test',1,1);
        $tree->addFirst($node->getUid());
        $tree->setParent('nope', $node->getUid());
        $this->assertFalse($tree->getParent($node->getUid()));
    }
    
    /**
     * @covers JTree::setParent
     */
    public function testSetParentValid() {
        $tree = new JTree();
        $parent = new JNode('parent',1,1);
        $child = new JNode('child',1,1);
        $tree->addFirst($parent->getUid());
        $tree->addChild($parent->getUid(),$child->getUid());
        $tree->setParent($child->getUid(), $parent->getUid());
        $this->assertEquals($child->getUid(), $tree->getParent($child->getUid()));
    }
    

    /**
     * @covers JTree::createNode
     * @expectedException Exception
     */
    public function testCreateNodeNoValue() {
        $tree = new JTree();
        $uid = $tree->createNode(null, 1, 1);
    }
    
    /**
     * @covers JTree::createNode
     */
    public function testCreateNodeValid() {
        $tree = new JTree();
        $uid = $tree->createNode('test', 1, 1);
        $treeList = $tree->getTree();
        $this->assertNotNull($treeList[$uid]);
    }

    /**
     * @covers JTree::addChild
     * @expectedException Exception
     */
    public function testAddChildNoChildUid() {
        $tree = new JTree();
        $tree->addChild(null,null);
    }
    
    /**
     * @covers JTree::addChild
     */
    public function testAddChildNoParent() {
        $tree = new JTree();
        $uid = $tree->createNode('test',1,1);
        $ret = $tree->addChild(null, $uid);
        $this->assertNotNull($tree->getTree()[$uid]);
    }
    
    /**
     * @covers JTree::addFirst
     * @todo   Implement testAddFirst().
     */
    public function testAddFirst() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JTree::getChildren
     * @todo   Implement testGetChildren().
     */
    public function testGetChildren() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JTree::getParent
     * @todo   Implement testGetParent().
     */
    public function testGetParent() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers JTree::getValue
     * @todo   Implement testGetValue().
     */
    public function testGetValue() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
