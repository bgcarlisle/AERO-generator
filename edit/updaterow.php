<?php

include_once ( '../config.php' );

if ( aero_update_row ( $_POST['rowid'], $_POST['column'], $_POST['value'] ) ) {

     echo "1";

} else {

     echo "Row not updated";

}

?>
