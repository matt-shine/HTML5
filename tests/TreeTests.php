<?php

require_once '../JTree.php';
require_once '../JNode.php';


class TreeTests extends UnitTestCase {
    
    function testConstructorValid() {
        $tree = new JTree();
        $this->assertTrue(is_a($tree, "JTree"));
    }
    
    function testCreateNode() {
        $tree = new JTree();
        $nodeUid = $tree->createNode("testNode", 0, 0, null, null);
        $this->assertEqual($tree->getNode($nodeUid)->getValue(), "testNode");
        $this->expectException();
        $tree->createNode(null, 0, 0, null, null);
    }
        
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
