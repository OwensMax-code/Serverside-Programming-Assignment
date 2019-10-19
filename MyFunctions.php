<?php

//*********************************************************

function getAccountDetails($db)
 {
	$sql = "select * from AccountDetails order by accountID" ;
    $result = $db->query($sql);  
    return $result ;
}

//*********************************************************
function getLogins($db)
{
	$sql = "select * from Login order by userName" ;
    $result = $db->query($sql);  
    return $result ;
}

//*********************************************************
function getBlogPosts($db)
{
    
    $sql = "select * from BlogPost order by postID" ;
    $result = $db->query($sql);  
    return $result;
}

//*********************************************************
function getAccountId($db, $userName, $password)
{
	$sql = "select * from Login where userName = '$userName' and hash = '$password'";
	$account = $db->query($sql);
	$row = $account->fetch();
	$result = $row['accountID'];
	return $result;
	
}
//*********************************************************
function retrieveLogin($db, $userName)
{
	$sql = "select * from Login where userName = '$userName'";
	$hash = $db->query($sql);
	$row = $hash->fetch();
	$result = $row['hash'];
	return $result;
}
//*********************************************************
function retrieveUserName($db, $theAccountID)
{
	$sql = "select * from Login where accountID = '$theAccountID'";
	$theUserName = $db->query($sql);
	$row = $theUserName->fetch();
	$result = $row['userName'];
	return $result;
}
//*********************************************************
function verifyLogin($userName, $password)
{
	  $result = true;
   if ($userName =='')
   {
        $result = false;
        echo '<script language="javascript">';
		echo 'alert("Please enter a username")';
		echo '</script>';
   }    
   if ($password =='')
   {
        $result = false;
        echo '<script language="javascript">';
		echo 'alert("Please enter a password")';
		echo '</script>';
   }
    return $result;
}
?>
