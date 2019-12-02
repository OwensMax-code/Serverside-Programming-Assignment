<?php
session_start();
require_once 'myFunctions.php';
require_once 'displayFunctions.php';
require_once 'i18n_sudoku.php';
include_once 'MYSQLDB.php';
require 'db.php';
$userName = retrieveUserName($db, $_SESSION['theAccountID']); 
if (!isset($_SESSION['theAccountID']))
{
	header('Location: sudokuLogin.php?msg=notLoggedIn');
}
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
	$postTitle = $_POST['postTitle'];
	$postContent = $_POST['postContent'];
	if (!checkBlogPostTitle($db, $postTitle))
	{
		addBlogPost($db, $postTitle, $postContent, $userName);
		header('Location: posts.php?msg=recent');
	}
	else 
	{
		header('Location: createPost.php?msg=badTitle');
	}
}
?>
<HTML>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>
		<?=I18n::checkText( "Create Post")?>
	</title>
</head>

<body class="w-75" style="margin:0 auto; background-image: url('img/sudoku-bg1.jpg')">
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand border border-dark" href="#">
				<img src="img/logo.png" class="d-inline-block align-top img-fluid" alt="">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-center" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item"> <a class="nav-link" href="sudokuHome.php"><h3><?=I18n::checkText("Home")?></h3><span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item"> <a class="nav-link" href="posts.php"><h3><?=I18n::checkText("Posts")?></h3></a>
					</li>
					<li class="nav-item"> <a class="nav-link" href="userProfile.php"><h3><?=I18n::checkText("Profile")?></h3></a>
					</li>
				</ul>
			</div>
			<div>
				<?php if ( isset ($_SESSION[ 'theAccountID']))
						{
							$userName=retrieveUserName($db, $_SESSION[ 'theAccountID']);
							echo "<a href='sudokuHome.php?msg=logout'><button type='button' class='btn btn-secondary btn-lg'>$userName - logout</button></a>";
							echo "<a href='createPost.php'><button type='button' class='btn btn-secondary btn-lg m-1'>Create Post!</button></a>";
						} 
						else
						{ 
							echo "<a href='sudokuLogin.php'><button type='button' class='btn btn-secondary btn-lg m-1'>Login/Signup</button></a>";
						} ?>
			</div>
		</nav>
	</header>
<main>
<h1 class='display-5 text-center text-danger mt-3 mb-3'>Create Post</h1>
<div class="d-flex flex-column justify-content-center">
<?php
if ( isset ( $_GET['msg']) && $_GET["msg"] == 'badTitle')
{
	echo "<h1 class='display-5 text-center text-danger mt-3 mb-3'>Post title in use. Please try another!</h1>";
}
?>
<form class="mt-3 p-3 w-50 bg-secondary" action="createPost.php" method="POST" style="margin:0 auto;">
  <div class="form-group">
    <label for="postTitle">Post Title</label>
    <input type="text" name="postTitle" class="form-control" id="postTitle" placeholder="I love books" required>
  </div>
  <div class="form-group">
    <label for="postContent">Post Content</label>
    <textarea class="form-control" name="postContent" id="postContent" rows="5" required></textarea>
  </div>
  <input class="btn btn-lg" type="submit">
</form>
</div>
</main>
</body>

</HTML>