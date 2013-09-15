<?php

include 'Parser.php';


if (isset($_POST['url-submit'])) {
    
}

elseif (isset($_POST['file-submit'])) {
    //for now, this is a single file
    echo "yp";
    if ($_FILES["uploaded_file"]["error"] > 0) {
        echo "Error: " . $_FILES["uploaded_file"]["error"] . "<br />";
    } else {
        $path = "upload/" . $_FILES["uploaded_file"]["name"];
        move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $path);
        $parser = new Parser($path);
        $parser->parse();
        $parser->createParseTree();
    }
    
    
} 

elseif (isset($_POST['zip-submit'])) {
    
}

elseif (isset($_POST['direct-submit'])) {
    
}

else {
    //NONE OF THE FORMS SET, SOMETHING HAS GONE WRONG!
    echo 'wtf?';
}
    
    
?>


