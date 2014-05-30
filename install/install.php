<?php

if ($_SERVER["HTTPS"] == "on") {

	$aero_url = "https://" . $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

} else {

	$aero_url = "http://" . $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

}

?><!DOCTYPE html>
<html lang="en">

<head>

	<title>AERO generator</title>

	<!-- jQuery -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js">
	</script>
	<!-- / jQuery -->

	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Coda|Lato' rel='stylesheet' type='text/css'>
	<!-- / Google Fonts -->

	<!-- Numbat JS -->
	<script type="text/javascript">

		function aeroTestMySQLConnexion () {

			$.ajax ({
				url: '<?php echo $aero_url; ?>install/testmysql.php',
				type: 'post',
				data: {
					dbusername: $('#aeroDBusername').val(),
					dbpassword: $('#aeroDBpassword').val(),
					dbname: $('#aeroDBname').val(),
					dbhost: $('#aeroDBhost').val()
				},
				dataType: 'html'
			}).done ( function (html) {

				$('#aeroDBTestFeedback').html(html);

				if ( html == 'Successful connexion to MySQL database' ) {

					$('#aeroDBTestFeedback').removeClass('aeroFeedbackBad').addClass('aeroFeedbackGood');

				} else {

					$('#aeroDBTestFeedback').removeClass('aeroFeedbackGood').addClass('aeroFeedbackBad');

				}

				$('#aeroDBTestFeedback').slideDown( 500, function () {

					setTimeout ( function () {

						$('#aeroDBTestFeedback').slideUp(500);

					}, 3000 );

				});

			});

		}

		function aeroWriteConfig () {

			$.ajax ({
				url: '<?php echo $aero_url; ?>install/writeconfig.php',
				type: 'post',
				data: {
					dbusername: $('#aeroDBusername').val(),
					dbpassword: $('#aeroDBpassword').val(),
					dbname: $('#aeroDBname').val(),
					dbhost: $('#aeroDBhost').val(),
					abs_path: $('#aeroAbsPath').val(),
					site_url: $('#aeroSiteURL').val(),
					aero_projname: $('#aeroProjectName').val(),
					aero_username: $('#aeroUsername').val(),
					aero_password: $('#aeroPassword').val(),
					aero_email: $('#aeroEmail').val()
				},
				dataType: 'html'
			}).done ( function (html) {

				$('#aeroInstallPane').html(html);

			});

		}

	</script>
	<!-- / Signals JS -->

	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo $aero_url; ?>css/reset.css" />
	<link rel="stylesheet" href="<?php echo $aero_url; ?>css/aero.css" />
	<!-- / CSS -->

	<link rel="SHORTCUT ICON" href="<?php echo $aero_url; ?>images/favicon.ico"/>

</head>

<body>

<div id="aeroTopBanner">
	<h1>AERO generator</h1>
</div>
<div class="aeroCentredColumn" style="margin-bottom: 40px;">
	<h2>Install AERO generator</h2>
	<div class="aeroInstallPane">
		<h3>MySQL details</h3>
		<p class="aeroFinePrint">This installer will write over any previous installation.</p>
		<p>Database username</p>
		<input type="text" id="aeroDBusername">
		<p>Database password</p>
		<input type="text" id="aeroDBpassword">
		<p>Database name</p>
		<input type="text" id="aeroDBname">
		<p>Database host</p>
		<p class="aeroFinePrint">E.g. "localhost"</p>
		<input type="text" id="aeroDBhost">
		<button style="display: block; margin-top: 25px;" onclick="aeroTestMySQLConnexion();">Test database connexion</button>
		<p id="aeroDBTestFeedback" class="aeroFeedback aeroHidden aeroFinePrint">&nbsp;</p>
	</div>
	<div class="aeroInstallPane">
		<h3>Web space details</h3>
		<p class="aeroFinePrint">Should auto-detect correctly; change only if you know what you're doing.</p>
		<p>Absolute path to installation</p>
		<p class="aeroFinePrint">Include leading and trailing slashes; e.g. "/home/webspace/aero/"</p>
		<input id="aeroAbsPath" type="text" value="<?php

		echo substr (__DIR__, 0, strlen ( __DIR__ ) - 7);

		?>">
		<p>Site URL</p>
		<p class="aeroFinePrint">Include http:// at beginning and trailing slash; e.g. "http://www.website.com/aero/"</p>
		<input id="aeroSiteURL" type="text" value="<?php echo $aero_url; ?>">
	</div>
	<button onclick="aeroWriteConfig();">Install AERO generator</button>
</div>
<div id="aeroFooter">
	<p class="aeroFinePrint">The <a href="http://bgcarlisle.github.io/AERO-generator/">AERO generator</a> is free and open source software released under GPL v 2 and originally written by Benjamin Carlisle and Andrew Chung, <a href="http://www.translationalethics.com/">STREAM research group</a>, McGill University.</p>
</div>
</body>

</html>
