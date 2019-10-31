<?php
function getUserProfile ($db, $theAccountID)
{
	$sql = "select * from AccountDetails where accountID = '$theAccountID'";
	$account = $db->query($sql);
	while ($aRow = $account->fetch())
	{	
		$output = "<h1 class='display-5 text-center text-danger mt-3 mb-3'>Your Profile</h1>
				  <div class='row bg-light p-3 m-3'>
				  <div class='col p-3' style='background-color:#CDCDCD;'>
				  <h4><small class='text-muted p-1'>First Name:</small><br>$aRow[firstName]</h4><br>
				  <h4><small class='text-muted p-1'>Last Name:</small><br>$aRow[lastName]</h4><br>
				  <h4><small class='text-muted p-1'>Email Address:</small><br>$aRow[emailAddress]</h4></div>
				  <div class='col p-3' style='background-color:#D7D7D7;'>
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
		$output .= "<h1 class='display-5 text-center mt-3 mb-3'>Your Posts - $count total!</h1>";
		while ($aRow = $accountInfo->fetch())
		{
			$postCommentCount = getBlogCommentCount($db, $aRow['postID']);
			$output .= generatePost($db, $postCommentCount, $aRow, $userName);
		}
	}	
	return $output;
}

function getPosts ($db, $theFilter, $theUserName) 
{
	$output = '<div class="d-flex flex-row justify-content-center">';
	if ($theFilter == 'recent')
	{
		$sql = "select * from blogPost order by postDate desc";
		$output .= '<h1 class="display-5 text-center text-danger mr-5">Most Recent Posts</h1>';
	}
	else if ($theFilter == 'oldest')
	{
		$sql = "select * from blogPost order by postDate asc";
		$output .= '<h1 class="display-5 text-center text-danger mr-5">Oldest Posts</h1>';
	}
	else if ($theFilter == 'alpha')
	{
		$sql = "select * from blogPost order by postTitle asc";
		$output .= '<h1 class="display-5 text-center text-danger mr-5">Posts in alphabetical Order</h1>';
	}
	else 
	{
		$sql = "select * from blogPost";
		$output .= '<h1 class="display-5 text-center text-danger mr-5">All Posts</h1>';
	}
	$output .= '<div class="dropdown mt-2">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			More Options
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="posts.php">All Posts</a>
			<a class="dropdown-item" href="posts.php?msg=recent">Most Recent Posts</a>
			<a class="dropdown-item" href="posts.php?msg=oldest">Oldest Posts</a>
			<a class="dropdown-item" href="posts.php?msg=alpha">Posts Alphabetically</a>
			</div>
			</div>
			</div>';	
	$orderedPosts = $db->query($sql);
	$output .= "<div class='overflow-auto bg-secondary' style='height: 75vh;overflow-y: scroll;width: 75%;margin:0 auto;'>";
	while ($aRow = $orderedPosts->fetch())
	{
		$postCommentCount = getBlogCommentCount($db, $aRow['postID']);
		$output .= generatePost($db, $postCommentCount, $aRow, $theUserName);
	}	
	$output .= "</div>";
	return $output;
}

function generatePost ($db, $newCommentCount, $newRow, $newUserName)
{
	$output = "<div class='card w-75' style='margin:5 auto;background-color:#CDCDCD;'>
		<div class='card-body'>
		<h5 class'card-title'>$newRow[postTitle]</h5>
		<h6 class='card-subtitle mb-2 text-muted'>Posted by $newRow[userName]</h6>
		<h6 class='card-subtitle mb-2 text-muted'>on $newRow[postDate]</h6>
		<p class='card-text'>$newRow[postContent]</p>
		<h6 class='card-subtitle mb-2 text-muted'>Comments: $newCommentCount</h6>
		<a href='post.php?msg=$newRow[postID]' class='btn btn-secondary mr-1'>Visit Post</a>";
	if ($newUserName == $newRow['userName']) 
	{
		$output .= "<a href='' class='btn btn-secondary ml-1'>Delete Post</a>";
	}
	$output .= "</div></div>";
	return $output;
}

function deletePost ($db) 
	{
		
	}
?>