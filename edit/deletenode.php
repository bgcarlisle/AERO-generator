<?php

include_once ('../config.php');

$node = aero_get_node ( $_POST['node'] );

$row = aero_get_row ( $node['row'] );

$diagram = aero_get_diagram ( $row['diagram_id'] );

$rows = aero_get_rows ( $row['diagram_id'] );

aero_delete_node ( $_POST['node'] );

include ( ABS_PATH . 'edit/editortable.php');

?>
