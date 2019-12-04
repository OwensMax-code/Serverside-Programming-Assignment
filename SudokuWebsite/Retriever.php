<?php
Class Retriever 
{
	
	public static function getBlogCommentCount($db, $thePostID)
	{
	$sql = "SELECT COUNT(commentID) AS total FROM BlogComment WHERE postID = '$thePostID'";
	$commentCount = $db->query($sql);  
	$n = $commentCount->fetch();
	$result = (int)$n['total'];
    return $result;
	}
	
	public static function getBlogPostLikes($db, $thePostID)
	{
	$sql = "SELECT COUNT(likeID) as total FROM PostLikes WHERE postID = '$thePostID'";
	$likeCount = $db->query($sql);
	$n = $likeCount->fetch();
	$result = (int)$n['total'];
	return $result;
	}
	
	public static function getBlogPostDislikes($db, $thePostID)
	{
	$sql = "SELECT COUNT(dislikeID) as total FROM PostDislikes WHERE postID = '$thePostID'";
	$dislikeCount = $db->query($sql);
	$n = $dislikeCount->fetch();
	$result = (int)$n['total'];	
	return $result;
	}
	
	public static function getAccountId($db, $userName, $password)
	{
	$sql = "select * from Login where userName = '$userName' and hash = '$password'";
	$account = $db->query($sql);
	$row = $account->fetch();
	$result = $row['accountID'];
	return $result;	
	}
	
	public static function retrieveLogin($db, $userName)
	{
	$sql = "select * from Login where userName = '$userName'";
	$hash = $db->query($sql);
	$row = $hash->fetch();
	$result = $row['hash'];
	return $result;
	}
	
	public static function retrieveUserName($db, $theAccountID)
	{
	$sql = "select * from Login where accountID = '$theAccountID'";
	$theUserName = $db->query($sql);
	$row = $theUserName->fetch();
	$result = $row['userName'];
	return $result;
	}

}
?>