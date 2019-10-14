<html>
<body>
<?php
require_once 'MySQLDB.php' ;
include_once "MyFunctions.php";
include_once "db.php";

 
//---- Display The AccountDetails Table
$accountDetails = getAccountDetails($db);
echo '<h2>Accounts</h2>';
echo $accountDetails->size() . ' rows returned<br>';
echo ("<table border=1><tr><td>accountID</td><td>first Name</td><td>Last Name</td><td>Username</td><td>Password</td><td>Email Address</td><td>Date of Birth</td><td>Phone Number</td><td>Address 1</td><td>Address 2</td></tr>") ;
while ( $aRow = $accountDetails->fetch( ) )
{
	$outputLine = "<tr><td>$aRow[accountID]</td>";
	$outputLine .= "<td>$aRow[firstName]</td>";
	$outputLine .= "<td>$aRow[lastName]</td>";
	$outputLine .= "<td>$aRow[userName]</td>";
	$outputLine .= "<td>$aRow[userPassword]</td>";
	$outputLine .= "<td>$aRow[emailAddress]</td>";
	$outputLine .= "<td>$aRow[dateOfBirth]</td>";
	$outputLine .= "<td>$aRow[phoneNo]</td>";
	$outputLine .= "<td>$aRow[address1]</td>";
	$outputLine .= "<td>$aRow[address2]</td></tr>";
	echo $outputLine;
}
echo '</table>';

// display login tables
$Login = getLogins($db);
echo '<h2>Login Details</h2>';
echo $Login->size() . ' rows returned<br>';
echo ("<table border=1><tr><td>user Name</td><td>Password</td><td>Account ID</td></tr>") ;
while ( $aRow = $Login->fetch( ) )
{
	$outputLine = "<tr><td>$aRow[userName]</td>";
	$outputLine .= "<td>$aRow[userPassword]</td>";
	$outputLine .= "<td>$aRow[accountID]</td>";
	echo $outputLine;
}
echo '</table>';
?>