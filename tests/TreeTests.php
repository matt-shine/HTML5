<?php

require_once '../JTree.php';
require_once '../JNode.php';


class TreeTests extends UnitTestCase {
    
    /**
     * Check the constructor correctly instantiates a new
     * JTree
     */
    function testConstructorValid() {
        $tree = new JTree();
        $this->assertTrue(is_a($tree, "JTree"));
    }
    
    /**
     * Check that createNode() creates a new JNode with valid
     * inputs, and throws an exception with invalid inputs.
     */
    function testCreateNode() {
        $tree = new JTree();
        $nodeUid = $tree->createNode("testNode", 0, 0, null, null);
        $this->assertEqual($tree->getNode($nodeUid)->getValue(), "testNode");
        $this->expectException();
        $tree->createNode(null, 0, 0, null, null);
    }
    
    /**
     * Test the addFirst() function correctly adds the given node
     * as a child of the special 'HEAD' node when given a valid JNode.
     * Also ensure that if given JNode is invalid an exception is thrown.
     */
    function testAddFirst() {
        $tree = new JTree();
        $node = new JNode("test", 0, 0, null, null);
        $nodeUid = $node->getUid();
        $tree->addFirst($nodeUid);
        $this->assertTrue(array_key_exists($nodeUid, $tree->getChildren($tree->getHeadNode()->getUid())));
        //Invalid arg
        $newTree = new JTree();
        $this->expectException();
        $newTree->addFirst(null);
    }
    
    
    /**
     * Check the addChild function is adding JNodes as children of
     * specified parent JNodes, and that getChildren returns an array containing
     * those children.
     */
    function testChildren() {
        $tree = new JTree();
        $node1 = $tree->createNode("testParent", 0, 0, null, null);
        $tree->addChild(null, $node1);
        $node2 = $tree->createNode("testChild", 0, 0, null, null);
        $tree->addChild($node1, $node2);
        $this->assertEqual($tree->getChildren($tree->getHeadNode()->getUid())[0], $node1);
        $this->assertEqual($tree->getChildren($node1)[0], $node2);
    }    
    
}

?>
