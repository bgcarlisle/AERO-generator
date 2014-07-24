<?php

include_once ( '../config.php' );

if ( aero_update_node ( $_POST['node'], $_POST['column'], $_POST['value'] ) ) {

     echo "1";

} else {

     echo "Node not updated";

}

?>
