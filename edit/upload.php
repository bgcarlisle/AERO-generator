<?php

if ($_FILES["file"]["error"] > 0) { // There's an upload error

     if ($_FILES["file"]["error"] == 4) { // No file selected

          $errorText = "No file selected";

          include ( ABS_PATH . "header.php" );
          include ( ABS_PATH . "error.php" );

     } else {

          $errorText = "Upload error";

          include ( ABS_PATH . "header.php" );
          include ( ABS_PATH . "error.php" );

     }

     echo "Upload error: " . $_FILES["file"]["error"];

} else { // There is no upload error

     include ( ABS_PATH . "header.php" );

     ?><div class="aeroCentredColumn aeroWelcomePane"><?php

     if ( ! is_dir ( ABS_PATH . "tmp/" ) ) { // If there is no tmp directory

          mkdir ( ABS_PATH . "tmp/", 0777 ); // Make one

     } else { // If there is a tmp directory

          chmod ( ABS_PATH . "tmp/", 0777 ); // Make it writeable

     }

     // Then, copy the uploaded file to the tmp directory

     if (move_uploaded_file ( $_FILES["file"]["tmp_name"], ABS_PATH . "tmp/tmp.txt" )) {

          ?><h2>File uploaded</h2><?php

     }

     $file = fopen ( ABS_PATH . "tmp/tmp.txt", "r" );

     if ( ! $file ) {

          $errorText = "Error opening file";

          include ( ABS_PATH . "error.php" );

     } else {

          $filesize = filesize ( ABS_PATH . "tmp/tmp.txt" );

          if ( ! $filesize ) {

               $errorText = "File is empty: " . $filesize;

               include ( ABS_PATH . "error.php" );

          } else {

               $filecontent = fread ( $file, $filesize );

               fclose ( $file );

               $counter = 0;

               $lines = array ();

               foreach ( explode ( "\r", $filecontent ) as $line ) {

                    $lines[$counter] = $line;

                    $counter++;

               }

               $columns = explode ("\t", $lines[0]);

               unset ($lines[0]);

               // check that all the columns are present and unique
               // then make an array that maps column names to indexes

               $column_indices = array ();

               $all_cols_present = TRUE;

               ?><p>Parsing uploaded file</p><?php

               if ( ! in_array ( "id", $columns ) ) {

                    echo "<p>No 'id' column specified</p>";

                    $all_cols_present = FALSE;

               } else {

                    $keys = array_keys ( $columns, "id", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'id' columns</p>";

                    } else {

                         $column_indices['id'] = $keys[0];

                    }

               }

               if ( ! in_array ( "label", $columns ) ) {

                    echo "<p>No 'label' column specified</p>";

                    $all_cols_present = FALSE;

               } else {

                    $keys = array_keys ( $columns, "label", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'label' columns</p>";

                    } else {

                         $column_indices['label'] = $keys[0];

                    }

               }

               if ( ! in_array ( "year", $columns ) ) {

                    echo "<p>No 'year' column specified</p>";

                    $all_cols_present = FALSE;

               } else {

                    $keys = array_keys ( $columns, "year", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'year' columns</p>";

                    } else {

                         $column_indices['year'] = $keys[0];

                    }

               }

               if ( ! in_array ( "colour", $columns ) ) {

                    echo "<p>No 'colour' column specified</p>";

                    $all_cols_present = FALSE;

               } else {

                    $keys = array_keys ( $columns, "colour", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'colour' columns</p>";

                    } else {

                         $column_indices['colour'] = $keys[0];

                    }

               }

               if ( ! in_array ( "shape", $columns ) ) {

                    echo "<p>No 'shape' column specified</p>";

                    $all_cols_present = FALSE;

               } else {

                    $keys = array_keys ( $columns, "shape", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'shape' columns</p>";

                    } else {

                         $column_indices['shape'] = $keys[0];

                    }

               }

               if ( ! in_array ( "size", $columns ) ) {

                    echo "<p>No 'size' column specified</p>";

                    $all_cols_present = FALSE;

               } else {

                    $keys = array_keys ( $columns, "size", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'size' columns</p>";

                    } else {

                         $column_indices['size'] = $keys[0];

                    }

               }

               if ( ! in_array ( "border", $columns ) ) {

                    echo "<p>No 'border' column specified</p>";

                    $all_cols_present = FALSE;

               } else {

                    $keys = array_keys ( $columns, "border", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'border' columns</p>";

                    } else {

                         $column_indices['border'] = $keys[0];

                    }

               }

               if ( ! in_array ( "row", $columns ) ) {

                    echo "<p>No 'row' column specified</p>";

                    $all_cols_present = FALSE;

               } else {

                    $keys = array_keys ( $columns, "row", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'row' columns</p>";

                    } else {

                         $column_indices['row'] = $keys[0];

                    }

               }

               if ( ! in_array ( "x_offset", $columns ) ) {

                    echo "<p>No 'x_offset' column specified (this is okay; this column is optional)</p>";

               } else {

                    $keys = array_keys ( $columns, "x_offset", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'x-offset' columns</p>";

                    } else {

                         $column_indices['x_offset'] = $keys[0];

                    }

               }

               if ( ! in_array ( "y_offset", $columns ) ) {

                    echo "<p>No 'y_offset' column specified (this is okay; this column is optional)</p>";

               } else {

                    $keys = array_keys ( $columns, "y_offset", TRUE );

                    if ( count ($keys) > 1 ) {

                         echo "<p>Multiple 'y-offset' columns</p>";

                    } else {

                         $column_indices['y_offset'] = $keys[0];

                    }

               }

               if ( $all_cols_present ) {

                    ?><p>All necessary columns present in uploaded file</p><?php

                    // make a new diagram

                    $diagram_id = aero_insert_new_diagram ( $_POST['stratification_label'] );

                    // insert rows and nodes into that diagram

                    foreach ( $lines as $line ) {

                         $node = explode ( "\t", $line );

                         $row_id = aero_insert_row ( $diagram_id, $node[$column_indices['row']] );

                         echo $row_id;

                         aero_insert_node ( $row_id, $node[$column_indices['id']], $node[$column_indices['label']], $node[$column_indices['year']], $node[$column_indices['colour']], $node[$column_indices['shape']], $node[$column_indices['size']], $node[$column_indices['border']] );

                    }

                    // give link to the thing

                    ?><p><a href="<?php echo SITE_URL; ?>edit/?id=<?php echo $diagram_id; ?>">You may now edit your diagram</a> or <a href="<?php echo SITE_URL; ?>">start a new one</a></p><?php

               } else {

                    ?><p>Some columns were missing, so we were unable to generate an AERO diagram</p><?php

               }

          }

     }

}

?></div>
