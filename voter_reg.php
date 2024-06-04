<?php
   include('connect.php');
  if(isset($_POST['submit'])){
     $voter_id=$_POST['voter_id'];
     $voter_name=$_POST['voter_name'];
     $voter_age=$_POST['voter_age'];
     $voter_email=$_POST['voter_email'];
     $voter_phone=$_POST['voter_phone'];
     $voter_password=$_POST['voter_password'];
     $voter_category=$_POST['voter_category'];
     $voter_image=$_FILES['voter_image']['name']; 
     $expimg=explode('.',$voter_image);
     $imgexptype=$expimg[1];
     date_default_timezone_set('Asia/Dhaka');
     $date = date('m/d/Yh:i:sa', time());
     $rand=rand(10000,99999);
     $encname=$date.$rand;
     $imgname=md5($encname).'.'.$imgexptype;
     $imgpath="images/voter-reg-img/".$imgname;
      move_uploaded_file($_FILES["voter_image"]["tmp_name"],$imgpath);

   
        // Check for duplicate email using prepared statement
    $check_email_query = "SELECT * FROM voter_registration WHERE voter_email = ?";
    $stmt = mysqli_prepare($connect, $check_email_query);
    mysqli_stmt_bind_param($stmt, "s", $voter_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $row_count = mysqli_stmt_num_rows($stmt);
   
    if ($row_count > 0) {
        echo "Error: Email already exists. Please choose a different email.";
    } else {
        // Insert new voter record
        $sql = "INSERT INTO voter_registration VALUES ('$voter_id','$voter_name', '$voter_age' ,'$voter_email', '$voter_phone','$voter_password','$voter_category','$imgname')";

        $result=mysqli_query($connect,$sql);
        if($result==TRUE){
            header('location: voter_login.php?user_registered');
            exit;
        } else {
            echo "Error: Unable to register. Please try again later.";
        }
    }

    mysqli_stmt_close($stmt);
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>voter Registration</title>
    <!-- boostrap css link  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  

<!-- css link  -->
<link rel="stylesheet" href="styles/style.css">

</head>
<body >
    <header>
        <nav class="navbar navbar-expand-lg bg-violet   position-sticky">
            <div class="container-fluid ">
              <a class="fs-4 text-light text-violet ms-4" href=""><i class="fa-solid fa-check-to-slot"></i></a>
              <a class="navbar-brand text-violet fw-bold text-light fs-4" href="#">ONLINE VOTING SYSTEM</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active text-light" aria-current="page" href="index.php">Home</a>
                  </li>
                  <button class="fs-6 btn mx-4 mb-4"><a class="text-light text-decoration-none" href="voter_login.php">Voter LogIn</a></button>
                 
                </ul>
      
              </div>
            </div>
          </nav>
    </header>
    <main >
      <!-- voter registration form section -->
        <section id="voter_reg_container"> 
          <h1 class="text-center my-5">Voter Registration Form</h1>
          <div  class="container bg-violet-100  p-5 d-flex flex-column flex-md-row">
           
             <div class="w-75">
              <form action="voter_reg.php" method="post"  enctype="multipart/form-data">
                <div class="mb-3 w-75">
                  <label  for="exampleInputEmail1" class="form-label">Your Voter Id</label>
                  <input required placeholder="Enter your voter Id" type="text"ُ name="voter_id" class="form-control" id="exampleInputEmail1" >
                </div>
                <div class="mb-3 w-75">
                  <label  for="exampleInputEmail1" class="form-label">Your Name</label>
                  <input required placeholder="Enter your Name" name="voter_name" type="text" class="form-control" id="exampleInputEmail1" >
                </div>
                
                <div class="mb-3 w-75">
                  <label  for="exampleInputEmail1" class="form-label">Your Age</label>
                  <input required placeholder="Enter your age" name="voter_age"  type="text" class="form-control"  >
                </div>
                <div class="mb-3 w-75">
                <label for="voter_category" class="form-label">Category</label>
    <select name="voter_category" id="voter_category" class="form-select">
        <?php
        // Fetch election categories from the database
        $query = "SELECT DISTINCT election_category FROM elections";
        $result = mysqli_query($connect, $query);

        // Check if query was successful
        if ($result) {
            // Loop through results and create options
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option>' . $row['election_category'] . '</option>';
            }

            // Free result set
            mysqli_free_result($result);
        } else {
            echo '<option>Error fetching categories</option>';
        }
        ?>
    </select>
                 </div>
                <?php
                 
                ?>
                
                  <div class="mb-3 w-75">
                    <label  for="exampleInputEmail1" class="form-label">Email address</label>
                    <input required placeholder="Enter your Email" name="voter_email" type="email" class="form-control" id="exampleInputEmail1" >
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                  </div>
                  <div class="mb-3 w-75">
                    <label  for="exampleInputEmail1"  class="form-label">Your phone NO </label>
                    <input required placeholder="Enter your phone no " name="voter_phone"  type="text" class="form-control" id="exampleInputEmail1" >
                  </div>
                  <div class="mb-3 w-75">
                    <label for="exampleInputPassword1"class="form-label">Password</label>
                    <input required type="password"  name="voter_password"  class="form-control" id="exampleInputPassword1">
                  </div>
                  <div class="mb-3 w-75">
                      <label for="formFile" class="form-label">Upload your Image</label>
                      <!-- preview image before upload -->
                      <img id="previewHolder" alt=" " class="h-25 w-25"/>
                    <input autocomplete="off" name="voter_image" class="form-control" type="file" id="voterImg">
                    
                   
                  </div>
                
                  <button type="submit" id=" " value="submit" name="submit" class="btn btn-primary">Submit</button>
                  <p  class="my-2" >If you already registrated click to <a href="voter_login.php">SignIn</a></p>
                </form>

             </div>
             <div class="w-50 d-flex align-items-center">
              <img class="w-100 " src="images/register.jpg" alt="">
             </div>
            
         </div>
        </section >
         
    
    </main>
    <footer>

    </footer>

<!-- jquery script -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- script to show the image preview before upload -->
<script>
    $("#voterImg").change(function() {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewHolder').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            alert('Select a file to see the preview');
            $('#previewHolder').attr('src', '');
        }
    }
</script>

     <!-- boostrap script link  -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
  crossorigin="anonymous"></script>
   <!-- font awsome script -->
   <script src="https://kit.fontawesome.com/a48a021ab7.js" crossorigin="anonymous"></script>
</body>
</body>
</html>