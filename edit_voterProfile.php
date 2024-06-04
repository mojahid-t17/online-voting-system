<?php
session_start();

$voter_email = $_SESSION['voter_email'];
if (!isset($_SESSION['voter_name'])) {
    var_dump($_SESSION);
    header('Location: voter_login.php');
    exit();
}



include('connect.php');

if (isset($_POST['submit'])) {
    $new_name = mysqli_real_escape_string($connect, $_POST['voter_name']);
    $new_age = mysqli_real_escape_string($connect, $_POST['voter_age']);

       $sql = "UPDATE voter_registration 
    SET voter_name = '$new_name', voter_age = '$new_age'
    WHERE voter_email = '$voter_email'";

$result = mysqli_query($connect, $sql);

if ($result === TRUE) {
    echo "Update successful!";
    header('location: voter_home.php?user_updated');

    exit;
} else {
    echo "Error: Unable to update profile. " . mysqli_error($connect);
}

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ css link ---------->
    <link rel="stylesheet" href="styles/voter_home.css">

    <!--head-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>

<body>
    <header>
        <!-- nav bar section -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary  position-sticky">
          <div class="container-fluid">
            <a class="fs-4 text-violet ms-4 " href=""><i class="fa-solid fa-check-to-slot"></i></a>
            <a class="navbar-brand text-violet fw-bold  fs-4" href="#">ONLINE VOTING SYSTEM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="voter_home.php">Back</a>
                </li>
                <button class="f btn mx-4  btn-violet "> <a style="text-decoration: none;" class="text-light" href="voter_logout.php">Logout</a></button>
    
              </ul>
    
            </div>
          </div>
        </nav>
    <section id="about-us" class="py-5">
        <div class="container">
        <div class="row">
        <div class="col-6  w-50">
            
        <form  method="post"  enctype="multipart/form-data">
        <div class="card mb-3 " >
           
               
             <div class="row g-0 shadow-lg  rounded-3">
             <div class="col-md-6 ps-4">
                 <img src="images/voter-reg-img/<?php echo $_SESSION['photo']; ?>" class="img-fluid rounded-start  h-100" alt="...">
               </div>
               <div class="col-md-8">
                 <div class="card-body ps-4 ms-4">
                   <h3 class="card-title text-violet mb-3">Edit Profile</h3>
                   <h5>Edit Name:  </h5>
                   <input class="form-control" value="<?php echo $_SESSION['voter_name']; ?>" type="text" name="voter_name"  id="">
                    
                   <p class="card-text mt-2">Edit Age: </p>
                   <input class="form-control"  type="text" name="voter_age" id="" value="<?php echo $_SESSION['voter_age']; ?> ">
                   <button  type="submit" id=" " value="submit" name="submit" class="btn btn-violet text-light mt-2">update</button>
                  
                 </div>
               </div>
             </div>
           </div>
        </form>
        
        </div>
        <div class="col-6">
        <img class="w-100" src="images/register.jpg" alt="">
        </div>
    </div>       
        </div>
    </section>


   


</script>
  <!-- boostrap script link  -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
  crossorigin="anonymous"></script>
</body>

</html>