<?php

// I'm prefixing all the functions here with "aero_" to ensure that there's no
// problems with namespace

function aero_install_db () {

     // here is where the db schema goes

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
                    $previous_insert_row_id = $row['id'];

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

               return FALSE;

          }

     }

     catch (PDOException $e) {

          echo $e->getMessage();

     }

}

function aero_get_diagram ( $diagram_id ) {

}

function aero_get_rows ( $diagram_id ) {



}

function aero_get_nodes ( $row_id ) {

     
}

?>
