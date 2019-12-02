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
		<?=I18n::checkText( "Profile")?>
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
<div class="d-flex flex-row justify-content-center mt-5" style="height:75%;">
<div>
<?php
echo getUserProfile($db, $_SESSION['theAccountID']);
?>
</div>
<div class='overflow-auto bg-secondary justify-content-center' style='overflow-y: scroll;width: 75%;margin: 0 auto;'>
<?php
echo getUsersPosts($db, $userName);
?>
</div>
</div>
</main>
</body>

</HTML>