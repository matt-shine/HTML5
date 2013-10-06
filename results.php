<?php
require 'JNode.php';

session_start();



if (!isset($_SESSION['lines'])) {
    $sessionError = "NOPE!";
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>HTML5 Learning Tool</title>
		<link rel="stylesheet" type="text/css" href="style.css">
                <link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
                <script type="text/javascript" src="javascript.js"></script>
                <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
                <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<table>
					<tr>
						<td>
							<h1 id="header_logo">HTML5 Learning Tool</h1>
						</td>
						<td>
							<ul id="tabset_tabs">
								<li><a href="javascript:showurl();"><span>Validate by URL</span></a></li>
								<li><a href="javascript:showfile();"><span>File upload</span></a></li>
								<li><a href="javascript:showzip();"><span>Upload a .zip file</span></a></li>
								<li><a href="javascript:showinput();"><span>Direct Input</span></a></li>
							</ul>
						</td>
					</tr>
				</table>
			</div>
			
			<div id="tagline">
				<p id="slogan">Test. Check. Upload. Validate. <span>Learn.</span></p>
			</div>
			<div id="content">
                            <div id="results">
                                <?php
                                    function compare_nodes($a, $b) {
                                        if ($a->getInd() == $b->getInd()) {
                                            return 0;
                                        }
                                        return ($a->getInd() < $b->getInd()) ? -1 : 1;
                                    }
                                
                                    if (isset($sessionError)) {
                                        echo 'Problem loading results....';
                                    } else {
                                        
                                        echo '<pre>';
                                    
                                        $lines = $_SESSION['lines'];
                                        $nodesWithErrors = $_SESSION['nodesWithErrors'];
                                        /* Get the line numbers that contain errors */
                                        $linesWithErrors = array();
                                        foreach ($nodesWithErrors as $node) {
                                            array_push($linesWithErrors, $node->getLn());
                                        }
                                        
                                        for ($i = 0; $i < count($lines); $i++) {
                                            if (!in_array($i, $linesWithErrors)) {
                                                /* No error was found in this line */
                                                echo htmlspecialchars($lines[$i]) . "\n";
                                            } else {
                                                /* Error(s) in this line */
                                                $thisLinesErrorNodes = array();
                                                foreach ($nodesWithErrors as $node) { //get the  nodes in this line with errors
                                                    if ($node->getLn() == $i) {
                                                        array_push($thisLinesErrorNodes, $node);
                                                    }
                                                }
                                                
                                                if (count($thisLinesErrorNodes) == 1) {
                                                    /* Only one error */
                                                    $singleNode = $thisLinesErrorNodes[0];
                                                    
                                                    if ($singleNode->getInd() == 0) {
                                                        /* Error at position 0 */
                                                        $errorString = "";
                                                        
                                                        $errors = $singleNode->getErrors();
                                                        foreach ($errors as $e) {
                                                            $errorString .= $e;
                                                        }
                                                        echo "<span class=\"tooltip\" title=\"$errorString\" >" . htmlspecialchars(substr($lines[$i], 0, strpos($lines[$i], ">")+1)) 
                                                                . "</span>" . htmlspecialchars(substr($lines[$i], strpos($lines[$i], ">")+1)) . "\n"; 
                                                        
                                                     } else {
                                                         $tagLength = strlen($singleNode->getValue()) + 1;
                                                         if ($singleNode->getAttr() != null) {
                                                             $attr = $singleNode->getAttr();
                                                             for ($j = 0; $j < count($attr); $j++) {
                                                                 if (count($attr[$j]) > 0) {
                                                                 $tagLength += strlen($attr[$j]) + 2;
                                                                 }
                                                             }
                                                         }
                                                         $errorString = "";
                                                        
                                                        $errors = $singleNode->getErrors();
                                                        foreach ($errors as $e) {
                                                            $errorString .= $e;
                                                        }
                                                         echo htmlspecialchars(substr($lines[$i], 0, $singleNode->getInd()-2)) . 
                                                                    "<span class=\"tooltip\" title=\"$errorString\">" . 
                                                                        htmlspecialchars(substr($lines[$i], $singleNode->getInd(), $tagLength)) . "</span>" . 
                                                                        htmlspecialchars(substr($lines[$i],$singleNode->getInd() + $tagLength)) . "\n";
                                                     }
                                                 }
                                                        
                                                 elseif (count($thisLinesErrorNodes) > 1) {
                                                    
                                                    /* sort the nodes based on their indexes */
                                                    usort($thisLinesErrorNodes, 'compare_nodes');
                                                    $formattedLine = "";
                                                    
                                                    for ($j = 0; $j < count($thisLinesErrorNodes); $j++) {
                                                        $errorString = "";
                                                        
                                                        $errors = $thisLinesErrorNodes[$j]->getErrors();
                                                        foreach ($errors as $e) {
                                                            $errorString .= $e;
                                                        }
                                                        $tagLength = strlen($thisLinesErrorNodes[$j]->getValue())+2;
                                                        if ($j == 0) {
                                                            $formattedLine = htmlspecialchars(substr($lines[$i], 0, $thisLinesErrorNodes[$j]->getInd())) .
                                                                    "<span class=\"tooltip\" title=\"$errorString!\">" . htmlspecialchars(substr($lines[$i], $thisLinesErrorNodes[$j]->getInd(), $tagLength)) . "</span>";
                                                        } elseif ($j == count($thisLinesErrorNodes)-1) {
                                                            $formattedLine = $formattedLine . "<span class=\"tooltip\" title=\"$errorString!\">" . 
                                                            htmlspecialchars(substr($lines[$i], $thisLinesErrorNodes[$j]->getInd(), $tagLength)) . "</span>" . 
                                                                    htmlspecialchars(substr($lines[$i], $thisLinesErrorNodes[$j]->getInd()+$tagLength));
                                                        } else {
                                                            $endOfPrevious = $thisLinesErrorNodes[$j-1]->getInd() + strlen($thisLinesErrorNodes[$j-1]->getValue()) + 2;
                                                            $formattedLine  = $formattedLine . "<span class=\"tooltip\" title=\"$errorString!\">" . 
                                                                    htmlspecialchars(substr($lines[$i], $endOfPrevious, $tagLength)) . "</span>";
                                                        }
                                                    }
                                                    echo $formattedLine . "\n";
                                                    

                                                    
                                                } else {
                                                    echo "Something went horribly wrong";
                                                }  
                                            }  
                                        }
                                        echo '</pre>';
                                    }
                                ?>
                            </div>
			</div>
			<div id="footer" align="center">
				<table id="footer-table">
					<tr>
						<td class="footer-left">
							<a href="index.html">Home</a> | <a href="help.html">Help & FAQ</a>
						</td>
						<td class="footer-right">
							Copyright &copy; UQ DECO3801
						</td>
					</tr>
				</table>
			</div> 
		</div>
            <script>
        $(document).ready(function() {
            $('.tooltip').tooltipster({position:'right'});
        });
    </script>
	</body>
</html>
