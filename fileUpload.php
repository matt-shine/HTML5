<?php
session_start();
include 'Parser.php';


if (isset($_POST['url-submit'])) {
    
}

elseif (isset($_POST['file-submit'])) {
    try {
        if ($_FILES["uploaded_file"]["error"] > 0) {
            echo "Error: " . $_FILES["uploaded_file"]["error"] . "<br />";
        } else {
            $path = "upload/" . $_FILES["uploaded_file"]["name"];
            move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $path);
            $parser = new Parser($path);
            $parser->parse();
            $parser->createParseTree();
            $parser->runValidator();
            unlink($path);
        }
    } catch (Exception $e) {
        $_SESSION['errorMessage'] = $e->getMessage;
        header('Location: uhoh.php');
    }
} 

elseif (isset($_POST['zip-submit'])) {
    
}

elseif (isset($_POST['direct-submit'])) {
    try {
        $input = $_POST['fragment'];
        $temp = tempnam("./temp", "input-");
        file_put_contents($temp, $input);
        $parser = new Parser($temp);
        $parser->parse();
        $parser->createParseTree();
        $parser->runValidator();
        unlink($temp);
    } catch (Exception $e) {
        $_SESSION['errorMessage'] = $e->getMessage();
        header('Location: uhoh.php');
    }
    
}

else {
    //NONE OF THE FORMS SET, SOMETHING HAS GONE WRONG!
    echo 'wtf?';
}
    
    
?>


