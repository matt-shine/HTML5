<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>HTML5 Wizard</title>
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
                            <div id="intro">
                                <div id="intro_left">
                                    <div class="intro_title">Introduction</div>
                                    <div class="intro_text">
                                        <p>HTML 5 Learning Tool is your best friend when you want to learn HTML 5. 
                                        It checks your source code,provides useful feedbacks. By using this tool 
                                        during the DECO1400 study, you will have a great understanding and knowledge 
                                        to make your own website in HTML 5. Have fun.</p>
                                    </div>
                                </div>
                                <div id="intro_right">
                                    <div class="intro_title">Steps</div>
                                    <div class="intro_text">
                                        <ol>
                                            <li>Input your code via direct input or through file submission.</li>
                                            <li>Inspect your code on the results page.</li>
                                            <li>Determine any errors or warnings.</li>
                                            <li>Fix any problems discovered.</li>
                                            <li>Repeat until satisfied.</li>
                                        </ol>
                                        <button class="help-button" type="button">Help</button>
                                    </div>
                                </div>	
                                <div style="clear:both;"></div>
                            </div>
				<div id="input">
					<ul id="tabset_tabs">
								<li><a href="javascript:showurl();"><span>Validate by URL</span></a></li>
								<li><a href="javascript:showfile();"><span>File upload</span></a></li>
								<li><a href="javascript:showzip();"><span>Upload a .zip file</span></a></li>
								<li><a href="javascript:showinput();"><span>Direct Input</span></a></li>
							</ul>
					<!-- Validate by URL tab -->
					<fieldset id="validate-by-url" class="tabset_content front">
						<h2 class="tabset_label">Validate by URL</h2>
						<form id="url" method="post" action="fileUpload.php">
							<p class="instructions">
								Validate a document online:     
							</p>
							<p>
							<label title="Address of page to Validate" for="url">Address:</label>
								<input type="text" name="url" id="url" size="45" />
							</p>
							<div class="btn_container">
								<button title="Submit for validation" type="submit" class="submit_button" name="url-submit">Check</button>
							</div>
						</form>
					</fieldset>
					
					<!-- Validate by File Upload tab -->
					<fieldset id="validate-by-upload"  class="tabset_content front" style="display: none;">
						<h2 class="tabset_label">Validate by File Upload</h2>
						<form id="fileupload" method="post" enctype="multipart/form-data" action="fileUpload.php">
							<p class="instructions">Upload a document for validation:</p>
							<p>
								<label title="Choose a Local File to Upload and Validate" for="uploaded_file">File:</label>
								<input type="file" id="uploaded_file" name="uploaded_file" size="30" />
							</p>
							<div class="btn_container">
								<button title="Submit for validation" type="submit" class="submit_button" name="file-submit" >Check</button>
							</div>
						</form>
					</fieldset>
					
					<!-- Validate by Zip tab-->
					<fieldset id="validate-by-zip"  class="tabset_content front" style="display: none;">
					<h2 class="tabset_label">Upload a .zip file</h2>
						<form id="uploadzip" method="post" enctype="multipart/form-data" action="fileUpload.php">
							<p class="instructions">Upload a .zip file containing a website for validation:</p>
							<p>
								<label title="Choose a Local File to Upload" for="uploaded_zip">File:</label>
								<input type="file" id="uploaded_file" name="uploaded_file" size="30" />
							</p>
							<div class="btn_container">
								<button title="Submit for validation" type="submit" class="submit_button" name="zip-submit">Check</button>
							</div>
						</form>
					</fieldset>
					
					<!-- Validate by input tab-->
					<fieldset id="validate-by-input"  class="tabset_content front" style="display: none;">
					<h2 class="tabset_label">Validate by direct input</h2>
						<form id="directinput" method="post" enctype="multipart/form-data" action="fileUpload.php">
							<p class="instructions"><label title="Paste a complete (HTML) Document here" for="fragment">Enter the Markup to validate</label>:</p>

								<textarea id="fragment" name="fragment" rows="12" cols="80"></textarea>
								
								<div class="btn_container">
								<button title="Submit for validation" type="submit" class="submit_button" name="direct-submit">Check</button>
							</div>
						</form>
					</fieldset>	
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
								<li><a href="#">HTML</a></li>
								<li><a href="#">CSS</a></li>
								<li><a href="#">JavaScript</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
	</body>
</html>
