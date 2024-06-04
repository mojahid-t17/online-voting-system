<?php
session_start();

if (!isset($_SESSION['voter_name'])) {
    // Debugging: Output the session variable
    var_dump($_SESSION);

    // Redirect to voter_login.php
    header('Location: voter_login.php');
    exit();
}


// echo $_SESSION['voter_email'];
// echo $_SESSION['category'];


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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>

<body>
    <header>
        <!-- nav bar section -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary  position-sticky">
            <div class="container-fluid">
                <a class="fs-4 text-violet ms-4 " href=""><i class="fa-solid fa-check-to-slot"></i></a>
                <a class="navbar-brand text-violet fw-bold  fs-4" href="#">ONLINE VOTING SYSTEM</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Contact</a>
                        </li>
                        <button class="ms-2 btn  me-4 fs-6 btn-violet" type="submit"><a class="text-light"
                                href="voter_logout.php">Log Out</a></button>

                    </ul>

                </div>
            </div>
        </nav>
</header>
            <main>
                <section id="about-us" class="py-5 bg-violet-100">
                    <div class="container">
                        <div class="row">
                            <!--left sidebar-->
                            <div class="col-md-3 pr-md-4">
                                <div class="sidebar-left ">
                                    <!--sidebar menu-->
                                    <ul class="list-unstyled sidebar-menu pl-md-2 pr-md-0">
                                        <li>
                                            <a class="sidebar-item active d-flex justify-content-between align-items-center"
                                                href="">
                                                Dashboard
                                                <span class="fas fa-tachometer-alt"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="sidebar-item d-flex justify-content-between align-items-center"
                                                href="edit_voterProfile.php"> Edit Profile
                                                <span class="fas fa-user"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="sidebar-item d-flex justify-content-between align-items-center"
                                                href="election_campaign.php">Election Campaign <span class="fas fa-copy"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="sidebar-item d-flex justify-content-between align-items-center"
                                                href="candidates_apply.php">Candidate profile
                                                <span class="fas fa-user"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="sidebar-item d-flex justify-content-between align-items-center"
                                                href="candidates.php">
                                                Canditdates
                                                <span class="fas fa-heart"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="sidebar-item d-flex justify-content-between align-items-center"
                                                href="">
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

                            <!--Content-->
                            <div class="col-md-9">
                                <div class="dashboard-area">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3 ">
                                                <div class="row">
                                                    <div class="col-8">

                                                        <div class="card mb-3" style="max-width: 540px;">
                                                            <div class="row g-0">
                                                                <div class="col-md-4">
                                                                    <img src="images/voter-reg-img/<?php echo $_SESSION['photo']; ?>"
                                                                        class="img-fluid rounded-start h-100" alt="...">
                                                                </div>
                                                                <div class="col-md-8 ">
                                                                    <div class="card-body ps-4">
                                                                        <h5 class="card-title text-violet">Voter Profile
                                                                        </h5>
                                                                        <h5>Name:
                                                                            <?php echo $_SESSION['voter_name']; ?>
                                                                        </h5>
                                                                        <p class="card-text">Age: <small class="">
                                                                                <?php echo $_SESSION['voter_age']; ?>
                                                                            </small></p>
                                                                        <p class="card-text">category: <small
                                                                                class="text-body-secondary">
                                                                                <?php echo $_SESSION['category']; ?>
                                                                            </small></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-12">
                                            <h2 class="mb-4">Click Elections to vote: </h2>
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">


                                                <li class="nav-item">
                                                    <a class="nav-link active show" id="pills-home-tab"
                                                        data-toggle="pill" href="count_vote.php" role="tab"
                                                        aria-controls="pills-home" aria-selected="true">Elections</a>
                                                </li>

                                            </ul>



                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-4 "> 
                                                            <img class="w-100" src="images/Notes-rafiki.png" alt="">
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </section>

            </main>
            <footer class="container-fluid mb-0 py-4 text-light" style="background-color: #402879dc;">
                <div id="contact" class=" d-md-flex justify-content-around">
                    <div>
                        <h4>Contact Us </h4>
                        <p>Phone : 01500 00 00 00</p>
                        <p>Email : info@gmail.com</p>
                        <small>All rights reserved copyright@2023 startup landing page design</small>
                    </div>
                    <div>
                        <h4>location</h4>
                        <p>Hazari Lane, Chattogram,Bangladesh</p>
                    </div>
                </div>



            </footer>


</body>

</html>