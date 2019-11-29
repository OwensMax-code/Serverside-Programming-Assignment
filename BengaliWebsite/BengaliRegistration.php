<?php
session_start();
require_once 'myFunctions.php';
require_once 'displayFunctions.php';
include_once 'MYSQLDB.php';
require 'db.php';
if (isset($_SESSION['theAccountID']))
{
	header('Location: BengaliHome.php');
}
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
	$userName = sanitiseText($db, $_POST['userName']);
	$password = $_POST['userPassword'];
	$login = $userName . $password;
	$hash = password_hash($login, PASSWORD_DEFAULT);
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$emailAddress = $_POST['emailAddress'];
	$phoneNo = $_POST['phoneNo'];
	$dateOfBirth = $_POST['dateOfBirth'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	addAccount($db, $firstName, $lastName, $userName, $hash, $emailAddress, $dateOfBirth, $phoneNo, $address1, $address2);
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
						<title>Register</title>
					</head>
					<body class="w-75" style="margin:0 auto;background-image: url(img/Bengal-BG.png);background-repeat: no-repeat;background-position: center;background-size: cover;">
<header>
<nav class="navbar navbar-light d=flex flex-row justify-content-between" style="background-color:#FF7F50;">
<div class='d-flex flex-row'>
  <a class="navbar-brand" href="#">
    <img src="img/bengal.jpg" width="30" height="30" class="d-inline-block align-top" alt="">
    Bengali for the Hardy
  </a>
<ul class="nav">
  <li class="nav-item">
    <a class="btn nav-link active text-dark mr-1" href="BengaliHome.php" style='background-color:#FF9933;'>Home</a>
  </li>
  <li class="nav-item">
    <a class="btn nav-link text-dark mr-1" href="posts.php" style='background-color:#FF9933;'>Posts</a>
  </li>
  <li class="nav-item">
    <a class="btn nav-link text-dark mr-1" href="userProfile.php" style='background-color:#FF9933;'>User Profile</a>
  </li>
</ul>
</div>
<div class='d-flex flex-row'>
  <?php
  if ( isset ($_SESSION['theAccountID']))
	{
		$userName = retrieveUserName($db, $_SESSION['theAccountID']);
		echo "<a href='BengaliHome.php?msg=logout'><button type='button' class='btn mr-1' style='background-color:#FF9933;'>$userName - Logout</button></a>";
		echo "<a href='createPost.php'><button type='button' class='btn mr-1' style='background-color:#FF9933;'>Create Post!</button></a>";
	}
	else 
	{
		echo "<a href='BengaliLogin.php'><button type='button' class='btn mr-1' style='background-color:#FF9933;'>Login/Signup!</button></a>";
	}
  ?> 
    <a class="navbar-brand" href="#">
    <img src="img/language.png" width="80" height="30" class="d-inline-block align-top" alt="">
  </a>
  </div>
</nav>
</header>
							<main>
								<div class="d-flex flex-column justify-content-center">
									<h1 class="display-5 text-center text-danger mt-3 mb-3">Registration!</h1>
									<form class="w-50 border rounded border-dark bg-light text-center" style="margin:0 auto;padding:1rem;" action="BengaliRegistration.php" method="POST">
										<div class="form-row">
											<div class="form-group col-md-6">
												<label for="userName">Desired Username</label>
												<input type="text" name="userName" class="form-control" id="userName" placeholder="user name" required>
												</div>
												<div class="form-group col-md-6">
													<label for="userPassword">Desired Password</label>
													<input type="password" name="userPassword" class="form-control" id="userPassword" placeholder="Password" required>
													</div>
												</div>
												<div class="form-row">
											<div class="form-group col-md-6">
												<label for="userName">First Name</label>
												<input type="text" name="firstName" class="form-control" id="firstName" placeholder="First Name" required>
												</div>
												<div class="form-group col-md-6">
													<label for="lastName">Last Name</label>
													<input type="text" name="lastName" class="form-control" id="lastName" placeholder="Last Name" required>
													</div>
												</div>
												<div class="form-group">
													<label for="emailAddress">Email Address</label>
													<input type="email" name="emailAddress" class="form-control" id="emailAddress" placeholder="david@example.com" required>
														<label for="inputAddress">Address</label>
														<input type="text" name = "address1" class="form-control" id="address1" placeholder="1234 Main St">
															<label for="address2">Address 2</label>
															<input type="text" name="address2" class="form-control" id="address2" placeholder="Apartment, studio, or floor">
															</div>
															<div class="form-row">
																<div class="form-group col-md-6">
																	<label for="dateOfBirth">Date of Birth</label>
																	<input type="date" name="dateOfBirth" class="form-control" id="dateOfBirth" required>
																	</div>
																	<div class="form-group col-md-6">
																		<label for="phoneNo">Phone Number</label>
																		<input type="text" name="phoneNo" class="form-control" id="phoneNo" placeholder="213-456-7890">
																		</div>
																	</div>
																	<a><button type="submit" class="btn btn-secondary">Sign me up!</button></a>
																</form>
																<div class="d-flex justify-content-center mt-3">
																	<a href="BengaliLogin.php" class="btn btn-secondary">Wait, I already have an account</a>
																</div>
															</div>
														</main>
													</body>
												</HTML>