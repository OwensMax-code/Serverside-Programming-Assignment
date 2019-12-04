<?php
session_start();
require_once 'myFunctions.php';
require_once 'displayFunctions.php';
require_once 'i18n_sudoku.php';
require_once 'verification.php';
require_once 'Retriever.php';
include_once 'MYSQLDB.php';
require 'db.php';
if (isset($_SESSION['theAccountID']))
{
	header('Location: sudokuHome.php');
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
	header('Location:sudokuLogin.php');
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
		<?=I18n::checkText( "Register")?>
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
								<div class="d-flex flex-column justify-content-center">
									<h1 class="display-5 text-center text-danger mt-3 mb-3">Registration!</h1>
									<form class="w-50 border rounded border-dark bg-light text-center" style="margin:0 auto;padding:1rem;" action="sudokuRegistration.php" method="POST">
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
																	<a href="sudokuLogin.php" class="btn btn-secondary">Wait, I already have an account</a>
																</div>
															</div>
														</main>
													</body>
												</HTML>