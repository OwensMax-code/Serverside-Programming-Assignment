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
        <a class="nav-link" href="sudokuHome.php"><h3>Home </h3><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><h3>Posts</h3></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><h3>Profile</h3></a>
      </li>
    </ul>
  </div>
  <a href="sudokuLogin.php"><button type="button" class="btn btn-secondary btn-lg">Login/Signup!</button></a>
</nav>
</header>
<main>
<div class="d-flex flex-column justify-content-center">
<h1 class="display-5 text-center text-danger mt-3 mb-3">Registration!</h1>
<form class="w-50 border rounded border-dark bg-light text-center" style="margin:0 auto;padding:1rem;">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="userName">Desired Username</label>
      <input type="text" class="form-control" id="userName" placeholder="user name">
    </div>
    <div class="form-group col-md-6">
      <label for="userPassword">Desired Password</label>
      <input type="password" class="form-control" id="userPassword" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <label for="emailAddress">Email Address</label>
    <input type="email" class="form-control" id="emailAddress" placeholder="david@example.com">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
    <label for="inputAddress2">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="dateOfBirth">Date of Birth</label>
      <input type="date" class="form-control" id="dateOfBirth">
    </div>
    <div class="form-group col-md-6">
      <label for="phoneNo">Phone Number</label>
      <input type="text" class="form-control" id="phoneNo" placeholder="213-456-7890">
    </div>
  </div>
  <button type="submit" class="btn btn-secondary">Sign me up!</button>
</form>
<div class="d-flex justify-content-center mt-3">
  <a href="sudokuLogin.php" class="btn btn-secondary">Wait, I already have an account</a>
  </div>
</div>
</main>
</body>

</HTML>