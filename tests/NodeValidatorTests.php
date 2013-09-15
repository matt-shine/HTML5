<?php

require_once '../NodeValidator.php';
require_once '../JTree.php';
require_once '../JNode.php';

class NodeValidatorTests extends UnitTestCase {
    
    function testValidateTitleTag() {
        $node1 = new JNode("title", 0, 0, null, null);
        $nv1 = new NodeValidator($node1);
        $nv1->validate();
        $this->assertTrue(count($nv1->getErrors()) == 0);
        
        $att2 = array("class");
        $node2 = new JNode("title", 0, 0, $att2, null);
        $nv2 = new NodeValidator($node2);
        $nv2->validate();
        $this->assertTrue(count($nv2->getErrors()) == 0);
        
        $att3 = array("NotAGlobalAttribute");
        $node3 = new JNode("title", 0, 0, $att3, null);
        $nv3 = new NodeValidator($node3);
        $nv3->validate();
        $this->assertEqual($nv3->getErrors()[0], "Invalid Title Tag Attribute: NotAGlobalAttribute");
      
    }
    
    function testInvalidTag() {
        $node = new JNode("nope", 0, 0, null, null);
        $nv = new NodeValidator($node);
        $nv->validate();
        $this->assertEqual($nv->getErrors()[0], "Invalid tag");
    }
    
    function testDoctype() {
        $att1 = array("html");
        $node1 = new JNode("!DOCTYPE", 0, 0, $att1, null);
        $nv1 = new NodeValidator($node1);
        $nv1->validate();
        $this->assertTrue(count($nv1->getErrors()) == 0);
        
        $att2 = array("html", "wrong");
        $node2 = new JNode("!DOCTYPE", 0, 0, $att2, null);
        $nv2 = new NodeValidator($node2);
        $nv2->validate();
        $this->assertTrue(in_array("Doctype must have only one attribute.", $nv2->getErrors()));
        
        $node3 = new JNode("!DOCTYPE", 0, 0, null, null);
        $nv3 = new NodeValidator($node3);
        $nv3->validate();
        $this->assertTrue(in_array("Doctype is missing required specification.", $nv3->getErrors()));
        
        $att4 = array("html4");
        $node4 = new JNode("!DOCTYPE", 0, 0, $att4, null);
        $nv4 = new NodeValidator($node4);
        $nv4->validate();
        $this->assertTrue(in_array("Declared Doctype is not HTML5.", $nv4->getErrors()));
    }
    
    
}

?>
