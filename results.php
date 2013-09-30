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
		<link rel="stylesheet" href="style.css">
		<script type="text/Javascript" src="javascript.js"></script>
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
                                                echo htmlspecialchars($lines[$i]);
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
                                                        echo "<span style=\"color:red;text-decoration:underline; \">" . htmlspecialchars(substr($lines[$i], 0, strpos($lines[$i], ">")+1)) 
                                                                . "</span>" . htmlspecialchars(substr($lines[$i], strpos($lines[$i], ">")+1)); 
                                                        
                                                    }
                                                } elseif (count($thisLinesErrorNodes) > 1) {
                                                    
                                                    /* sort the nodes based on their indexes */
                                                    usort($thisLinesErrorNodes, 'compare_nodes');
                                                    $formattedLine;
                                                   
                                                    for ($j = 0; $j < count($thisLinesErrorNodes); $j++) {
                                                        if ($j == 0) {
                                                            $formattedLine = htmlspecialchars(substr($lines[$i], $thisLinesErrorNodes[$j]->getInd(), strlen($thisLinesErrorNodes[$j]->getValue())+1)) .
                                                                    "<span style=\"color:red;text-decoration:underline; \">" . substr($lines[$i], strlen($thisLinesErrorNodes[$j]->getValue())+1, $thisLinesErrorNodes[$j]->getInd()-1) . "</span>";
                                                        } elseif ($j == count($thisLinesErrorNodes)-1) {
                                                            $formattedLine = formattedLine . "<span style=\"color:red;text-decoration:underline; \">" . 
                                                            htmlspecialchars(substr($lines[$i], $thisLinesErrorNodes[$j]->getInd(), strlen($thisLinesErrorNodes[$j]->getValue())+1)) . "</span>" . 
                                                                    htmlspecialchars($substr($lines[$i], ))
                                                                    
                                                        }
                                                        $formattedLine 
                                                    }

                                                    foreach ($thisLinesErrorNodes as $multiNode) {
                                                        $thisNodesCloseTag = strpos($lines[$i], ">", $multiNode->getInd());
                                                         htmlspecialchars(substr($lines[$i], 0, $multiNode->getInd())) . "<span style=\"color:red;text-decoration:underline; \">"
                                                                . htmlspecialchars($lines[$i], )
                                                    }
                                                    
                                                } else {
                                                    echo "Something went horribly wrong";
                                                }
                                                
                                                
                                                
                                            }
                                            
                                            
                                            
                                        }
                                        
                                        
                                        echo '</pre>';
                                        
                                        
                                        
//                                        echo '<pre>';
//                                        $i = 0;
//                                        foreach ($_SESSION['lines'] as $line) {
//                                            //inefficient
//                                            $e = 0;
//                                            
//                                            
//                                            
//                                            
//                                            foreach ($_SESSION['nodesWithErrors'] as $node) {
//                                                if ($node->getLn() == $i) {
//                                                    $e++;
//                                                    array_push($errorIndexes, $node->getInd()); 
//                                                    
//                                                }
//                                            }
//                                            if ($e == 0) {
//                                                /* No errors */
//                                                echo htmlspecialchars($line);
//                                                $i++;
//                                                continue;
//                                            } else {
//                                                /* error(s) in this line */
//                                                for ($i=0; $i < $e; $i++) {
//                                                    if ($errorIndexes[$i] == 0) {
//                                                        $start = strpos($line, "<");
//                                                        $end = strpos($line, ">") + 1;
//                                                        $outputString = htmlspecialchars(substr($line, 0, $start)) . "<span style=\"color:red;text-decoration:underline; \">" . htmlspecialchars(substr($line, $start, $end)) 
//                                                                . "</span>" . htmlspecialchars(substr($line, $end)); 
//                                                    } else {
//                                                        $end = strpos($line, ">", $errorIndexes[$i]) + 1;
//                                                        $outputString = $outputString + "<span style=\"color:red;text-decoration:underline; \">" . 
//                                                                htmlspecialchars(substr($line, $errorIndexes[$i]), $end) . "</span>" . 
//                                                            htmlspecialchars(substr($line, $end));
//                                                    }
//                                                }
//                                                //$outputString = $outputString + htmlspecialchars(substr($line,));
//                                            }
//                                            echo $outputString;
//                                            $i++;
//                                        }
//                                        echo '</pre>';
                                        
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
	</body>
</html>
