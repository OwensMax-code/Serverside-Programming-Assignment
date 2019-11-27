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
					<a href='createPost.php' class='btn btn-secondary btn-lg'>Create Post!</a>
					</div>";
	}
	else
	{
		$output .= "<h1 class='display-5 text-center mt-3 mb-3'>Your Posts - $count total!</h1>";
		while ($aRow = $accountInfo->fetch())
		{
			$postLikeCount = getBlogPostLikes($db, $aRow['postID']);
			$postDislikeCount = getBlogPostDislikes($db, $aRow['postID']);
			$postCommentCount = getBlogCommentCount($db, $aRow['postID']);
			$output .= generatePost($db, $postCommentCount,$postLikeCount, $postDislikeCount, $aRow, $userName);
		}
	}	
	return $output;
}

function getPosts ($db, $theFilter, $theUserName) 
{
	$output = '<div class="d-flex flex-row justify-content-center">';
	if ($theFilter == 'all')
	{
		$sql = "select * from blogPost";
		$output .= '<h1 class="display-5 text-center text-danger mr-5">All Posts</h1>';
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
		$sql = "select * from blogPost order by postDate desc";
		$output .= '<h1 class="display-5 text-center text-danger mr-5">Most Recent Posts</h1>';
	}
	$output .=
			'<div class="dropdown mt-2">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			More Options
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="posts.php">All Posts</a>
			<a class="dropdown-item" href="posts.php?msg=all">Most Recent Posts</a>
			<a class="dropdown-item" href="posts.php?msg=oldest">Oldest Posts</a>
			<a class="dropdown-item" href="posts.php?msg=alpha">Posts Alphabetically</a>
			</div>
			</div>
			</div>';	
	$orderedPosts = $db->query($sql);
	$output .= "<div class='overflow-auto bg-secondary' style='height: 75vh;overflow-y: scroll;width: 75%;margin:0 auto;'>";
	while ($aRow = $orderedPosts->fetch())
	{
		$postLikeCount = getBlogPostLikes($db, $aRow['postID']);
		$postDislikeCount = getBlogPostDislikes($db, $aRow['postID']);
		$postCommentCount = getBlogCommentCount($db, $aRow['postID']);
		$output .= generatePost($db, $postCommentCount, $postLikeCount, $postDislikeCount, $aRow, $theUserName);
	}	
	$output .= "</div>";
	return $output;
}

function generatePost ($db, $newCommentCount, $newLikeCount, $newDislikeCount, $newRow, $newUserName)
{
	$output =
		"<div class='card w-75' style='margin:5 auto;background-color:#CDCDCD;'>
		<div class='card-body'>
		<h5 class'card-title'>$newRow[postTitle]</h5>
		<h6 class='card-subtitle mb-2 text-muted'>Posted by $newRow[userName]</h6>
		<h6 class='card-subtitle mb-2 text-muted'>on $newRow[postDate]</h6>
		<p class='card-text'>$newRow[postContent]</p>
		<h6 class='card-subtitle mb-2 text-muted'>Comments: $newCommentCount</h6>
		<h6 class='card-subtitle mb-2 text-muted'>Likes: $newLikeCount Dislikes: $newDislikeCount</h6>
		<a href='post.php?msg=$newRow[postID]' class='btn btn-secondary mr-1'>View Post for Options</a>";
	if ($newUserName == $newRow['userName']) 
	{
		$output .=	getDeletePostButton($db, $newRow);			
	}
	$output .= "</div></div>";
	return $output;
}

function getLikePostButton($db, $theNewRow, $newUserName, $newPostID)
{
	$sql = "select count(postID) as total from PostLikes where userName = '$newUserName' and postID = $newPostID";
	$count = $db->query($sql);
	$n = $count->fetch();
	$count = (int)$n['total'];
	if ($count == 0)
	{
		$output = 
		"<form action='post.php?msg=$newPostID' method='POST'>
		<button type='submit' name='like' class='btn btn-secondary'>Like</button>
		</form>";
	}
	else
	{
		$output = 
		"<button class='btn btn-secondary disabled style='width:auto;height:auto;'>Liked</button>";
	}
return $output;	
}

function getDisLikePostButton($db, $theNewRow, $newUserName, $newPostID)
{
	$sql = "select count(postID) as total from PostDislikes where userName = '$newUserName' and postID = $newPostID";
	$count = $db->query($sql);
	$n = $count->fetch();
	$count = (int)$n['total'];
	if ($count == 0)
	{
		$output = 
		"<form action='post.php?msg=$newPostID' method='POST'>
		<button type='submit' name='dislike' class='btn btn-secondary'>Dislike</button>
		</form>";
	}
	else if ($count > 0)
	{
		$output = 
		"<button class='btn btn-secondary disabled' style='width:auto;height:auto;'>Disliked</button>";
	}
	return $output;	
}

function getDeletePostButton($db, $theNewRow)
{
	$output = "<form action='posts.php' method='POST'>
				<p>
				<a class='btn btn-danger' data-toggle='collapse' href='#deletePost$theNewRow[postID]' role='button' aria-expanded='false' aria-controls='deletePost$theNewRow[postID]'>
				Delete Post
				</a>
				</p>
				<div class='collapse' id='deletePost$theNewRow[postID]'>
				<div class='card card-body'>
				<input type='hidden' name='postID' value='$theNewRow[postID]'>
				<h5>Are you sure?</h5>
				<input type='submit' name='submitDelete' class='btn btn-danger w-50'>
				</div>
				</div>
				</form>";
	return $output;
}

