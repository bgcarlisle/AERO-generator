<?php

// I'm prefixing all the functions here with "aero_" to ensure that there's no
// problems with namespace

function aero_install_db () {

     try { // diagrams table

     	$dbh = new PDO('mysql:dbname=' . $_POST['dbname'] . ';host=' . $_POST['dbhost'], $_POST['dbusername'], $_POST['dbpassword'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
     	$stmt = $dbh->prepare("DROP TABLE IF EXISTS `aero_diagrams`; CREATE TABLE `aero_diagrams` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `stratification_label` varchar(50) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

     	if ( $stmt->execute() ) {

     		?><p>Diagrams table created &#x2713;</p><?php

     	} else {

     		?><p>Error making diagrams table</p><?php

     	}

     	$dbh = null;

     }

     catch (PDOException $e) {

     	echo $e->getMessage();

     }

     try { // rows table

          $dbh = new PDO('mysql:dbname=' . $_POST['dbname'] . ';host=' . $_POST['dbhost'], $_POST['dbusername'], $_POST['dbpassword'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("DROP TABLE IF EXISTS `aero_rows`; CREATE TABLE `aero_rows` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `diagram_id` int(11) DEFAULT NULL, `height` varchar(50) DEFAULT '1', `label` varchar(50) DEFAULT NULL, `order` int(11) DEFAULT NULL, PRIMARY KEY (`id`), UNIQUE KEY `diagram_id` (`diagram_id`,`label`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

          if ( $stmt->execute() ) {

               ?><p>Rows table created &#x2713;</p><?php

          } else {

               ?><p>Error making rows table</p><?php

          }

          $dbh = null;

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

     try { // nodes table

          $dbh = new PDO('mysql:dbname=' . $_POST['dbname'] . ';host=' . $_POST['dbhost'], $_POST['dbusername'], $_POST['dbpassword'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("DROP TABLE IF EXISTS `aero_nodes`; CREATE TABLE `aero_nodes` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `row` varchar(100) DEFAULT NULL, `node_id` varchar(10) DEFAULT NULL, `label` varchar(100) DEFAULT NULL, `year` int(11) DEFAULT NULL, `colour` varchar(6) DEFAULT NULL, `shape` varchar(50) DEFAULT NULL, `size` varchar(50) DEFAULT NULL, `border` varchar(50) DEFAULT NULL, `x_offset` varchar(10) DEFAULT NULL, `y_offset` varchar(10) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

          if ( $stmt->execute() ) {

               ?><p>Nodes table created &#x2713;</p><?php

          } else {

               ?><p>Nodes making rows table</p><?php

          }

          $dbh = null;

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_insert_new_diagram ( $label ) {

     try {

		$dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$stmt = $dbh->prepare ("INSERT INTO `aero_diagrams` (`stratification_label`) VALUES (:label)");

		$stmt->bindParam(':label', $lab);

		$lab = $label;

		if ( $stmt->execute() ) {

               echo "<h2>New diagram started</h2>";

               $stmt2 = $dbh->prepare("SELECT LAST_INSERT_ID() AS newid;");
     		$stmt2->execute();

     		$result = $stmt2->fetchAll();

     		$dbh = null;

     		foreach ( $result as $row ) {

     			$newid = $row['newid'];

     		}

			$dbh = null;

			return $newid;

		} else {

               return FALSE;

          }

	}

	catch (PDOException $e) {

		echo $e->getMessage();

	}

}

function aero_insert_row ( $diagram_id, $newlabel ) {

     // get the previous highest order for this diagram id

     try {

		$dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$stmt = $dbh->prepare("SELECT * FROM `aero_rows` WHERE `diagram_id` = :did ORDER BY `order` DESC LIMIT 1;");

		$stmt->bindParam(':did', $did);

		$did = $diagram_id;

		if ($stmt->execute()) {

			$result = $stmt->fetchAll();

			$dbh = null;

			foreach ( $result as $row ) {

				$highestorder = $row['order'];

			}

		} else {

			echo "MySQL fail";

		}


	}

	catch (PDOException $e) {

		echo $e->getMessage();

	}

     // then try to insert one

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare ("INSERT INTO `aero_rows` (`diagram_id`, `label`, `order`) VALUES (:did, :label, :order)");

          $stmt->bindParam(':did', $did2);
          $stmt->bindParam(':label', $lab);
          $stmt->bindParam(':order', $ord);

          $did2 = $diagram_id;
          $lab = $newlabel;
          $ord = $highestorder + 1;

          if ( $stmt->execute() ) {

               echo "<p>New row inserted: " . $newlabel . "</p>";

               $stmt2 = $dbh->prepare("SELECT LAST_INSERT_ID() AS newid;");
               $stmt2->execute();

               $result = $stmt2->fetchAll();

               $dbh = null;

               foreach ( $result as $row ) {

                    $newid = $row['newid'];

               }

               $dbh = null;

               return $newid;

          } else {

               try {

                    $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                    $stmt = $dbh->prepare("SELECT * FROM `aero_rows` WHERE `label` = :lab AND `diagram_id` = :did LIMIT 1;");

                    $stmt->bindParam(':lab', $lab2);
                    $stmt->bindParam(':did', $did2);

                    $lab2 = $newlabel;
                    $did2 = $diagram_id;

                    if ($stmt->execute()) {

                         $result = $stmt->fetchAll();

                         $dbh = null;

                         foreach ( $result as $row ) {

                              $previous_insert_row_id = $row['id'];

                         }

                    } else {

                         echo "MySQL fail";

                    }


               }

               catch (PDOException $e) {

                    echo $e->getMessage();

               }

               return $previous_insert_row_id;

          }

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_insert_node ( $row, $node_id, $label, $year, $colour, $shape, $size, $border ) {

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare ("INSERT INTO `aero_nodes` (`row`, `node_id`, `label`, `year`, `colour`, `shape`, `size`, `border`) VALUES (:row, :node, :label, :year, :colour, :shape, :size, :border)");

          $stmt->bindParam(':row', $ro);
          $stmt->bindParam(':node', $nid);
          $stmt->bindParam(':label', $lab);
          $stmt->bindParam(':year', $yea);
          $stmt->bindParam(':colour', $col);
          $stmt->bindParam(':shape', $sha);
          $stmt->bindParam(':size', $siz);
          $stmt->bindParam(':border', $bor);

          $ro = $row;
          $nid = $node_id;
          $lab = $label;
          $yea = $year;
          $col = $colour;
          $sha = $shape;
          $siz = $size;
          $bor = $border;

          if ( $stmt->execute() ) {

               echo "<p>New node inserted: " . $node_id . "</p>";

               return TRUE;

          } else {

               echo "<p>Node not inserted: " . $node_id . "</p>";

               return FALSE;

          }

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_get_diagram ( $diagram_id ) {

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("SELECT * FROM `aero_diagrams` WHERE `id` = :did;");

          $stmt->bindParam(':did', $did);

          $did = $diagram_id;

          if ($stmt->execute()) {

               $result = $stmt->fetchAll();

               $dbh = null;

               return $result[0];

          } else {

               echo "MySQL fail";

               return FALSE;

          }


     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_get_rows ( $diagram_id ) {

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("SELECT * FROM `aero_rows` WHERE `diagram_id` = :did ORDER BY `order` ASC;");

          $stmt->bindParam(':did', $did);

          $did = $diagram_id;

          if ($stmt->execute()) {

               $result = $stmt->fetchAll();

               $dbh = null;

               return $result;

          } else {

               echo "MySQL fail";

               return FALSE;

          }


     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_get_row ( $row_id ) {

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("SELECT * FROM `aero_rows` WHERE `id` = :rid LIMIT 1;");

          $stmt->bindParam(':rid', $rid);

          $rid = $row_id;

          if ($stmt->execute()) {

               $result = $stmt->fetchAll();

               $dbh = null;

               return $result[0];

          } else {

               echo "MySQL fail";

               return FALSE;

          }


     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_get_nodes ( $row_id ) {

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("SELECT * FROM `aero_nodes` WHERE `row` = :rid;");

          $stmt->bindParam(':rid', $rid);

          $rid = $row_id;

          if ($stmt->execute()) {

               $result = $stmt->fetchAll();

               $dbh = null;

               return $result;

          } else {

               echo "MySQL fail";

               return FALSE;

          }


     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_get_node ( $node_id ) {

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("SELECT * FROM `aero_nodes` WHERE `id` = :nid LIMIT 1;");

          $stmt->bindParam(':nid', $nid);

          $nid = $node_id;

          if ($stmt->execute()) {

               $result = $stmt->fetchAll();

               $dbh = null;

               foreach ($result as $row) {

                    return $row;

               }

          } else {

               echo "MySQL fail";

               return FALSE;

          }


     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_update_node ( $node, $column, $value ) {

     $columns = array ( "row", "node_id", "label", "year", "colour", "shape", "size", "border", "x_offset", "y_offset" );

     if ( in_array ( $column, $columns, TRUE ) ) {

          try {

     		$dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
     		$stmt = $dbh->prepare("UPDATE `aero_nodes` SET `" . $column . "`=:value WHERE `id` = :nid");

     		$stmt->bindParam(':nid', $nid);
     		$stmt->bindParam(':value', $val);

     		$nid = $node;
     		$val = $value;

     		if ($stmt->execute()) {

                    $dbh = null;

     			return TRUE;

     		} else {

                    $dbh = null;

                    return FALSE;

               }

     	}

     	catch (PDOException $e) {

     		echo $e->getMessage();

     	}

     }

}

function aero_update_row ( $rowid, $column, $value ) {

     $columns = array ( "height", "label" );

     if ( in_array ( $column, $columns, TRUE ) ) {

          try {

               $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
               $stmt = $dbh->prepare("UPDATE `aero_rows` SET `" . $column . "`=:value WHERE `id` = :rid");

               $stmt->bindParam(':rid', $rid);
               $stmt->bindParam(':value', $val);

               $rid = $rowid;
               $val = $value;

               if ($stmt->execute()) {

                    $dbh = null;

                    return TRUE;

               } else {

                    $dbh = null;

                    return FALSE;

               }

          }

          catch (PDOException $e) {

               echo $e->getMessage();

          }

     }

}

function aero_update_diagram ( $diagram, $column, $value ) {

     $columns = array ( "stratification_label" );

     if ( in_array ( $column, $columns, TRUE ) ) {

          try {

               $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
               $stmt = $dbh->prepare("UPDATE `aero_diagrams` SET `" . $column . "`=:value WHERE `id` = :did");

               $stmt->bindParam(':did', $did);
               $stmt->bindParam(':value', $val);

               $did = $diagram;
               $val = $value;

               if ($stmt->execute()) {

                    $dbh = null;

                    return TRUE;

               } else {

                    $dbh = null;

                    return FALSE;

               }

          }

          catch (PDOException $e) {

               echo $e->getMessage();

          }

     }

}

function aero_switch_row_order ( $rowid1, $rowid2 ) {

     $row1 = aero_get_row ( $rowid1 );
     $row2 = aero_get_row ( $rowid2 );

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("UPDATE `aero_rows` SET `order`=:order WHERE `id` = :rid");

          $stmt->bindParam(':rid', $rid);
          $stmt->bindParam(':order', $ord1);

          $rid = $row1['id'];
          $ord1 = $row2['order'];

          $stmt->execute();

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("UPDATE `aero_rows` SET `order`=:order WHERE `id` = :rid");

          $stmt->bindParam(':rid', $rid);
          $stmt->bindParam(':order', $ord2);

          $rid = $rowid2;
          $ord2 = $row1['order'];

          $stmt->execute();

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_move_row ( $rowid, $direction ) {

     $row = aero_get_row ( $rowid );

     $diagram = $row['diagram_id'];

     $current_order = $row['order'];

     if ( $direction == 1 ) { // moving "up"

          // see if there are any elements above it

          try {

			$dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$stmt = $dbh->prepare("SELECT * FROM `aero_rows` WHERE `diagram_id` = :did AND `order` < :order ORDER BY `order` DESC LIMIT 1;");

			$stmt->bindParam(':order', $ord);
			$stmt->bindParam(':did', $did);

			$ord = $current_order;
			$did = $diagram;

			$stmt->execute();

			$result = $stmt->fetchAll();

			if ( count ( $result ) == 0 ) {

				$moveup = FALSE;

			} else { // there are elements higher than this one

				foreach ( $result as $row ) {

					$moveup = $row['id'];

				}

			}

		}

		catch (PDOException $e) {

			echo $e->getMessage();

		}

          // move the element up, if necessary

          if ( $moveup ) {

               aero_switch_row_order ($rowid, $moveup);

          }

     } else { // moving "down"

          // see if there are any elements above it

          try {

               $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
               $stmt = $dbh->prepare("SELECT * FROM `aero_rows` WHERE `diagram_id` = :did AND `order` > :order ORDER BY `order` ASC LIMIT 1;");

               $stmt->bindParam(':order', $ord);
               $stmt->bindParam(':did', $did);

               $ord = $current_order;
               $did = $diagram;

               $stmt->execute();

               $result = $stmt->fetchAll();

               if ( count ( $result ) == 0 ) {

                    $movedown = FALSE;

               } else { // there are elements higher than this one

                    foreach ( $result as $row ) {

                         $movedown = $row['id'];

                    }

               }

          }

          catch (PDOException $e) {

               echo $e->getMessage();

          }

          // move the element up, if necessary

          if ( $movedown ) {

               aero_switch_row_order ($rowid, $movedown);

          }

     }

}

function aero_delete_node ( $node ) {

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("DELETE FROM `aero_nodes` WHERE `id` = :nid LIMIT 1;");

          $stmt->bindParam(':nid', $nid);

          $nid = $node;

          $stmt->execute();

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_delete_row ( $rowid ) {

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("DELETE FROM `aero_nodes` WHERE `row` = :rid;");

          $stmt->bindParam(':rid', $rid);

          $rid = $rowid;

          $stmt->execute();

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

     try {

          $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          $stmt = $dbh->prepare("DELETE FROM `aero_rows` WHERE `id` = :rid LIMIT 1;");

          $stmt->bindParam(':rid', $rid2);

          $rid2 = $rowid;

          $stmt->execute();

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_typeset ( $filename ) {

     exec ( 'latex ' . ABS_PATH . 'tmp/' . $filename );

}

?>
