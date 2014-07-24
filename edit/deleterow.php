<?php

include_once ('../config.php');

$row = aero_get_row ( $_POST['rowid'] );

$diagram = aero_get_diagram ( $row['diagram_id'] );

aero_delete_row ( $_POST['rowid'] );

$rows = aero_get_rows ( $row['diagram_id'] );

include ( ABS_PATH . 'edit/editortable.php');

?>
