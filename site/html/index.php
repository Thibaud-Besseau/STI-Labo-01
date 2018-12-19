<?php
session_start();

if (isset($_SESSION['email'])) {
    header('Location: /src/mailbox.php');
}

?>

<!------ Include the above in your HEAD tag ---------->
<html>
  <head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="./public/css/login.css" rel="stylesheet" id="login-css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">



	  <!------ Include the above in your HEAD tag ---------->
  </head>
<body id="LoginForm">
<div class="container">
<h1 class="form-heading">STI LABO 1</h1>
<div class="login-form">
<div class="main-div">
    <div class="panel">
   <h2>Telegram Login</h2>
   <p>Please enter your email and password</p>
   </div>
    <form id="Login" action="src/login.php" method="POST">

        <div class="form-group">


            <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email Address" required>

        </div>

        <div class="form-group">

            <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Password" required>

        </div>
        <div class="forgot">
        <a href="https://www.wikihow.com/Remember-a-Forgotten-Password">Forgot password?</a>
</div>
        <button type="submit" class="btn btn-primary">Login</button>

    </form>
    </div>
	<p class="botto-text"> Designed with <i class="fas fa-heart"></i></p>
<p class="botto-text"> <a href="https://cdn-images-1.medium.com/max/800/1*PdKeUpPIa9ApLb2hcvnPXw.png"> Documentation link </a></p>
</div></div></div>


</body>
</html>