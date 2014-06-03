<?php

// I'm prefixing all the functions here with "aero_" to ensure that there's no
// problems with namespace

function areo_make_new_nodes_table () {

     try {

		$dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

		$stmt = $dbh->prepare("DROP TABLE IF EXISTS `aero_nodes`; CREATE TABLE `aero_nodes` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `diagram_id` int(11) DEFAULT NULL, `label` varchar(100) DEFAULT NULL, `year` int(11) DEFAULT NULL, `colour` varchar(6) DEFAULT NULL, `shape` varchar(50) DEFAULT NULL, `size` varchar(50) DEFAULT NULL, `border` varchar(50) DEFAULT NULL, `row` varchar(100) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

		if ($stmt->execute()) {

               return TRUE;

          } else {

               return FALSE;

          }

	}

	catch (PDOException $e) {

		echo $e->getMessage();

	}

}

function aero_insert_new_node ( $diagram_id, $label, $year, $colour, $shape, $size, $border, $row ) {

     // Here's an example of a parameterised database insertion

     // This function returns TRUE if the statement is executed successfully
     // and FALSE otherwise

     try {

		$dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$stmt = $dbh->prepare("INSERT INTO `aero_nodes` (`diagram_id`, `label`, `year`, `colour`, `shape`, `size`, `border`, `row`) VALUES (:diagram_id, :label, :year, :colour, :shape, :size, :border, :row);");

          // Note that you must bind these parameters in the query to variables
          // that haven't been used yet

		$stmt->bindParam(':diagram_id', $did);
		$stmt->bindParam(':label', $lab);
		$stmt->bindParam(':year', $yea);
          $stmt->bindParam(':colour', $col);
          $stmt->bindParam(':shape', $sha);
          $stmt->bindParam(':size', $siz);
          $stmt->bindParam(':border', $bor);
          $stmt->bindParam(':row', $ro);

          // Then, after, you can set them equal to the values specified by the
          // function's arguments

          $did = $diagram_id;
          $lab = $label;
          $yea = $year;
          $col = $colour;
          $sha = $shape;
          $siz = $size;
          $bor = $border;
          $ro = $row;

		if ( $stmt->execute() ) {

			return TRUE;

		} else {

               return FALSE;

          }

	}

	catch (PDOException $e) {

		echo $e->getMessage();

	}

}

?>