function getDeleteCommentButton($db, $theNewRow)
{
	$output = "<form action='post.php?msg=$theNewRow[postID]' method='POST' class='mt-2'>
				<p>
				<a class='btn btn-danger' data-toggle='collapse' href='#deleteComment$theNewRow[commentID]' role='button' aria-expanded='false' aria-controls='deleteComment$theNewRow[commentID]'>
				Delete Comment
				</a>
				</p>
				<div class='collapse' id='deleteComment$theNewRow[commentID]'>
				<div class='card card-body'>
				<input type='hidden' name='commentID' value='$theNewRow[commentID]'>
				<h5>Are you sure?</h5>
				<input type='submit' name='submitDelete' class='btn btn-danger w-25'>
				</div>
				</div>
				</form>";
	return $output;
}

function getEditPostButton($db, $theNewRow) 
{
	$output =
			"<form action='post.php?msg=$theNewRow[postID]' method='POST'>
			<button type='submit' name='edit' class='btn btn-secondary'>Edit Post</button>
			</form>";
	return $output;
}

function getAddCommentButton($db, $theNewRow)
{
	$output = "<form action='post.php?msg=$theNewRow[postID]' method='POST'>
				<p>
				<a class='btn btn-secondary' data-toggle='collapse' href='#addComment' role='button' aria-expanded='false' aria-controls='addComment'>
				Add Comment!
				</a>
				</p>
				<div class='collapse' id='addComment'>
				<div class='card card-body'>
				<input type='textarea' rows='4' cols='50' name='commentContent' class='rounded' required>
				<input type='submit' name='submitComment' class='btn btn-secondary w-50'>
				</div>
				</div>
				</form>";
	return $output;
}

function getSinglePost ($db, $thePostID, $newUserName) 
{
	$sql = "select * from blogPost where postID = '$thePostID'";
	$thePost = $db->query($sql);
	$output = "";
	while ($aRow = $thePost->fetch())
	{
		$postLikeCount = getBlogPostLikes($db, $aRow['postID']);
		$postDislikeCount = getBlogPostDislikes($db, $aRow['postID']);
		$output .=
				"<h1 class='text-center text-danger display-5'>$aRow[postTitle] - Posted by $aRow[userName]</h1>
				<div class='card w-50 bg-dark' style='margin:5 auto;'>
				<div class='card-body'>
				<h5 class'card-title' style='color:#ffffff;'>$aRow[postContent]</h5>
				<h6 class='card-subtitle mb-2 text-muted'>Posted by $aRow[userName]</h6>
				<h6 class='card-subtitle mb-2 text-muted'>on $aRow[postDate]</h6>
				<h6 class='card-subtitle mb-2 text-muted'>Likes: $postLikeCount Dislikes: $postDislikeCount</h6>";
		if ($newUserName != "")
		{
			$output .= "<div class='d-flex flex-row'>";
			$output .= getLikePostButton($db, $aRow, $newUserName, $aRow['postID']);
			$output .= getDisLikePostButton($db, $aRow, $newUserName, $aRow['postID']);
			$output .= "</div>";
			$output .= 	getAddCommentButton($db, $aRow);
		}		
		if ($newUserName == $aRow['userName']) 
		{
			$output .= "<div class='d-flex flex-row'>";
			$output .= getDeletePostButton($db, $aRow);
			$output .= getEditPostButton($db, $aRow);
			$output .= "</div>";
		}
		else 
		{
			$output .= "</div>";
		}
	}
	if (getBlogCommentCount($db, $thePostID) != 0)
	{
		$output .= '</div></div><h1 class="display-5 text-center text-danger mr-5">Comments:</h1>';
		$output .= getPostComments($db, $thePostID, $newUserName);
	}
	else 
	{
		$output .= "</div></div><h1 class='text-center text-danger display-5'>No Comments :(</h1>";
	}
	return $output;
}

function getPostComments ($db, $thePostID, $theUserName)
{
	$output = "";
	$sql = "select * from BlogComment where postID = $thePostID order by commentDate desc";
	$theComments = $db->query($sql);
	while ($aRow = $theComments->fetch())
	{
		$output .=
				"<div class='card w-50' style='margin:5 auto;background-color:#CDCDCD;'>
				<div class='card-body'>
				<h5 class'card-title'>$aRow[commentContent]</h5>
				<h6 class='card-subtitle mb-2 text-muted'>Posted by $aRow[userName]</h6>
				<h6 class='card-subtitle mb-2 text-muted'>on $aRow[commentDate]</h6>";
		if ($theUserName == $aRow['userName'])
		{
			$output .= getDeleteCommentButton($db, $aRow);
		}
		$output .= "</div></div>";
	}
	return $output;
}

function getEditablePost ($db, $thePostID, $newUserName) 
{
	$sql = "select * from blogPost where postID = '$thePostID'";
	$thePost = $db->query($sql);
	$output = "";
	while ($aRow = $thePost->fetch())
	{
		$output .=
		"<form class='mt-3 p-3 w-50 bg-secondary' action='post.php?msg=$aRow[postID]' method='POST' style='margin:0 auto;'>
		<h3>$aRow[postTitle]</h3>
		<div class='form-group'>
		<label for='postContent'>Post Content</label>
		<textarea class='form-control' name='newPostContent' id='postContent' rows='5' required>$aRow[postContent]</textarea>
		</div>
		<button class='btn btn-lg' type='submit'>Update Post!</button>
		</form>";
	}
	return $output;
}

?>