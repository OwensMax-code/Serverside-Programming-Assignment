<?php
$host = 'localhost' ;
  $dbUser = 'root' ;
  $dbPass = '' ;
  $dbName = 'sudoku' ;
  
 
$db = new MySQL( $host, $dbUser, $dbPass, $dbName ) ;
$db->selectDatabase();
?>
