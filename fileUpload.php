<?php
session_start();
require_once 'Parser.php';


if (isset($_POST['url-submit'])) {
    try {
        $temp = tempnam("./temp");
        file_put_contents($temp, fopen($_POST['url'], 'r'));
         $parser = new Parser($temp);
        $parser->parse();
        $parser->createParseTree();
        $parser->runValidator();
        if (file_exists($temp)) {
                unlink($temp);
            }
    } catch (Exception $e) {
        $_SESSION['errorMessage'] = $e->getMessage();
        header('Location: uhoh.php');
    }

}


elseif (isset($_POST['file-submit'])) {
    try {
        if ($_FILES["uploaded_file"]["error"] > 0) {
            $errormsg = "";
            switch ($_FILES["uploaded_file"]["error"]) {
                case 1:
                    $errormsg = "File is too big!";
                    break;
                case 2:
                    $errormsg = "File is too  big!";
                    break;
                case 3:
                    $errormsg = "Only part of the file was uplaoded";
                    break;
                case 4:
                    $errormsg = "No file was uploaded";
                    break;
                case 6:
                    $errormsg = "Something went wrong on the server [Error: 6]";
                    break;
                case 7:
                    $errormsg = "Something went wrong on the server [Error: 7]";
                    break;
                case 8:
                    $errormsg = "Something went wrong on the server [Error: 8]";
                    break;
                default:
                    $errormsg = "Something went really wrong!";
                    break;
        }
            
            $_SESSION['errorMessage'] = $errormsg;
            header('Location: uhoh.php');
        } else {
            $path = "upload/" . $_FILES["uploaded_file"]["name"];
            move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $path);
            $parser = new Parser($path);
            $parser->parse();
            $parser->createParseTree();
            $parser->runValidator();
            if (file_exists($path)) {
                unlink($path);
            }
        }
    } catch (Exception $e) {
        $_SESSION['errorMessage'] = $e->getMessage();
        header('Location: uhoh.php');
    }
} 

elseif (isset($_POST['zip-submit'])) {
    $info = pathinfo($_POST['uploaded_zip']);
    
    
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
        if (file_exists($temp)) {
                unlink($temp);
            }
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


