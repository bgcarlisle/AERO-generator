<?php

$diagram = aero_get_diagram ( $_GET['id'] );

$rows = aero_get_rows ( $_GET['id'] );

?><div style="float: right; font-size: 12px; margin-right: 5%;">
     <a href="<?php echo SITE_URL; ?>">Start a new AERO diagram</a>
</div>
<div class="aeroDiagramEdit">
     <h2>Diagram editor</h2>
     <p>Stratification label:</p>
     <input type="text" value="<?php echo $diagram['stratification_label']; ?>" id="aeroDiagramStratLabel" onblur="aeroUpdateDiagram(<?php echo $diagram['id'] ?>, 'stratification_label', 'aeroDiagramStratLabel');">
</div>
<div id="aeroEditorTableContainer"><?php

     include ('editortable.php');

?></div>

<button style="margin-left: 5%;">Generate AERO diagram</button>
