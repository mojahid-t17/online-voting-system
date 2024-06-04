<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    // Debugging: Output the session variable
    var_dump($_SESSION);

    // Redirect to admin_login.php
    header('Location: admin_login.php');
    exit();
}

// Include the database connection file
include('connect.php');

if (isset($_POST['submit'])) {
    $election_category = mysqli_real_escape_string($connect, $_POST['election_category']);
    $num_candidates = mysqli_real_escape_string($connect, $_POST['num_candidates']);
    $starting_date = mysqli_real_escape_string($connect, $_POST['starting_date']);
    $ending_date = mysqli_real_escape_string($connect, $_POST['ending_date']);
    $inserted_by = $_SESSION['admin_name'];
    $inserted_on = date("y-m-d");

    $date1 = date_create($inserted_on);
    $date2 = date_create($starting_date);
    $diff = date_diff($date1, $date2);

    if ($diff->format("%R%a days") > 0) {
        $status = "Inactive";
    } else {
        $status = "active";
    }

    // Inserting into the database
    $query = "INSERT INTO elections (election_category, num_candidates, starting_date, ending_date, status, inserted_by, inserted_on) VALUES ('$election_category', '$num_candidates', '$starting_date', '$ending_date','$status', '$inserted_by', '$inserted_on')";
    $res = mysqli_query($connect, $query);

    if ($res == TRUE) {
        header('Location: admin_home.php?added=1');
        exit;
    } else {
        echo "Failed to execute the statement: " . mysqli_error($connect);
    }
}

