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

} else { // There is no upload error

     include ( ABS_PATH . "header.php" );

     if ( ! is_dir ( ABS_PATH . "tmp/" ) ) { // If there is no tmp directory

		mkdir ( ABS_PATH . "tmp/", 0777 ); // Make one

	} else { // If there is a tmp directory

		chmod ( ABS_PATH . "tmp/", 0777 ); // Make it writeable

	}

     // Then, copy the uploaded file to the tmp directory

     move_uploaded_file ( $_FILES["file"]["tmp_name"], ABS_PATH . "tmp/tmp.txt" );

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

               // At this point, you have two arrays:

               // 1. $columns is an array that contains all the column headings
               // as specified by the user in the first row of the uploaded
               // tab-delimited text file

               // 2. $lines is an array that contains all the nodes to be
               // included in the new AERO diagram, with its

               // You'll need to check that all the required columns are there

               // Then you'll need to insert them all into the database

               // Then you'll need to work on /edit/nodestable.php so that
               // it gives us a nice editor.

               include ( ABS_PATH . "nodestable.php");



          }

     }

}

?>
