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
