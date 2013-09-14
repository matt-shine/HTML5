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
				<div id="intro">
					<h4>Introduction</h4>
					<p> introduction stuff blah blah blah blah test test fill with text </p>
				</div>
				<div id="input">
				
					<!-- Validate by URL tab -->
					<fieldset id="validate-by-url" class="tabset_content front">
						<legend class="tabset_label">Validate by URL</legend>
						<form id="url" method="post" action="fileUpload.php">
							<p class="instructions">
								Validate a document online:     
							</p>
							<p>
							<label title="Address of page to Validate" for="url">Address:</label>
								<input type="text" name="url" id="url" size="45" />
							</p>
							<p class="submit_button">
								<input name="url-submit" title="Submit for validation" type="submit" value="Check" />
							</p>
						</form>
					</fieldset>
					
					<!-- Validate by File Upload tab -->
					<fieldset id="validate-by-upload"  class="tabset_content front" style="display: none;">
						<legend class="tabset_label">Validate by File Upload</legend>
						<form id="fileupload" method="post" enctype="multipart/form-data" action="fileUpload.php">
							<p class="instructions">Upload a document for validation:</p>
							<p>
								<label title="Choose a Local File to Upload and Validate" for="uploaded_file">File:</label>
								<input type="file" id="uploaded_file" name="uploaded_file" size="30" />
							</p>
							<p class="submit_button">
								<input name="file-submit" title="Submit for validation" type="submit" value="Check" />
							</p>
						</form>
					</fieldset>
					
					<!-- Validate by Zip tab-->
					<fieldset id="validate-by-zip"  class="tabset_content front" style="display: none;">
					<legend class="tabset_label">Upload a .zip file</legend>
						<form id="uploadzip" method="post" enctype="multipart/form-data" action="fileUpload.php">
							<p class="instructions">Upload a .zip file containing a website for validation:</p>
							<p>
								<label title="Choose a Local File to Upload" for="uploaded_zip">File:</label>
								<input type="file" id="uploaded_file" name="uploaded_file" size="30" />
							</p>
							<p class="submit_button">
								<input name="zip-submit" title="Submit for validation" type="submit" value="Check" />
							</p>
						</form>
					</fieldset>
					
					<!-- Validate by input tab-->
					<fieldset id="validate-by-input"  class="tabset_content front" style="display: none;">
					<legend class="tabset_label">Validate by direct input</legend>
						<form id="directinput" method="post" enctype="multipart/form-data" action="fileUpload.php">
							<p class="instructions"><label title="Paste a complete (HTML) Document here" for="fragment">Enter the Markup to validate</label>:<br />

								<textarea id="fragment" name="fragment" rows="12" cols="80"></textarea>
								
							</p>
							<p class="submit_button">
								<input name="direct-submit" title="Submit for validation" type="submit" value="Check" />
							</p>
						</form>
					</fieldset>	
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
