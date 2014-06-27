<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>HTML5 Wizard - Oops!</title>
		<link rel="stylesheet" href="style.css">
		<!-- fonts -->
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Fjord+One' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
                <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
		<script type="text/Javascript" src="javascript.js"></script>
	</head>
	<body>
			<div id="header">
                            <div id="logo">
				<a href="index.php"><img src="logo.png" title="HTML5 Wizard" width="380px" style="padding-left: 15px;" alt="logo"></a>
                            </div>
                        </div>
                            <div id="tagline">
				<p id="slogan">Test. Check. Upload. Validate. <span>Learn.</span></p>
                            </div>
                        
            <div style="clear:both"></div>
		<div id="container">
			<div id="content">
                            <div class="error_pane">
                                <div class="error_pane_title">Ooops.. Something wen't wrong!</div>
                                <?php
                                    //if (isset($_SESSION['errorMessage'])) {
                                        echo "<div class=\"error_message\">" . $_SESSION['errorMessage'] . "<div><br />";
                                    //}
                                ?>
                                    <form id="homelink" name="homelink" action="index.php">
                                        <button title="Take me home" type="submit" class="submit_button">Home</button>
                                    </form>
                                </div>
                            </div>
                        </div>
			<!-- Footer-->
			<div id="footer">
				<div id="footer_container">
					<div class="footer_links_menu">
						<div class="footer_menu_title">HTML5 Wizard</div>
						<div class="footer_links_list">
							<ul>
								<li><a href="index.php">Home</a></li>
								<li><a href="help.php">Help</a></li>
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
								<li><a href="http://www.w3schools.com/html/html5_intro.asp">HTML5</a></li>
								<li><a href="http://www.w3schools.com/css/default.asp">CSS</a></li>
								<li><a href="http://www.w3schools.com/js/default.asp">JavaScript</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
                        <?php
                            session_destroy();
                        ?>
	</body>
</html>
