<?php
Class Verification
{
	
	public static function checkDuplicateTitle($db, $newTitle)
	{
		$isValid = false;
		$sql = "select COUNT(postID) as total from BlogPost where postTitle = '$newPostTitle'";
		$postCount = $db->query($sql);
		$n = $postCount->fetch();
		$result = (int)$n['total'];
		if ($result == 0) 
		{
			$isValid = true;
		}
		return $isValid;	
	}

	public static function verifyInformation($db, $newUserName, $newEmail)
	{
		$isValid = true;
		$sql = "select count(accountID) as total from AccountDetails where userName = '$newUserName' and emailAddress = '$newEmail'";
		$count = $db->query($sql);
		$n = $count->fetch();
		$result = (int)$n['total'];
		if ($result == 1)
		{
			$isValid = false;
		}
		return $isValid;
	}	
	
	public static function verifyPostOwnership ($db, $newUserName, $newPostID)
	{
		$isOwnPost = false;
		$sql = "select count(postID) as total from BlogPost where userName = '$newUserName' and postID = '$newPostID'";
		$postCount = $db->query($sql);
		$n = $postCount->fetch();
		$result = (int)$n['total'];
		if ($result != 0)
		{
			$isOwnPost = true;
		}
		return $isOwnPost;
	}
	
	public static function checkDuplicateUsername ()
	{
		$sql = "select count(userName) as total from Login where userName = '$theUserName'";
		$theUserName = $db->query($sql);
		$n = $theUserName->fetch();
		$count = (int)$n['total'];
		if ($count == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}
?>