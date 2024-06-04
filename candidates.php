<?php
session_start();

if (!isset($_SESSION['voter_name'])) {
    // Debugging: Output the session variable
    var_dump($_SESSION);

    // Redirect to voter_login.php
    header('Location: voter_login.php');
    exit();
}

include('connect.php');

// Assuming session variable or variable with the voter_category value
$voter_category = $_SESSION['category'];

// Query to select data from candidates table based on voter_category
$sql = "SELECT v.voter_id, v.voter_name, v.voter_age, v.photo
        FROM candidates c
        JOIN voter_registration v ON c.voter_id = v.voter_id
        WHERE c.candidate_category = ?";
$stmt = mysqli_prepare($connect, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $voter_category);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        // Fetch and store the results in an array
        $candidates = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $candidates[] = $row;
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error fetching candidate data: " . mysqli_error($connect);
    }
} else {
    echo "Error preparing query: " . mysqli_error($connect);
}


mysqli_close($connect);
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
                <button class="ms-2 btn  me-4 fs-6 btn-violet" type="submit"><a class="text-light" href="voter_logout.php">Log Out</a></button>
    
              </ul>
    
            </div>
          </div>
        </nav>
</header>
         <section id="about-us" class="py-5">
        <div class="ms-4">
            <div class="row">
                 <!--left sidebar-->
                 <div class="col-md-3 pr-md-4">
                    <div class="sidebar-left ">
                        <!--sidebar menu-->
                        <ul class="list-unstyled sidebar-menu pl-md-2 pr-md-0">
                            <li>
                                <a class="sidebar-item active d-flex justify-content-between align-items-center"
                                    href="voter_home.php">Voter
                                    Dashboard
                                    <span class="fas fa-tachometer-alt"></span>
                                </a>
                            </li>
                           
                            <li>
                                <a class="sidebar-item d-flex justify-content-between align-items-center"
                                    href="election_campaign.php">Election Campaign <span class="fas fa-copy"></span>
                                </a>
                            </li>
                           
                            <li>
                                <a class="sidebar-item d-flex justify-content-between align-items-center"
                                    href="candidates_apply.php">
                                    Your profile
                                    <span class="fas fa-heart"></span>
                                </a>
                            </li>
                            <li>
                                <a class="sidebar-item d-flex justify-content-between align-items-center"
                                    href="https://bootstrap.news/bootstrap-4-template-news-portal-magazine/">
                                    Setting
                                    <span class="fas fa-cog"></span>
                                </a>
                            </li>
                            <li>
                                <a class="sidebar-item d-flex justify-content-between align-items-center"
                                    href="voter_logout.php">
                                    Sign out
                                    <span class="fas fa-sign-out-alt"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-9 ">
                    <div class="dashboard-area p-4 bg-violet-100">
                        <div class="row">
                            <div class="col-12 ">
                                <h2 class="mb-4 text-center">Candidates List: <?php  echo $_SESSION['category'];
                                   ?></h2>
                                <div class="row g-4" >
                                    
                                    <?php
                                    // Display candidate information
                                    if (empty($candidates)) {
                                        echo '<div class="col-12 text-center">No candidates available.</div>';
                                    } else {
                                        foreach ($candidates as $row) {
                                            $imageUrl = $row['photo'];
                                            $voterName = $row['voter_name'];
                                            $age = $row['voter_age'];
                                    ?>
                                            <div class="col-lg-4 col-sm-6 ">
                                                
                                                    <div class="card mb-2 mb-md-5 h-100 border border-primary">
                                                        <div class="content">
                                                            <div class="row">
                                                                <div class="">
                                                                    <div class=" mb-2">
                                                                        <img src="images/voter-reg-img/<?php echo $imageUrl; ?>" class="img-fluid rounded-start " alt="...">
                                                                    </div>
                                                                </div>
                                                                <div class="py-4 d-flex justify-content-center align-items-center h-25">
                                                                    <div class="numbers">
                                                                        <h5>Name: <?php echo $voterName; ?></h5>
                                                                        <p class="card-text">Age: <small class=""><?php echo $age; ?></small></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                    <?php 
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
