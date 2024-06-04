<?php
session_start();

// Include the database connection file
include('connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to admin_login.php
    header('Location: admin_login.php');
    exit();
}

// Fetch election categories from the database
$query = "SELECT DISTINCT election_category FROM elections";
$result = mysqli_query($connect, $query);

// Fetch selected category from the URL
$selectedCategory = isset($_GET['candidate_category']) ? urldecode($_GET['candidate_category']) : '';

// Store the selected category in a session variable
$_SESSION['selected_category'] = $selectedCategory;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/admin_home.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>


    <header>
    <nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand"> <h3 style="color: blueviolet; font-weight: 800;">Welcome
                                    <?php echo $_SESSION['admin_name']; ?>
                                </h3></a>
    <div class="d-flex " role="search">
   

    <a style="text-decoration: none;" class="me-4 py-2 fs-5 text-bold" href="admin_home.php"> Back</a>
    <button class="form-btn"> <a style="text-decoration: none;" class="text-light"
                                        href="admin_logout.php">Log out</a></button>
</div>
  </div>
</nav>
    </header>
 
    
<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
                <div class="navi">
                    <ul>
                        <li class="active"><a href="admin_home.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Home</span></a></li>
                        <li><a href="#" class="" data-toggle="modal" data-target="#add_project"><i class="fa fa-tasks"
                                    aria-hidden="true"></i><span class="hidden-xs hidden-sm">Add Election</span></a></li>
                        <li><a href="#"><i class="fa fa-bar-chart" aria-hidden="true"></i><span
                                    class="hidden-xs hidden-sm text-nowrap">Campaigns</span></a></li>
                        <li class="sales">
                            <div class="btn-group">
                                <button class="btn btn-secondary btn-lg dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span><i class="fa fa-user"
                                            aria-hidden="true"></i>Candidates:</span>Category
                                </button>
                                <div class="dropdown-menu">
                                    <?php
                                    // Loop through results and create dropdown links
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $category = $row['election_category'];
                                        echo '<a href="voter_list.php?category=' . urlencode($category) . '">' . $category . '</a>';
                                    }

                                    // Free result set
                                    mysqli_free_result($result);
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li class="sales">
                            <div class="btn-group">
                                <button class="btn btn-secondary btn-lg dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span> Voters List:</span> Category
                                </button>
                                <div class="dropdown-menu">
                                    <?php
                                    // Fetch election categories from the database
                                    $result = mysqli_query($connect, $query);

                                    // Check if query was successful
                                    if ($result) {
                                        // Loop through results and create dropdown links
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $category = $row['election_category'];
                                            echo '<a href="voter_list.php?category=' . urlencode($category) . '">' . $category . '</a>';
                                        }

                                        // Free result set
                                        mysqli_free_result($result);
                                    } else {
                                        echo '<a href="#">Error fetching categories</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span
                                    class="hidden-xs hidden-sm">Calendar</span></a></li>
                        <li><a href="#"><i class="fa fa-calendar" aria-hidden="true"></i><span
                                    class="hidden-xs hidden-sm">Users</span></a></li>
                        <li><a href="#"><i class="fa fa-cog" aria-hidden="true"></i><span
                                    class="hidden-xs hidden-sm">Settings</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 col-sm-11 display-table-cell v-align ">
                <div class="row">
                    <header>
                        <div class="col-md-7">
                            <nav class="navbar-default pull-left">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas"
                                        data-target="#side-menu" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                            </nav>
                           
                        </div>
                       
                         
                           <h1 style="color: #483d8b; font-weight: 500;" class="text-center my-4">Candidate List -
                                <?php echo "$selectedCategory category"; ?>
                            </h1>
                           
                    </header>
                </div>

                <div class="col-md-10 col-sm-11 display-table-cell v-align p-4">
                    <!-- Voter list section -->
                    <section class="container">
            <!-- Candidate List Section -->
            <div class="col-md-10 col-sm-11 display-table-cell v-align p-4">
                    <div class="row">
                        <div class="col-md-12">
                            
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-3 g-5 ">
                        <?php
                        // Update the column name to 'category' instead of 'candidate_category'
                        $candidateQuery = "SELECT v.voter_id, v.voter_name, v.voter_age, v.photo
                          FROM candidates c
                          JOIN voter_registration v ON c.voter_id = v.voter_id
                            WHERE c.candidate_category = '$selectedCategory'";
  

                        $candidateResult = mysqli_query($connect, $candidateQuery);

                        // Check if the query was successful
                        if (!$candidateResult) {
                            die('Query failed: ' . mysqli_error($connect));
                        }

                        // Check if there are any rows in the result
                        if (mysqli_num_rows($candidateResult) > 0) {
                            while ($candidateRow = mysqli_fetch_assoc($candidateResult)) {
                                ?>
                                <div class="col col-md-4 col-xl-3 col-sm-6 col-12 mb-4">
                                    <div class="card h-100">
                                        <div class="h-50 ">
                                            <?php
                                            // Assuming the 'photo' column contains the file path for the candidate's photo
                                            $photoPath = "images/voter-reg-img/" . $candidateRow['photo'];

                                            // Check if the photo path is not empty and the file exists
                                            if (!empty($candidateRow['photo']) && file_exists($photoPath)) {
                                                // If the file exists, display the photo
                                                ?>
                                                <img src="<?php echo $photoPath; ?>" class="card-img-top h-100"
                                                    alt="Candidate Photo">
                                                <?php
                                            } else {
                                                // If the file doesn't exist or the path is empty, display a placeholder image
                                                ?>
                                                <img src="path/to/placeholder/image.jpg" class="card-img-top"
                                                    alt="Placeholder Image">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="card-body card-body mt-4 h-25">
                                            <h5 class="card-title">
                                                <?php echo $candidateRow['voter_name']; ?>
                                            </h5>
                                            <p class="card-text">
                                                Voter ID:
                                                <?php echo $candidateRow['voter_id']; ?><br>
                                                Age:
                                                <?php echo $candidateRow['voter_age']; ?><br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="col-md-12 text-center"><p>No candidates found for the selected category.</p></div>';
                        }
                        ?>
                    </div>
                </div>
        </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

    <!-- Bootstrap JS files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>