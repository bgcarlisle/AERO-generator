<?php

include_once ('../config.php');

aero_move_row ( $_POST['rowid'], $_POST['direction'] );

$row = aero_get_row ( $_POST['rowid'] );

$diagram = aero_get_diagram ( $row['diagram_id'] );

$rows = aero_get_rows ( $row['diagram_id'] );

include ( ABS_PATH . 'edit/editortable.php');

?>
