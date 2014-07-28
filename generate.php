<?php
include ( 'config.php' );

function aero_year($diagramID){
     $rows=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
     if (mysqli_connect_errno()) {// Check connection
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
     }
     $yearLabel=array();

     $result = mysqli_query($rows,"SELECT DISTINCT year FROM aero_nodes;");//to extract the values from aero_nodes to get number of rows

     while($row = mysqli_fetch_array($result)) {//turn this into a single statment.. alot easier.
          array_push($yearLabel, $row['year']);//creates array with all the years within.. have to rearrage by order
     }

     sort($yearLabel);//now it's in increasing order by year
     $increment = 33/(count($yearLabel)-1);
     $labelStart=5;//12 segments between 5 and 38 for 3cm increments always at y=1.85
     $border .="\n".'%% X Axis Labels'."\n".'\node ('.$yearLabel[0].') at ('.$labelStart.',1.85) {'.$yearLabel[0]."};\n";
     $xLabelPos=array();
     for ($i=1; $i<count($yearLabel); $i++){
          $labelStart +=$increment;//figure out hte fun arithmetic to make it nice n pretty....
          $border .='\node ('.$yearLabel[$i].') at ('.$labelStart.',1.85) {'.$yearLabel[$i]."};\n";
          $xLabelPos[$yearLabel[$i]]=$labelStart;
     }
     //generate array of x axis values per year...
     return $border;//or generate an associative array
}

function aero_rows($diagramID){//standard row size is 1.5 at the moment. User inputted Height multiples this by the value in "height"
     $rows=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
     if (mysqli_connect_errno()) {// Check connection
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
     }
     $rowHeight=array();
     $rowLabel=array();
     $rowOrder=array();
     $rowOrder2=array();//duplicate to sort for $rowLabel as well
     //write something to tie together...
     $result = mysqli_query($rows,"SELECT * FROM aero_rows WHERE diagram_id=".$diagramID.";");
     while($row = mysqli_fetch_array($result)) {
          array_push($rowHeight, $row['height']);
          array_push($rowLabel, $row['label']);
          array_push($rowOrder, $row['order']);
          array_push($rowOrder2, $row['order']);
     }

     array_multisort($rowOrder, $rowHeight);
     array_multisort($rowOrder2, $rowLabel);//now both the height and labels are in the same order as the row collumn

     $border="%%FirstBorderLine"."\n"."\draw [borderline] (1,3.5) -- (39.5,3.5);"."\n"."\draw [divider,black] (1,1.25) -- (39.5,1.25);\n";
     $borderStart= 1.25;//standardize to 1.5 cm increments. User can change height
     $yIncrement = 1.5;
     for ($i=0; $i<count($rowHeight); $i++){//draw out the borders for each indication, height
          $borderStart -=$yIncrement*$rowHeight[$i];
          $border .="\draw [divider] (1,". $borderStart . ") -- (39.5,".$borderStart . ");\n";
     }

     $labels= "\n"."%%Y Axis Labels\n";
     $labelStart= 2;
     //write a little bit to taek into account the order of the rows!
     for ($i=0; $i<count($rowLabel); $i++){//I need to do something about over writing it if #labelstart !=1..
          //also write in something to inser nodes write here
          if($rowHeight[$i]!=1){
               $labelPos=$labelStart-$yIncrement-(3/4)*($rowHeight[$i]-1);
               $labelStart -=$yIncrement*$rowHeight[$i];
               $labels .='\node ('.$rowLabel[$i].') at (2.5,'.$labelPos.') [text width=1.5cm, text badly centered] {'.$rowLabel[$i]."};\n";
          }
          else{
               $labelStart -=$yIncrement*$rowHeight[$i];
               $labels .='\node ('.$rowLabel[$i].') at (2.5,'.$labelStart.') [text width=1.5cm, text badly centered] {'.$rowLabel[$i]."};\n";
          }
     }

     $rows="\n".$border. $labels;
     return $rows;
}

function aero_drawNodes($diagramID){
     $rows=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
     if (mysqli_connect_errno()) {// Check connection
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
     }

     $result = mysqli_query($rows,"SELECT * FROM aero_rows WHERE diagram_id=".$diagramID.';');// now I have all the rows for a given id
     //for each row i want to get all the nodes associated with it.

     $allNodes="\n%%AERODIAGRAM NODES \n";

     foreach($result as $row){
          $allNodes.= "%%".$row['label']."\n";
          $nodes = aero_get_nodes ( $row['id'] );
          foreach ( $nodes as $node ) {
               $xPos=aero_nodeXPos($node['year'],$diagramID)+$node['x_offset'];
               $yPos=aero_nodeYPos($row['label'],$diagramID)+$node['y_offset'];
               if($node['shape']=="square"||$node['shape']=="rectangle"){
                    $allNodes.='\node at ('.$xPos.",".$yPos.") [draw,".$node['border'].
                    ",minimum height=".substr($node['size'],0,-3)."em,fill=".$node['colour']."!50] {".$node['label']."}; \n";
               }
               else{
                    $allNodes.='\node at ('.$xPos.",".$yPos.") [".$node['shape'].",draw,".$node['border'].
                    ",minimum height=".substr($node['size'],0,-3)."em,fill=".$node['colour']."!50] {".$node['label']."}; \n";
               }
                    //echo substr($string, 0, -3);
          }
     }
     return $allNodes;
}

