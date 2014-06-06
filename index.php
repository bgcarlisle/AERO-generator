<?php

if ( ! file_exists ( __DIR__ . "/install/" ) ) {

	include_once ("./config.php");

	include ( ABS_PATH . "header.php" );

     include ( ABS_PATH . "welcome.php" );

	include ( ABS_PATH . "footer.php" );

} else {

	include ( "./install/install.php" );

}

?>
