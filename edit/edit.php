<?php

$diagram = aero_get_diagram ( $_GET['id'] );

$rows = aero_get_rows ( $_GET['id'] );

?><div style="margin: 0 5% 20px 5%;">
     <h2>Diagram editor</h2>
     <p>Stratification label:</p>
     <input type="text" value="<?php echo $diagram['stratification_label']; ?>">
</div>
<div id="aeroEditorTableContainer"><?php

     include ('editortable.php');

?></div>

<button style="margin-left: 5%;">Generate AERO diagram</button>
