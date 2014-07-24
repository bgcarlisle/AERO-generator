<?php

include_once ( '../config.php' );

if ( aero_update_diagram ( $_POST['diagram'], $_POST['column'], $_POST['value'] ) ) {

     echo "1";

} else {

     echo "Diagram not updated";

}

?>
