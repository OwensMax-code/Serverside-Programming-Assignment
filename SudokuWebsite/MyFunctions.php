<?php
//*********************************************************
function addBlogPost($db, $newPostTitle, $newPostContent, $newUserName) 
{
	$thePostTitle = sanitiseText($db, $newPostTitle);
	$thePostContent = sanitiseText($db, $newPostContent);
	$sql = "insert into BlogPost values (null,'$thePostTitle','$thePostContent',CURDATE(),'$newUserName')";
	$db->query($sql);
}
//*********************************************************
function editBlogPost($db, $newPostContent, $newUserName, $newPostID) 
{
	$thePostContent = sanitiseText($db, $newPostContent);
	$sql = "update BlogPost set postContent = '$newPostContent' where userName = '$newUserName' and postID = '$newPostID'";
	$db->query($sql);
}
//*********************************************************
function checkPostExists($db, $newPostID)
{
	$exists = false;
	$sql = "select count(postID) as total from BlogPost where postID = '$newPostID'";
	$thePostID = $db->query($sql);
	$n = $thePostID->fetch();
	$count = (int)$n['total'];
	if ($count == 0)
	{
		$exists = true;
	}
	return $exists;
}
//*********************************************************
function updatePassword($db, $newUserName, $newPassword)
{
	$login = $newUserName . $newPassword;
	$hash = password_hash($login, PASSWORD_DEFAULT);
	$sql = "update Login set hash = '$hash' where userName = '$newUserName'";
	$db->query($sql);
}
//*********************************************************
function addComment($db, $newPostID, $newCommentContent, $newUserName) 
{
	$theCommentContent = sanitiseText($db, $newCommentContent);
	$sql = "insert into BlogComment values (null, '$newPostID', '$theCommentContent', CURDATE(), '$newUserName')";
	$db->query($sql);
}
//*********************************************************
function likePost($db, $newPostID, $newUserName)
{
	$sql = "delete from PostDislikes where postID = '$newPostID' and userName = '$newUserName'";
	$db->query($sql);
	$sql = "insert into PostLikes values (null, '$newPostID', '$newUserName')";
	$db->query($sql);
}
//*********************************************************
function dislikePost($db, $newPostID, $newUserName)
{
	$sql = "delete from PostLikes where postID = '$newPostID' and userName = '$newUserName'";
	$db->query($sql);
	$sql = "insert into PostDislikes values (null, '$newPostID', '$newUserName')";
	$db->query($sql);
}
//*********************************************************
function removeFeedback($db, $newFeedback, $newPostID, $newUserName)
{
	if ($newFeedback == 'unlike')
	{
		$sql = "delete from PostLikes where postID = '$newPostID' and userName = '$newUserName'";
		$db->query($sql);
	}
	else if ($newFeedback == 'undislike')
	{
		$sql = "delete from PostDislikes where postID = '$newPostID' and userName = '$newUserName'";
		$db->query($sql);
	}
}
//*********************************************************
function addAccount($db, $newFirstName, $newLastName, $newUserName, $newHash, $newEmail, $newDateOfBirth, $newPhoneNo, $newAddress1, $newAddress2) 
{
	$theDateOfBirth = sanitiseDate($newDateOfBirth);
	$theAddress1 = setEmptyRow($newAddress1);
	$theAddress2 = setEmptyRow($newAddress2);
	$thePhoneNo = setEmptyRow($newPhoneNo);
	
	$newFirstName = sanitiseText($db, $newFirstName);
	$newLastName = sanitiseText($db, $newLastName);
	$theUserName = sanitiseText($db, $newUserName);
	$theEmailAddress = sanitiseText($db, $newEmail);
	$theAddress1 = sanitiseText($db, $theAddress1);
	$theAddress2 = sanitiseText($db, $theAddress2);
	
	$sql = "insert into AccountDetails values (null, '$newFirstName','$newLastName','$theUserName','$newHash','$newEmail','$theDateOfBirth','$thePhoneNo','$theAddress1','$theAddress2')";
	$db->query($sql);
}
//*********************************************************
function checkBlogPostTitle($db, $newPostTitle)
{
	$isValid = false;
	$sql = "select COUNT(postID) as total from BlogPost where postTitle = '$newPostTitle'"; //
	$postCount = $db->query($sql);
	$n = $postCount->fetch();
	$result = (int)$n['total'];
	if ($result == 0) 
	{
		$isValid = true;
	}
    return $idValid;	
}
//*********************************************************
function deletePost ($db, $thePostID) 
{
	$sql = "delete from BlogComment where postID = '$thePostID'";
	$db->query($sql);
	$sql = "delete from PostLikes where postID = '$thePostID'";
	$db->query($sql);
	$sql = "delete from PostDislikes where postID = '$thePostID'";
	$db->query($sql);
	$sql = "delete from BlogPost where postID = '$thePostID'";
	$db->query($sql);
}
//*********************************************************
function deleteComment ($db, $theCommentID) 
{
	$sql = "delete from BlogComment where commentID = '$theCommentID'";
	$db->query($sql);
}
//*********************************************************
function setEmptyRow($newValue)
{
	$output = $newValue;
	if ($newValue == "")
	{
		$output = "No Info Given.";
	}
	return $output;
}
//*********************************************************
function sanitiseDate($newDateOfBirth)
{
	return strval($newDateOfBirth);
}
//*********************************************************
function sanitiseText($db, $newText)
{
	$output = strip_tags($newText);
	$output = htmlspecialchars($output);
	$output = htmlentities($output);
	$output = mysqli_real_escape_string($db->getConnection(),$output);
	return $output;
}
?>