if (isset($_POST['delete'])) {
    $election_id = mysqli_real_escape_string($connect, $_POST['election_id']);

    // Delete the election from the database
    $query = "DELETE FROM elections WHERE election_id = ?";
    $stmt = mysqli_prepare($connect, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $election_id);
        mysqli_stmt_execute($stmt);

        // Check if the deletion was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Election deleted successfully
            header('Location: admin_home.php?deleted=1');
            exit();
        } else {
            // No rows affected, election not found or already deleted
            header('Location: admin_home.php?error=not_found');
            exit();
        }
    } else {
        // Error preparing the delete statement
        header('Location: admin_home.php?error=database');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"
        id="bootstrap-css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/admin_home.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>

<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">

                <div class="navi">
                    <ul>
                        <li class="active"><a href="#"><i class="fa fa-home" aria-hidden="true"></i><span
                                    class="hidden-xs hidden-sm">Home</span></a></li>
                        <li><a href="#" class="" data-toggle="modal" data-target="#add_project"><i class="fa fa-tasks"
                                    aria-hidden="true"></i><span class="hidden-xs hidden-sm">Add Election</span></a>
                        </li>
                        <li><a href="#"><i class="fa fa-bar-chart" aria-hidden="true"></i><span
                                    class="hidden-xs hidden-sm text-nowrap">Campaigns</span></a></li>
                        <!-- ... (existing code) ... -->

                        <div class="sales">
                            <div class="btn-group">
                                <button class="btn btn-secondary btn-lg dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span> Candidates:</span> Category
                                </button>
                                <div class="dropdown-menu">
                                    <?php
                                    // Include the database connection file
                                    include('connect.php');

                                    // Fetch all distinct candidate categories from the candidates table
                                    $queryCandidates = "SELECT DISTINCT candidate_category FROM candidates";
                                    $resultCandidates = mysqli_query($connect, $queryCandidates);

                                    // Check if query was successful
                                    if ($resultCandidates) {
                                        // Loop through results and create dropdown links
                                        while ($row = mysqli_fetch_assoc($resultCandidates)) {
                                            $category = $row['candidate_category'];
                                            echo '<a class="dropdown-item" href="candidate_list.php?candidate_category=' . urlencode($category) . '">' . $category . '</a>';
                                        }

                                        // Free result set
                                        mysqli_free_result($resultCandidates);
                                    } else {
                                        echo '<a class="dropdown-item" href="#">Error fetching categories</a>';
                                    }

                                    // Close the database connection
                                    mysqli_close($connect);
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- ... (existing code) ... -->



                        <div class="sales">


                            <div class="btn-group">
                                <button class="btn btn-secondary btn-lg dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span> Voters List:</span> Catagory
                                </button>
                                <div class="dropdown-menu">
                                    <?php
                                    // Include the database connection file
                                    include('connect.php');

                                    // Rest of your code...
                                    
                                    // Fetch election categories from the database
                                    $query = "SELECT DISTINCT election_category FROM elections";
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
                        </div>

                        <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span
                                    class="hidden-xs hidden-sm">Calender</span></a></li>
                        <li><a href="#"><i class="fa fa-calendar" aria-hidden="true"></i><span
                                    class="hidden-xs hidden-sm">Users</span></a></li>
                        <li><a href="#"><i class="fa fa-cog" aria-hidden="true"></i><span
                                    class="hidden-xs hidden-sm">Setting</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 col-sm-11 display-table-cell v-align">
                <!--<button type="button" class="slide-toggle">Slide Toggle</button> -->
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
                            <div class="search hidden-xs hidden-sm">
                                <h3 style="color:blueviolet; font-weight:800;  ">Welcome
                                    <?php echo $_SESSION['admin_name']; ?>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-5">

                            <div class="header-rightside">

                                <ul class="list-inline header-top pull-right">


                                    <button class="form-btn"> <a style="text-decoration: none;" class="text-light"
                                            href="admin_logout.php">Log out</a></button>

                                </ul>

                            </div>
                        </div>
                    </header>
                </div>

                <!-- upcoming elections  section -->
                <?php
                // Include the database connection file
                include('connect.php');

                if (isset($_POST['submit'])) {
                    $election_category = mysqli_real_escape_string($connect, $_POST['election_category']);
                    $num_candidates = mysqli_real_escape_string($connect, $_POST['num_candidates']);  // Corrected variable name
                    $starting_date = mysqli_real_escape_string($connect, $_POST['starting_date']);
                    $ending_date = mysqli_real_escape_string($connect, $_POST['ending_date']);
                    $inserted_by = $_SESSION['admin_name'];
                    $inserted_on = date("y-m-d");

                    $date1 = date_create($inserted_on);
                    $date2 = date_create($starting_date);
                    $diff = date_diff($date1, $date2);

                    if ($diff->format("%R%a days") >  0) {
                        $status = "Inactive";
                    } else {
                        $status = "active";
                    }

                    // Inserting into the database
                    $query = "INSERT INTO elections (election_category, num_candidates, starting_date, ending_date, status, inserted_by, inserted_on) VALUES ('$election_category', '$num_candidates', '$starting_date', '$ending_date','$status', '$inserted_by', '$inserted_on')";
                    $res = mysqli_query($connect, $query);

                    if ($res == TRUE) {
                        echo '<script>
        window.location.assign("admin_home.php?added=1");
        </script>';
                        exit; // Move exit outside the script tag
                    } else {
                        echo "Failed to execute the statement: " . mysqli_error($connect);
                    }
                }

                if (isset($_GET['added'])) {
                    echo '<div class="alert alert-success py-2">
            <strong>Success!</strong> Election has been added successfully!!.
          </div>';
                }
                ?>

                <div>
                    <h1 class="text-center my-4">Upcoming Elections</h1>
                    <table class="table">
                        <thead>
                            <tr style=" background-color: rgb(200, 184, 240);">
                                <th scope="col">Sl</th>
                                <th scope="col">Catagory</th>
                                <th scope="col">candidtes Number</th>
                                <th scope="col">Starting Date</th>
                                <th scope="col">Ending date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Inserted By</th>
                                <th scope="col">Inserted On</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $fetchingData = mysqli_query($connect, "SELECT * FROM elections") or die(mysqli_error($connect));
                            $sN0 = 1;
                            while ($row = mysqli_fetch_assoc($fetchingData)) { ?>
                                <tr>
                                    <td>
                                        <?php echo $sN0++; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['election_category']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['num_candidates']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['starting_date']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['ending_date']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['status']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['inserted_by']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['inserted_on']; ?>
                                    </td>
                                    <td>
                                        
                                    <form action="admin_home.php" method="POST">
    <input type="hidden" name="election_id" value="<?php echo $row['election_id']; ?>">
    <button type="submit" name="delete" class="btn btn-sm btn-danger">Delete</button>
</form>

                                    </td>
                                </tr>
                                <?php
                            }

                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>



    <div id="add_project" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- -----------------add election form-------
                ------------------------------------------------------------------>
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Add Election</h4>
                </div>
                <form action="admin_home.php" method="POST">
                    <div class="modal-body">
                        <input type="text" placeholder="Election Category" name="election_category">
                        <input type="number" placeholder="Number of Candidates" name="num_candidates">
                        <input placeholder="Starting Date" onfocus="this.type='Date'" type="text" name="starting_date"
                            id="">
                        <input placeholder="Ending Date" onfocus="this.type='Date'" type="text" name="ending_date"
                            id="">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="cancel" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="save edit-election btn ">Save</button>
                    </div>
                </form>


            </div>

        </div>
    </div>
   
   

</body>

</html>