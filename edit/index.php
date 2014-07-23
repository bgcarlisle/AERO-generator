<?php

include_once ('../config.php');

if ( isset ( $_GET['id'] ) ) {

     include ( ABS_PATH . 'header.php' );

     include ('edit.php');

} else {

     if ( $_POST['action'] == "upload" ) {

          include ('upload.php');

     } else {

          $errorText = "Please specify a diagram id";

          include ( ABS_PATH . "header.php" );
          
          include ( ABS_PATH . "error.php" );

     }

}

include ( ABS_PATH . 'footer.php' );

?>
