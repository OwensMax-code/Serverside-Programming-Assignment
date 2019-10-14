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
?>
