<?php

$diagram = aero_get_diagram ( $_GET['id'] );

$rows = aero_get_rows ( $_GET['id'] );

?><div style="margin: 0 5% 20px 5%;">
     <h2>Diagram editor</h2>
     <p>Stratification label:</p>
     <input type="text" value="<?php echo $diagram['stratification_label']; ?>">
</div>
<table class="aeroEditor">
     <?php

     foreach ( $rows as $row ) {

          ?><tr class="aeroRow">
               <td>Row label: <input type="text" value="<?php echo $row['label'] ?>"></td>
               <td>Row height: <input type="text" value="<?php echo $row['height'] ?>"></td>
               <td style="text-align: right;"><button>&uarr;</button><button>&darr;</button></td>
          </tr>
          <tr>
               <td colspan="3">

                    <table class="aeroNodes">

                         <tr>
                              <td>Node ID</td>
                              <td>Label</td>
                              <td>Year</td>
                              <td>Colour</td>
                              <td>Shape</td>
                              <td>Size</td>
                              <td>Border</td>
                         </tr>

                         <?php

                         $nodes = aero_get_nodes ( $row['id'] );

                         foreach ( $nodes as $node ) {

                              ?><tr>
                                   <td><input type="text" value="<?php echo $node['node_id']; ?>"></td>
                                   <td><input type="text" value="<?php echo $node['label']; ?>"></td>
                                   <td><input type="text" value="<?php echo $node['year']; ?>"></td>
                                   <td><input type="text" value="<?php echo $node['colour']; ?>"></td>
                                   <td><input type="text" value="<?php echo $node['shape']; ?>"></td>
                                   <td><input type="text" value="<?php echo $node['size']; ?>"></td>
                                   <td><input type="text" value="<?php echo $node['border']; ?>"></td>
                              </tr><?php

                         }

                         ?>

                    </table>

               </td>
          </tr><?php

     }

     ?>
</table>

<button style="margin-left: 5%;">Generate AERO diagram</button>
