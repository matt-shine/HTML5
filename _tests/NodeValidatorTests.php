<?php

require_once '../NodeValidator.php';
require_once '../JTree.php';
require_once '../JNode.php';

class NodeValidatorTests extends UnitTestCase {
    
    
    /**
     * Test the validateTitleTag() function is called when given
     * JNode is a title tag. If so, check that:
     *  *If given node is valid, getErrors returns empty array.
     *  *If given node has global attribute, getErrors returns empty array
     *  *If given node has non-global attribute, getErrors contains relevant
     *      error.
     */
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
    /**
     * Test the validate() function correctly identifies a tag as being
     * invalid and getErrors returns an array containing the corresponding
     * error message.
     */
    function testInvalidTag() {
        $node = new JNode("nope", 0, 0, null, null);
        $nv = new NodeValidator($node);
        $nv->validate();
        $this->assertEqual($nv->getErrors()[0], "Invalid tag");
    }
    
    /**
     * Test the validateDoctype() function (private) validates a
     * correctly formatted !DOCTYPE declaration, and produces the
     * corresponding errors if incorrectly formatted.
     */
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
    
    function testMetaTag() {
        $this->fail("Pending implementation.");
    }
    
    function testScriptTag() {
        $this->fail("Pending implementation.");
    }
    
    function testDeprecatedTag() {
        $this->fail("Pending implementation.");
    }
    
    function testHeadTag() {
        $this->fail("Pending implementation.");
    }
    
    function testBodyTag() {
        $this->fail("Pending implementation.");
    }
    
}

?>
