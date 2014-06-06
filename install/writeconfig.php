<h2>Installing AERO generator</h2>
<div class="aeroInstallPane"><?php

// Give yourself write permissions

chmod ($_POST['abs_path'], 777);

// delete config.php

if ( file_exists ( $_POST['abs_path'] . "config.php" ) ) {

	unlink ( $_POST['abs_path'] . "config.php" );

}

// delete config.js

if ( file_exists ( $_POST['abs_path'] . "js/config.js" ) ) {

	unlink ( $_POST['abs_path'] . "js/config.js" );

}

// write new config.php

$configphp = array ();

array_push ( $configphp, "<?php\n" );
array_push ( $configphp, "\n" );
array_push ( $configphp, "define('DB_USER', '" . $_POST['dbusername'] . "');\n" );
array_push ( $configphp, "define('DB_PASS', '" . $_POST['dbpassword'] . "');\n" );
array_push ( $configphp, "define('DB_NAME', '" . $_POST['dbname'] . "');\n" );
array_push ( $configphp, "define('DB_HOST', '" . $_POST['dbhost'] . "');\n" );
array_push ( $configphp, "define('ABS_PATH', '" . $_POST['abs_path'] . "');\n" );
array_push ( $configphp, "define('SITE_URL', '" . $_POST['site_url'] . "');\n" );
array_push ( $configphp, "\n" );
array_push ( $configphp, "include_once (ABS_PATH . \"functions.php\");\n" );
array_push ( $configphp, "\n" );
array_push ( $configphp, "?>" );

// write new config.js

$configjs = array ();

array_push ( $configjs, "var aerourl = '" . $_POST['site_url'] . "';" );

if ( file_put_contents ( $_POST['abs_path'] . "config.php", $configphp ) && file_put_contents ( $_POST['abs_path'] . "/js/config.js", $configjs ) ) {

	?><p>Configuration files written &#x2713;</p><?php

}

include_once ( $_POST['abs_path'] . 'config.php');

// add new blank aero database schema

if (areo_make_new_nodes_table () ) { // This function is defined in the
	// /functions.php file.
	// If you need to make changes to the schema of the nodes table, that is
	// the place to do it.

	?><p>Nodes table created</p><?php

}

// delete the installer files and directory

unlink ( $_POST['abs_path'] . "install/install.php");
unlink ( $_POST['abs_path'] . "install/testmysql.php");
unlink ( $_POST['abs_path'] . "install/writeconfig.php");

if ( rmdir ( $_POST['abs_path'] . "install/") ) {

	?><p>Installation directory deleted &#x2713;</p><?php

}

?></div>
<p>AERO generator has been installed! You may now <a href="<?php echo $_POST['site_url']; ?>">start generating AERO diagrams</a>.</p>
