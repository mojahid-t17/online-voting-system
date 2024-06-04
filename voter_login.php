
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" href="styles/login.css">
</head>
<body>
<header>
        <nav style="background-color: rgb(237, 231, 252);" class="navbar navbar-expand-lg  mb-5   position-sticky">
            <div class="container-fluid py-2">
			  
              <a class="navbar-brand  text-dark" style="font-weight:bold ;font-size: 1.5em;" href="#">ONLINE VOTING SYSTEM</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="justify-content-end collapse navbar-collapse"id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active text-dark" aria-current="page" href="index.php">Home</a>
                  </li>
                  <button class="f btn mx-4  reg_btn "> <a style="text-decoration: none;" class="text-light" href="voter_reg.php">Voter Registration</a></button>
                </ul>
              </div>
            </div>
          </nav>
    </header>
   <main>
	

	<!-- login container -->
   <div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Sign In</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>
			<div class="card-body">
				<!-- login form -->
				<form action="voter_login.php" method="post" >
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<!-- email input field -->
						<input type="text" name="voter_email" class="form-control" placeholder="Your Email Adress" required>
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<!-- password input field -->
						<input type="password" name="voter_password" class="form-control" placeholder="Enter password" required>
					</div>
					
					<div class="form-group">
						<input style="width: 100px;" name="submit" type="submit" value="Login" class="btn my-2 login_btn">
					</div>
				</form>
			  </div>
              

			   <div class="card-footer">
				<div class="d-flex justify-content-center links">
					Don't have an account?<a class="text-warning" href="voter_reg.php">Sign Up</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="#">Forgot your password?</a>
				</div>
			</div>
		
		</div>
	</div>
</div>
 </main>
 <!-- php code for verification login -->
 <?php
session_start();
require('connect.php');

if (isset($_POST['submit'])){
   
	$voter_email= stripslashes($_REQUEST['voter_email']);
	$voter_email= mysqli_real_escape_string($connect,$voter_email);
	$voter_password = stripslashes($_REQUEST['voter_password']);
	$voter_password = mysqli_real_escape_string($connect,$voter_password);
	
	$query = "SELECT * FROM voter_registration WHERE voter_email='$voter_email' AND voter_password ='$voter_password' ";
	$result = mysqli_query($connect,$query) or die(mysqli_error($connect));
	$rows = mysqli_num_rows($result);
        if($rows==1){
			$row = mysqli_fetch_assoc($result);
			$_SESSION['voter_email'] = $voter_email;
			$_SESSION['voter_name'] = $row['voter_name'];
			$_SESSION['voter_id'] = $row['voter_id'];
			$_SESSION['voter_age'] = $row['voter_age'];
			$_SESSION['category'] = $row['category'];
			$_SESSION['photo'] = $row['photo'];
	       header('Location: voter_home.php');
	       exit();
            
         }
		
		 else{
	   echo "<div class='form text-center text-light bg-danger'>
        <h3>email/password is incorrect.Try Again</h3></div>";
	   }
       }
       
?> 

 <footer class="my-4">

 </footer>
</body>
	