function aero_nodeYPos($indication,$diagramID){
     $rows=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

     if (mysqli_connect_errno()) {// Check connection
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
     }

     $result = mysqli_query($rows,"SELECT * FROM aero_rows WHERE diagram_id=".$diagramID.';');
     $yPos;//based off of row
     $rowLabel=array();$rowHeight=array();$rowOrder=array();$rowOrder2=array();
     while($row = mysqli_fetch_array($result)) {
          array_push($rowLabel, $row['label']);array_push($rowHeight, $row['height']);array_push($rowOrder, $row['order']);array_push($rowOrder2, $row['order']);
     }
     array_multisort($rowOrder, $rowHeight);array_multisort($rowOrder2, $rowLabel);

     $labelStart= 2;
     $yIncrement = 1.5;
     for ($i=0; $i<count($rowLabel); $i++){
          if($rowHeight[$i]!=1){
               $labelPos=$labelStart-$yIncrement-(3/4)*($rowHeight[$i]-1);
               $labelStart -=$yIncrement*$rowHeight[$i];
               if($rowLabel[$i]==$indication){
                    $yPos=$labelPos;
                    return $yPos;
                    break;
               }
          }
          else{
               $labelStart -=$yIncrement*$rowHeight[$i];
               $labels .='\node ('.$rowLabel[$i].') at (2.5,'.$labelStart.') [text width=1.5cm, text badly centered] {'.$rowLabel[$i]."};\n";
               if($rowLabel[$i]==$indication){
                    $yPos=$labelStart;
                    return $yPos;
                    break;
               }
          }
     }
}

function aero_nodeXPos($year,$diagramID){
     $rows=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
     if (mysqli_connect_errno()) {// Check connection
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
     }
     $result = mysqli_query($rows,"SELECT DISTINCT year FROM aero_nodes;");//to extract the values from aero_nodes to get number of rows
     $yearLabel=array();
     while($row = mysqli_fetch_array($result)) {//turn this into a single statment.. alot easier.
          array_push($yearLabel, $row['year']);//creates array with all the years within.. have to rearrage by order
     }
     sort($yearLabel);//now it's in increasing order by year
     $increment = 33/(count($yearLabel)-1);
     $labelStart=5;
     if ($yearLabel[0]==$year){
          return $labelStart;
          break;
     }
     else{
          for ($i=1; $i<count($yearLabel); $i++){
               $labelStart +=$increment;//figure out hte fun arithmetic to make it nice n pretty....
               if($yearLabel[$i]==$year){
               return $labelStart;
               break;
               }
          }
     }
}

function aero_TeXGenerator($diagramID){//just call the TeX File by id.TeX
     //style/document settings of the TeX file
     $style="\documentclass[12pt]{article}\n\usepackage[table]{xcolor}\n\usepackage{amsmath}\n\usepackage[byname]{smartref}\n\usepackage{setspace}\n".
     "\usepackage[margin=1.5cm]{geometry}\n\usepackage{txfonts}\n\usepackage[]{natbib}\n".
     "\linespread{1}\n\usepackage{tikz}\n\usepackage{booktabs}\n\setlength{\heavyrulewidth}{0.1 em}\n\usetikzlibrary{positioning,shapes,shadows,arrows}\n".
     "%\setlength{\columnsep}{20pt}\n\begin{document}\n".'\thispagestyle{empty}'."\n"."\begin{figure}[] \centering\n".
     "%\begin{sideways}\n".
     '\footnotesize'."\n\begin{tikzpicture}[scale=.48]\n\n%%Styles\n".
     '\tikzstyle{edgy}=[-latex,line width=0.75pt]'."\n".'\tikzstyle{divider}=[-,line width=1pt,gray!50]'."\n".
     '\tikzstyle{borderline}=[-,line width=1.5pt]'."\n";

     $yAxisCat="\n".'%% Y axis label categories'."\n".'\node (phase) at (2.5,2.75) {\textbf{Indication}};'."\n".'\node (trials) at (21.5,2.75) {\textbf{Year}};'."\n";
     $end="\n".'\end{tikzpicture}'."\n".'\endcenter'."\n".'\end{figure}'."\n".'\end{document}'."\n".'%%';
     $LaTex.=$style.$yAxisCat.aero_year($diagramID).aero_rows($diagramID).aero_drawNodes($diagramID).$end;//string for the AERO

     $fileName="/aero-".$diagramID.".tex";
     $expfile = "tmp" . $fileName;
     $fh = fopen($expfile, 'w') or die("can't open file $expfile");
     fwrite($fh, $LaTex);
     fwrite($fh,"\n");
     fclose($fh);

}

$diagramID = $_POST['id'];

aero_TeXGenerator($diagramID);
