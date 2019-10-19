<?php
session_start();
require_once 'myFunctions.php';
include_once 'MYSQLDB.php';
require 'db.php';
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
	$userName = $_POST['userName'];
	$password = $_POST['password'];
	$hash = retrieveLogin($db, $userName);
	$login = $userName . $password;
	if (password_verify($login, $hash))
	{			
	$theAccountID = getAccountID( $db, $userName, $hash );
	$_SESSION['theAccountID'] = $theAccountID;
	header('Location: userProfile.php'); 
	}
	else 
	{
		header('Location:sudokuLogin.php?msg=badLogin');
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
						<title>Login/Signup</title>
					</head>
					<body class="w-75" style="margin:0 auto; background-image: url('img/sudoku-bg1.jpg')">
						<header>
							<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
								<a class="navbar-brand border border-dark" href="#">
									<img src="img/logo.png" class="d-inline-block align-top img-fluid" alt="">
									</a>
									<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
										<span class="navbar-toggler-icon"></span>
									</button>
									<div class="collapse navbar-collapse justify-content-center" id="navbarNav">
										<ul class="navbar-nav">
											<li class="nav-item">
												<a class="nav-link" href="sudokuHome.php">
													<h3>Home </h3>
													<span class="sr-only">(current)</span>
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#">
													<h3>Posts</h3>
												</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#">
													<h3>Profile</h3>
												</a>
											</li>
										</ul>
									</div>
									<a href="sudokuLogin.php"><button type="button" class="btn btn-secondary btn-lg">Login/Signup!</button></a>
								</nav>
							</header>
							<main>
								<div>
									<h1 class="display-2 text-center text-danger mt-3 mb-3">Login</h1>
									<?php
									if (isset($_GET["msg"]) && $_GET["msg"] == 'badLogin')
									{
										echo '<h3 class="text-center text-danger">Incorrect username/password combination.</h3>';
									}
									else if (isset($_GET["msg"]) && $_GET["msg"] == 'notLoggedIn')
									{
										echo '<h3 class="text-center text-danger">Please login to access this page.</h3>';
									}
									?>
									<form action="sudokuLogin.php" method="POST" role="form" class="w-50 border rounded border-dark bg-light text-center" style="margin:0 auto;padding:1rem;">
										<div class="form-group">
											<label for="userName">Username</label>
											<input type="text" name="userName" class="form-control" id="userName" aria-describedby="userNameHelp" placeholder="Enter username">
												<small id="usernameHelp" class="form-text text-muted text-danger">We'll never share your info with anyone else. Except Amit.</small>
											</div>
											<div class="form-group">
												<label for="password">Password</label>
												<input type="password" name="password" class="form-control" id="password" placeholder="Password">
												</div>
												<div class="btn-group d-flex justify-content-center m-1" role="group" aria-label="Basic example">
													<input type="submit" class="btn btn-secondary">
														<button type="button" class="btn btn-secondary">Forgot your password?</button>
													</div>
													<a href="sudokuRegistration.php">
														<button type="button" class="btn btn-secondary">Create an account!</button>
													</a>
												</form>
											</div>
										</main>
									</body>
								</HTML>