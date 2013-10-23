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
		<title>HTML5 Wizard</title>
		<link rel="stylesheet" type="text/css" href="style.css">
                <link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
		<!-- fonts -->
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Fjord+One' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
                <link href='http://fonts.googleapis.com/css?family=Open+Sans:700' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="javascript.js"></script>
                <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
                <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
	</head>
	<body>
		<div id="head">
			<div id="header">
				<a href="index.php"><img src="logo.png" title="HTML5 Wizard" width="380px" style="padding-left: 15px;" alt="logo"></a>
                        </div>
			<div id="tagline">
				<p id="slogan">Test. Check. Upload. Validate. <span>Learn.</span></p>
			</div>
		</div>
		<div id="container">
			<div id="content">
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
                                        
                                        
                                    
                                        $lines = $_SESSION['lines'];
                                        $nodesWithErrors = $_SESSION['nodesWithErrors'];
                                        $nodesWithWarnings = $_SESSION['nodesWithWarnings'];
                                        /* Get the line numbers that contain errors */
                                    if (count($nodesWithErrors) > 0 || count($nodesWithWarnings) > 0) {
                                            echo "<div id=\"validation-fail\">Errors detected!</div>";
                                        } else {
                                            echo "<div id=\"validation-success\">Success!</div>";
                                        }
                                        echo '<div class="box results">';
                                        echo '<pre>';
                                        $linesWithErrors = array();
                                        foreach ($nodesWithErrors as $node) {
                                            array_push($linesWithErrors, $node->getLn());
                                        }
                                        foreach ($nodesWithWarnings as $node) {
                                            if (!in_array($node->getLn(), $linesWithErrors)) {
                                                array_push($linesWithErrors, $node->getLn());
                                            }
                                        }
                                        
                                        for ($i = 0; $i < count($lines); $i++) {
                                            if (!in_array($i, $linesWithErrors)) {
                                                /* No error was found in this line */
                                                echo "$i\t" . htmlspecialchars($lines[$i]) . "\n";
                                            } else {
                                                /* Error(s) in this line */
                                                $thisLinesErrorNodes = array();
                                                $thisLinesWarningNodes = array();
                                                foreach ($nodesWithErrors as $node) { //get the nodes in this line with errors
                                                    if ($node->getLn() == $i) {
                                                        array_push($thisLinesErrorNodes, $node);
                                                    }
                                                }
                                                foreach ($nodesWithWarnings as $node) { //get the nodes in this line with warnings
                                                    if ($node->getLn() == $i) {
                                                        array_push($thisLinesWarningNodes, $node);
                                                    }
                                                }
                                                $lineErrorCount = count($thisLinesErrorNodes);
                                                $lineWarningCount = count($thisLinesWarningNodes);
                                                
                                                if ($lineErrorCount == 1 xor $lineWarningCount == 1) {
                                                    /* There's only a single error or warning on this line */
                                                    if ($lineErrorCount == 1) {
                                                        $singleNode = $thisLinesErrorNodes[0];
                                                    } else {
                                                        $singleNode = $thisLinesWarningNodes[0];
                                                    }
                                                    if ($singleNode->getInd() == 0) {
                                                        /* Error at position 0 */
                                                        $errorString = "";
                                                        $warningString = "";
                                                        $errors = $singleNode->getErrors();
                                                        $warnings = $singleNode->getWarnings();
                                                        
                                                        if (count($errors) > 0) {
                                                            foreach ($errors as $e) {
                                                                $errorString .= $e;
                                                            }
                                                            echo "$i\t" . "<span class=\"tooltip\" title=\"$errorString\" style=\"background-color:#FF3030;border-style:solid;border-width:1px;border-color:white;border-radius:4px;\">" . htmlspecialchars(substr($lines[$i], 0, strpos($lines[$i], ">")+1)) 
                                                                . "</span>" . htmlspecialchars(substr($lines[$i], strpos($lines[$i], ">")+1)) . "\n"; 
                                                        } else {
                                                            foreach ($warnings as $w) {
                                                                $warningString .= $w;
                                                            }
                                                            echo "$i\t" . "<span class=\"tooltip\" title=\"" . htmlspecialchars($warningString) . "\" style=\"background-color:#FFCC00;border-style:solid;border-width:1px;border-color:white;border-radius:4px;\">" . htmlspecialchars(substr($lines[$i], 0, strpos($lines[$i], ">")+1)) 
                                                                . "</span>" . htmlspecialchars(substr($lines[$i], strpos($lines[$i], ">")+1)) . "\n"; 
                                                        }
                                                     } else {
                                                         $tagLength = strlen($singleNode->getValue()) + 1;
                                                         if ($singleNode->getAttr() != null) {
                                                             $attr = $singleNode->getAttr();
                                                             if (count($attr) == 1) {
                                                                 $k = key($attr);
                                                                 $v = $attr[$k];
                                                                 $tagLength += strlen($k) + strlen($v);
                                                             } else {
                                                                foreach ($attr as $k => $v){
                                                                    $tagLength += strlen($k) + strlen($v) + 4;
                                                                }
                                                                $tagLength += 1;
                                                             }
                                                         }
                                                         $errorString = "";
                                                         $warningString = "";
                                                        
                                                        $errors = $singleNode->getErrors();
                                                        $warnings = $singleNode->getWarnings();
                                                        
                                                        if (count($errors) > 0) {
                                                            foreach ($errors as $e) {
                                                                $errorString .= $e;
                                                            }
                                                            echo "$i\t" . htmlspecialchars(substr($lines[$i], 0, $singleNode->getInd()-2)) . 
                                                                    "<span class=\"tooltip\" title=\"$errorString\" style=\"background-color:#FF3030;border-style:solid;border-width:1px;border-color:white;border-radius:4px;\">" . 
                                                                        htmlspecialchars(substr($lines[$i], $singleNode->getInd(), $tagLength)) . "</span>" . 
                                                                        htmlspecialchars(substr($lines[$i],$singleNode->getInd() + $tagLength)) . "\n";
                                                        } else {
                                                            foreach ($warnings as $w) {
                                                                $warningString .= $w;
                                                            }
                                                            echo "$i\t" . htmlspecialchars(substr($lines[$i], 0, $singleNode->getInd()-2)) . 
                                                                    "<span class=\"tooltip\" title=\"" . htmlspecialchars($warningString) . "\" style=\"background-color:#FFCC00;border-style:solid;border-width:1px;border-color:white;border-radius:4px;\">" . 
                                                                        htmlspecialchars(substr($lines[$i], $singleNode->getInd(), $tagLength)) . "</span>" . 
                                                                        htmlspecialchars(substr($lines[$i],$singleNode->getInd() + $tagLength)) . "\n";
                                                        }
                                                     }
                                                 }
                                                        
                                                 elseif (count($thisLinesErrorNodes) > 1) {
                                                    
                                                    /* sort the nodes based on their indexes */
                                                    usort($thisLinesErrorNodes, 'compare_nodes');
                                                    $formattedLine = "";
                                                    
                                                    if (count($thisLinesErrorNodes) > 0) {
                                                        for ($j = 0; $j < count($thisLinesErrorNodes); $j++) {
                                                            $errorString = "";

                                                            $errors = $thisLinesErrorNodes[$j]->getErrors();
                                                            foreach ($errors as $e) {
                                                                $errorString .= $e;
                                                            }
                                                            $tagLength = strlen($thisLinesErrorNodes[$j]->getValue())+2;
                                                            if ($j == 0) {
                                                                $formattedLine = htmlspecialchars(substr($lines[$i], 0, $thisLinesErrorNodes[$j]->getInd())) .
                                                                        "<span class=\"tooltip\" title=\"$errorString\" style=\"background-color:#FF3030;border-style:solid;border-width:1px;border-color:white;border-radius:4px;\">" . htmlspecialchars(substr($lines[$i], $thisLinesErrorNodes[$j]->getInd(), $tagLength)) . "</span>";
                                                            } elseif ($j == count($thisLinesErrorNodes)-1) {
                                                                $formattedLine = $formattedLine . "<span class=\"tooltip\" title=\"$errorString\" style=\"background-color:#FF3030;border-style:solid;border-width:1px;border-color:white;border-radius:4px;\">" . 
                                                                htmlspecialchars(substr($lines[$i], $thisLinesErrorNodes[$j]->getInd(), $tagLength)) . "</span>" . 
                                                                        htmlspecialchars(substr($lines[$i], $thisLinesErrorNodes[$j]->getInd()+$tagLength));
                                                            } else {
                                                                $endOfPrevious = $thisLinesErrorNodes[$j-1]->getInd() + strlen($thisLinesErrorNodes[$j-1]->getValue()) + 2;
                                                                $formattedLine  = $formattedLine ."<span class=\"tooltip\" title=\"$errorString\" style=\"background-color:#FF3030;border-style:solid;border-width:1px;border-color:white;border-radius:4px;\">" . 
                                                                        htmlspecialchars(substr($lines[$i], $endOfPrevious, $tagLength)) . "</span>";
                                                            }
                                                        }
                                                    }
                                                    
                                                    echo "$i\t" . $formattedLine . "\n";
                                                    

                                                    
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
			<!-- Footer-->
			<div id="footer">
				<div id="footer_container">
					<div class="footer_links_menu">
						<div class="footer_menu_title">HTML5 Wizard</div>
						<div class="footer_links_list">
							<ul>
								<li><a href="index.html">Home</a></li>
								<li><a href="help.html">Help</a></li>
							</ul>
						</div>
					</div>
					<div class="footer_links_menu">
						<div class="footer_menu_title">DECO1400</div>
						<div class="footer_links_list">
						<ul>
								<li><a href="#">Course Profile</a></li>
								<li><a href="#">Tutorials</a></li>
								<li><a href="#">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="footer_links_menu">
						<div class="footer_menu_title">w3schools</div>
						<div class="footer_links_list">
						<ul>
								<li><a href="#">HTML</a></li>
								<li><a href="#">CSS</a></li>
								<li><a href="#">JavaScript</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
                         <script>
        $(document).ready(function() {
            $('.tooltip').tooltipster({position:'right', maxWidth:300});
        });
    </script>
    <?php
        session_destroy();
    ?>
	</body>
</html>
