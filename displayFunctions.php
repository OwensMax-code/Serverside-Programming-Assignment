<?php

function getUserProfile ($db, $theAccountID)
{
	$sql = "select * from AccountDetails where accountID = '$theAccountID'";
	$account = $db->query($sql);
	while ($aRow = $account->fetch())
	{	
		$output = "<h1 class='display-5 text-center text-danger mt-3 mb-3'>Your Profile</h1>
				  <div class='row bg-light p-3 m-3'>
				  <div class='col' style='background-color:#CDCDCD;'>
				  <h4><small class='text-muted p-1'>First Name:</small><br>$aRow[firstName]</h4><br>
				  <h4><small class='text-muted p-1'>Last Name:</small><br>$aRow[lastName]</h4><br>
				  <h4><small class='text-muted p-1'>Email Address:</small><br>$aRow[emailAddress]</h4></div>
				  <div class='col' style='background-color:#D7D7D7;'>
				  <h4><small class='text-muted p-1'>Phone Number:</small><br>$aRow[phoneNo]</h4><br>
				  <h4><small class='text-muted p-1'>Address Line 1:</small><br>$aRow[address1]</h4><br>
				  <h4><small class='text-muted p-1'>Address Line 2:</small><br>$aRow[address2]</h4><br></div>
				  </div>";
	}
	return $output;
}

function getUsersPosts ($db, $userName)
{
	$output = "";
	$sql = "select * from BlogPost where userName = '$userName'";
	$accountInfo = $db->query($sql);
	$sql = "select count(postID) as total from BlogPost where userName = '$userName'";
	$postCount = $db->query($sql);
	$n = $postCount->fetch();
	$count = (int)$n['total'];
	if ($count == 0)
	{
		$output .= "<h1 class='display-5 text-center text-danger mt-3 mb-3'>Your Posts - $count total!</h1>
					<div class='d-flex flex-column justify-content-center bg-light p-3 m-3'>
					<h5>Would you like to create one?</h5><br>
					<a href='' class='btn btn-secondary btn-lg'>Create Post!</a>
					</div>";
	}
	else
	{
		$output .= "<h1 class='display-5 text-center text-danger mt-3 mb-3'>Your Posts - $count total!</h1>";
		while ($aRow = $accountInfo->fetch())
		{
			$postCommentCount = getBlogCommentCount($db, $aRow['postID']);
			$output .= "<div class='card' style='margin:2rem;'>
					  <div class='card-body'>
					  <h5 class'card-title'>$aRow[postTitle]</h5>
					  <h6 class='card-subtitle mb-2 text-muted'>$aRow[userName]</h6>
					  <h6 class='card-subtitle mb-2 text-muted'>Posted $aRow[postDate]</h6>
					  <p class='card-text'>$aRow[postContent]</p>
					  <h6 class='card-subtitle mb-2 text-muted'>Comments: $postCommentCount</h6>
					  </div>
					  </div>";
		}
	}	
	return $output;
}
function getMostRecentPosts ($db) 
{
	$sql = "select * from blogPost order by postDate desc";
	$orderedPosts = $db->query($sql);
	$output = "<div class='overflow-auto bg-secondary justify-content-center' style='height: 75vh;overflow-y: scroll;width: 75%;margin: 0 auto;'>";
	while ($aRow = $orderedPosts->fetch())
	{
		$postCommentCount = getBlogCommentCount($db, $aRow['postID']);
		$output .= "<div class='card' style='margin:2rem;'>
					<div class='card-body'>
					<h5 class'card-title'>$aRow[postTitle]</h5>
					<h6 class='card-subtitle mb-2 text-muted'>$aRow[userName]</h6>
					<h6 class='card-subtitle mb-2 text-muted'>Posted $aRow[postDate]</h6>
					<p class='card-text'>$aRow[postContent]</p>
					<h6 class='card-subtitle mb-2 text-muted'>Comments: $postCommentCount</h6>
					</div>
					</div>";
	}	
	$output .= "</div>";
	return $output;
}

?>