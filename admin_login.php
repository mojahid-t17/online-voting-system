
<!DOCTYPE html>
<html>
<head>
	<title>Admin Login Page</title>
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
                  <button class="f btn mx-4  reg_btn "> <a style="text-decoration: none;" class="text-light" href="index.php">Home</a></button>
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
				<h3>Admin Login</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>
			<div class="card-body">
				<!-- login form -->
				<form action="admin_login.php" method="post" >
				<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<!-- id input field -->
						<input type="text" name="admin_id" class="form-control" placeholder="Enter Your admin Id" required>
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<!-- email input field -->
						<input type="text" name="admin_email" class="form-control" placeholder="Your Email Adress" required>
						
					</div>
					
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<!-- password input field -->
						<input type="password" name="admin_password" class="form-control" placeholder="Enter password" required>
					</div>
					
					<div class="form-group">
						<input style="width: 100px;" name="submit" type="submit" value="Login" class="btn my-2 login_btn">
					</div>
				</form>
			  </div>
		</div>
	</div>
</div>
 </main>
 <!-- php code for verification login -->
 <?php
session_start();
require('connect.php');

if (isset($_POST['submit'])) {
    $admin_id = mysqli_real_escape_string($connect, $_POST['admin_id']);
    $admin_email = mysqli_real_escape_string($connect, $_POST['admin_email']);
    $admin_password = mysqli_real_escape_string($connect, $_POST['admin_password']);

    $query = "SELECT * FROM admin_registration WHERE admin_id='$admin_id' AND admin_email='$admin_email' AND admin_password='$admin_password'";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));

    if (mysqli_num_rows($result) == 1) {
        // Admin is authenticated
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_email'] = $admin_email;
        $_SESSION['admin_name'] = $row['admin_name'];
		header('Location: admin_home.php');
        echo $_SESSION['admin_email'];
        // exit();  // Remove if unnecessary
    } else {
		echo "<div class='form text-center text-light bg-danger'>
        <h3>email/password is incorrect.Try Again</h3></div>";
	   }
} 
?>


 <footer class="my-4">

 </footer>
</body>
	


