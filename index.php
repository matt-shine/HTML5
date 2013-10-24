<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>HTML5 Wizard</title>
		<!-- CSS -->
                <link rel="stylesheet" href="style.css">
                <link href="css/lightbox.css" rel="stylesheet" />
		<link href="css/introjs.css" rel="stylesheet" type="text/css" />
		<link href="css/introjs-rtl.css" rel="stylesheet" type="text/css" />
		<!-- fonts -->
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Fjord+One' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
                <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
		<!-- Scripts -->
                <script src="javascript.js" type="text/javascript"></script>
		<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
		<script src="js/jquery.hashchange.min.js" type="text/javascript"></script>
		<script src="js/jquery.easytabs.min.js" type="text/javascript"></script>
		<script src="js/lightbox-2.6.min.js"></script>
		<script src="js/intro.js" type="text/javascript"></script>
	<script type="text/javascript">
      function startIntro(){
        var intro = introJs();
          intro.setOptions({
            steps: [
              {
                element: '#step1',
                intro: "Welcome to the validator! This is our logo"
              },
              {
                element: '#step2',
                intro: "A short introduction about how this tool can help you",
                position: 'right'
              },
              {
                element: '#step3',
                intro: 'Very simple steps on how use your favorite HTML5 validator',
                position: 'left'
              },
              {
                element: '#step4',
                intro: "Still unclear? Click here to get more help",
                position: 'bottom'
              },
              {
                element: '#input',
                intro: 'The main section to upload your code'
              },
			  {
                element: '#step6',
                intro: 'Here you can find many uploading methods, choose your preference'
              },
			  {
                element: '#step7',
                intro: 'Uploaded your code? Click this button and the validator will do the rest'
              }
            ]
          });

          intro.start();
      }
	$(document).ready( function() {
      $('#tab-container').easytabs();
    });
    </script>
  <style>
    /* tab style */
    .etabs { margin: 0; padding: 0; }
    .tab { display: inline-block; zoom:1.2; *display:inline; background: #D2D8DE; -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; }
    .tab a { font-size: 14px; line-height: 2em; display: block; padding: 0 10px; outline: none;text-decoration: none; border-color:#4DADEE;}
    .tab a:hover { text-decoration: underline; }
    .tab a:visited {color: rgb(32,52,80)}
    .tab.active { background: #CED2D5; padding-top: 6px; position: relative; top: 1px; }
    .tab a.active { font-weight: bold; }
    .tab-container .panel-container { background: #CED2D5; padding: 10px; }
    .panel-container { margin-bottom: 10px; }
  </style>
	</head>
	<body>
			<div id="header">
				<a href="index.php"><img id="step1" src="logo.png" title="HTML5 Wizard" width="380px" style="padding-left: 15px;" alt="logo"></a>
            </div>
			<div id="tagline">
				<p id="slogan">Test. Check. Upload. Validate. <span>Learn.</span></p>
			</div>
		<div id="container">
			<div id="content">
				<div id="intro">
                                <div id="intro_left">
                                    <div class="intro_title">Introduction</div>
                                    <div class="intro_text" id="step2">
                                        <p>HTML 5 Learning Tool is your best friend when you want to learn HTML 5. 
                                        It checks your source code,provides useful feedbacks. By using this tool 
                                        during the DECO1400 study, you will have a great understanding and knowledge 
                                        to make your own website in HTML 5. Have fun.</p>
                                    </div>
                                </div>
                                <div id="intro_right">
                                    <div class="intro_title">Steps</div>
                                    <div class="intro_text" id="step3">
                                        <ol>
                                            <li>Input your code via direct input or through file submission.</li>
                                            <li>Inspect your code on the results page.</li>
                                            <li>Determine any errors or warnings.</li>
                                            <li>Fix any problems discovered.</li>
                                            <li>Repeat until satisfied.</li>
                                        </ol>
                                        
                                        <a href="help.php"><button class="help-button" type="button">Help</button></a>
                                        <a href="guide_poster.png" data-lightbox="image-1" title="User Guide"><button style="margin-right:30px;" type="button" class="help-button">User Guide</button></a>
                                        <button style="margin-right:30px" id="step4" class="help-button" type="button" onclick="startIntro()">Site Tour</button>
                                        
                                    </div>
                                </div>        
                                <div style="clear:both;"></div>
                            </div>
                            <div id="input">
                                    <div id="tab-container" class='tab-container'>
                                     <ul id="step6" class='etabs'>
                                            <li class='tab'><a href="#tabs1-online">Validate by URL</a></li>
                                            <li class='tab'><a href="#tabs2-file">File upload</a></li>
                                            <li class='tab'><a href="#tabs3-zip">Upload a .zip file</a></li>
                                            <li class='tab'><a href="#tabs4-direct">Direct Input</a></li>
                                     </ul>
                                     <div class='panel-container'>
                                            <!-- Validate by URL tab -->
                                            <fieldset id="tabs1-online" class="tabset_content front">
                                                    <h2 class="tabset_label">Validate by URL</h2>
                                                    <form id="url" method="post" action="fileUpload.php">
                                                            <p class="instructions">
                                                                    Validate a document online:     
                                                            </p>
                                                            <p>
                                                            <label title="Address of page to Validate" for="url">Address:</label>
                                                                    <input type="text" name="url" id="url" size="45" value="http://"/>
                                                            </p>
                                                            <div class="btn_container">
                                                                    <button id="step7" title="Submit for validation" type="submit" class="submit_button" name="url-submit">Check</button>
                                                            </div>
                                                    </form>
                                            </fieldset>
                                            <!-- Validate by File Upload tab -->
                                            <fieldset id="tabs2-file"  class="tabset_content front">
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
                                            <fieldset id="tabs3-zip"  class="tabset_content front">
                                            <h2 class="tabset_label">Upload a .zip file</h2>
                                                    <form id="uploadzip" method="post" enctype="multipart/form-data" action="fileUpload.php">
                                                            <p class="instructions">Upload a .zip file containing a website for validation:</p>
                                                            <p>
                                                                    <label title="Choose a Local File to Upload" for="uploaded_zip">File:</label>
                                                                    <input type="file" id="uploaded_zip" name="uploaded_zip" size="30" />
                                                            </p>
                                                            <div class="btn_container">
                                                                    <button title="Submit for validation" type="submit" class="submit_button" name="zip-submit">Check</button>
                                                            </div>
                                                    </form>
                                            </fieldset>
                                            <!-- Validate by input tab-->
                                            <fieldset id="tabs4-direct"  class="tabset_content front">
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
	</body>
</html>
