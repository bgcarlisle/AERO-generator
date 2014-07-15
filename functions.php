<?php

// I'm prefixing all the functions here with "aero_" to ensure that there's no
// problems with namespace

function aero_make_new_nodes_table () {

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

function aero_insert_new_node($record){
     $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
     $result = $dbh->exec(sql_query($record));
     return $result;
}

function sql_query($record){
     $q = "INSERT INTO `aero_nodes`";
     $keys = array_keys($record);
     $vals = array_map(sql_value, array_values($record));
     $q .= " (" . join(",", $keys) . ") VALUES (" . join(",", $vals) . ");";
     return $q;
}

function sql_value($v) {
     if (is_string($v)) {
          return "'$v'";
     } else {
          return "$v";
     }
}

function aero_sqlToTex(){//extract all the data in our aero_nodes database and spits it all out to
     $nodes=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

     // Check connection
     if (mysqli_connect_errno()) {
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
     }

     $result = mysqli_query($nodes,"SELECT * FROM aero_nodes");


     $node=array();

     //create an array with everyvalue in it.. Will clean up
     while($row = mysqli_fetch_array($result)) {
       array_push($node, $row['id'], $row['diagram_id'],
                 $row['label'], $row['year'],
                 $row['colour'],$row['shape'],
                 $row['size'],$row['border'],
                 $row['row']);

     }

     implode(",", $node);

     mysqli_close($nodes);
     $texFile = fopen("teXfromPhp.tex", "w") or die("Unable to create new tex file!");
     fwrite($texFile,implode(",", $node));
     fclose($texFile);

}
