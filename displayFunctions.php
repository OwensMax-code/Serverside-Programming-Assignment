<?php

function getUserProfile ($db, $theAccountID) {
	$sql = "select * from AccountDetails where accountID = '$theAccountID'";
	$account = $db->query($sql);
	while ($aRow = $account->fetch())
	{	
		$output = "<div class='col' style='background-color:#CDCDCD;'>
					<h4><small class='text-muted'>First Name:</small><br>$aRow[firstName]</h4><br>
					<h4><small class='text-muted'>Last Name:</small><br>$aRow[lastName]</h4><br>
					<h4><small class='text-muted'>Email Address:</small><br>$aRow[emailAddress]</h4></div>";
		$output .= "<div class='col' style='background-color:#D7D7D7;'>
					<h4><small class='text-muted'>Phone Number:</small><br>$aRow[phoneNo]</h4><br>
					<h4><small class='text-muted'>Address Line 1:</small><br>$aRow[address1]</h4><br>
					<h4><small class='text-muted'>Address Line 2:</small><br>$aRow[address2]</h4><br>";
	}
	return $output;
}
?>