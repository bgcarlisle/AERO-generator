<table class="aeroEditor">
     <?php

     foreach ( $rows as $row ) {

          ?><tr class="aeroRow">
               <td><button onclick="aeroMoveRow(<?php echo $row['id']; ?>, 1);">&uarr;</button><button onclick="aeroMoveRow(<?php echo $row['id']; ?>, -1);">&darr;</button></td>
               <td>Row label: <input type="text" value="<?php echo $row['label'] ?>" id="aeroRowLabel<?php echo $row['id']; ?>" onblur="aeroUpdateRow(<?php echo $row['id']; ?>, 'label', 'aeroRowLabel<?php echo $row['id']; ?>');"></td>
               <td>Row height: <input type="text" value="<?php echo $row['height'] ?>" id="aeroRowHeight<?php echo $row['id']; ?>" onblur="aeroUpdateRow(<?php echo $row['id']; ?>, 'height', 'aeroRowHeight<?php echo $row['id']; ?>');"></td>
               <td style="text-align: right;"><button onclick="$(this).fadeOut(0);$('#aeroDeleteRow<?php echo $row['id']; ?>').fadeIn(500);">Delete</button><button id="aeroDeleteRow<?php echo $row['id']; ?>" style="display: none;" onclick="aeroDeleteRow(<?php echo $row['id']; ?>);">For real</button></td>
          </tr>
          <tr>
               <td colspan="4">

                    <table class="aeroNodes">

                         <tr>
                              <td>Node ID</td>
                              <td>Label</td>
                              <td>Year</td>
                              <td>Colour</td>
                              <td>Shape</td>
                              <td>Size</td>
                              <td>Border</td>
                              <td>X-offset</td>
                              <td>Y-offset</td>
                              <td style="width: 80px;">&nbsp;</td>
                         </tr>

                         <?php

                         $nodes = aero_get_nodes ( $row['id'] );

                         foreach ( $nodes as $node ) {

                              ?><tr>
                                   <td><input type="text" value="<?php echo $node['node_id']; ?>" id="aeroNodeID<?php echo $node['id']; ?>" onblur="aeroUpdateNode(<?php echo $node['id']; ?>, 'node_id', 'aeroNodeID<?php echo $node['id']; ?>');"></td>
                                   <td><input type="text" value="<?php echo $node['label']; ?>" id="aeroNodeLabel<?php echo $node['id']; ?>" onblur="aeroUpdateNode(<?php echo $node['id']; ?>, 'label', 'aeroNodeLabel<?php echo $node['id']; ?>');"></td>
                                   <td><input type="text" value="<?php echo $node['year']; ?>" id="aeroNodeYear<?php echo $node['id']; ?>" onblur="aeroUpdateNode(<?php echo $node['id']; ?>, 'year', 'aeroNodeYear<?php echo $node['id']; ?>');"></td>
                                   <td><input type="text" value="<?php echo $node['colour']; ?>" id="aeroNodeColour<?php echo $node['id']; ?>" onblur="aeroUpdateNode(<?php echo $node['id']; ?>, 'colour', 'aeroNodeColour<?php echo $node['id']; ?>');"></td>
                                   <td><input type="text" value="<?php echo $node['shape']; ?>" id="aeroNodeShape<?php echo $node['id']; ?>" onblur="aeroUpdateNode(<?php echo $node['id']; ?>, 'shape', 'aeroNodeShape<?php echo $node['id']; ?>');"></td>
                                   <td><input type="text" value="<?php echo $node['size']; ?>" id="aeroNodeSize<?php echo $node['id']; ?>" onblur="aeroUpdateNode(<?php echo $node['id']; ?>, 'size', 'aeroNodeSize<?php echo $node['id']; ?>');"></td>
                                   <td><input type="text" value="<?php echo $node['border']; ?>" id="aeroNodeBorder<?php echo $node['id']; ?>" onblur="aeroUpdateNode(<?php echo $node['id']; ?>, 'border', 'aeroNodeBorder<?php echo $node['id']; ?>');"></td>
                                   <td><input type="text" value="<?php echo $node['x_offset']; ?>" id="aeroNodeXoff<?php echo $node['id']; ?>" onblur="aeroUpdateNode(<?php echo $node['id']; ?>, 'x_offset', 'aeroNodeXoff<?php echo $node['id']; ?>');"></td>
                                   <td><input type="text" value="<?php echo $node['y_offset']; ?>" id="aeroNodeYoff<?php echo $node['id']; ?>" onblur="aeroUpdateNode(<?php echo $node['id']; ?>, 'y_offset', 'aeroNodeYoff<?php echo $node['id']; ?>');"></td>
                                   <td style="text-align: right;"><button onclick="$(this).fadeOut(0);$('#aeroDeleteNode<?php echo $node['id']; ?>').fadeIn(500);">Delete</button><button id="aeroDeleteNode<?php echo $node['id']; ?>" style="display: none;" onclick="aeroDeleteNode(<?php echo $node['id']; ?>);">For real</button></td>
                              </tr><?php

                         }

                         ?>

                    </table>

               </td>
          </tr><?php

     }

     ?>
</table>
