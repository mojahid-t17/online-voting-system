<?php
session_start();

if (!isset($_SESSION['voter_name'])) {
    // Redirect to voter_login.php if not logged in
    header('Location: voter_login.php');
    exit();
}

$candidate_name = $_SESSION['voter_name'];
$voter_id = $_SESSION['voter_id'];
include('connect.php');


if (isset($_POST['apply'])) {
   

    // Fetching the election_id from the elections table
    $election_id_query = "SELECT election_id FROM elections WHERE status = 'Active' AND election_category = ?";
    $stmt = mysqli_prepare($connect, $election_id_query);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['category']);
    
    if (!$stmt) {
        die("Error preparing election_id query: " . mysqli_error($connect));
    }

    mysqli_stmt_execute($stmt);
    $election_id_result = mysqli_stmt_get_result($stmt);

    if ($election_id_result) {
        $row = mysqli_fetch_assoc($election_id_result);
        $election_id = $row['election_id'];

        // Check if the voter has already applied for this election
        $checkQuery = "SELECT * FROM candidates WHERE voter_id = ? AND election_id = ?";
        $checkStmt = mysqli_prepare($connect, $checkQuery);

        if ($checkStmt) {
            mysqli_stmt_bind_param($checkStmt, "ii", $voter_id, $election_id);
            mysqli_stmt_execute($checkStmt);
            $checkResult = mysqli_stmt_get_result($checkStmt);

            if ($checkResult) {
                $rows = mysqli_num_rows($checkResult);

                if ($rows > 0) {
                    echo '<div class="alert alert-danger py-2">
                        <strong>Error!</strong> You have already applied for this election.
                      </div>';
                } else {
                    // Insert the candidate application into the candidates table with candidate_category
                    $insertQuery = "INSERT INTO candidates (voter_id, candidate_name, election_id, candidate_category) VALUES (?, ?, ?, ?)";
                    $insertStmt = mysqli_prepare($connect, $insertQuery);

                    if ($insertStmt) {
                        mysqli_stmt_bind_param($insertStmt, "isss", $voter_id, $candidate_name, $election_id, $_SESSION['category']);
                        $insertResult = mysqli_stmt_execute($insertStmt);

                        if ($insertResult) {
                            echo '<div class="alert alert-success py-2">
                                <strong>Success!</strong> Your application has been submitted successfully.
                              </div>';
                        } else {
                            echo '<div class="alert alert-danger py-2 ">
                                <strong>Error!</strong> Failed to submit your application.
                              </div>';
                        }
                    } else {
                        die("Error preparing insert query: " . mysqli_error($connect));
                    }
                }
            } else {
                die("Error executing check query: " . mysqli_error($connect));
            }
        } else {
            die("Error preparing check query: " . mysqli_error($connect));
        }
    } else {
        echo "Error fetching election_id: " . mysqli_error($connect);
    }
}

// Fetching only upcoming elections that match the voter's category
$voter_category = $_SESSION['category'];
$fetchingData = mysqli_query($connect, "SELECT * FROM elections WHERE status = 'Active' AND election_category = '$voter_category'") or die(mysqli_error($connect));
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
    <link rel="stylesheet" href="styles/voter_home.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary position-sticky">
            <div class="container-fluid">
                <a class="fs-4 text-violet ms-4 " href=""><i class="fa-solid fa-check-to-slot"></i></a>
                <a class="navbar-brand text-violet fw-bold fs-4" href="#">ONLINE VOTING SYSTEM</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="candidates.php">Back</a>
                    </li>
                    <button class="ms-2 btn me-4 fs-6 btn-violet" type="submit"><a class="text-light" href="voter_logout.php">Log Out</a></button>
                  </ul>
                </div>
            </div>
        </nav>
    </header>
    <?php


if (!isset($_SESSION['voter_name'])) {
    // Redirect to voter_login.php if not logged in
    header('Location: voter_login.php');
    exit();
}

$candidate_name = $_SESSION['voter_name'];
$voter_id = $_SESSION['voter_id'];
include('connect.php');

// Fetching the election_id from the elections table
$election_id_query = "SELECT election_id FROM elections WHERE status = 'Active' AND election_category = ?";
$stmt = mysqli_prepare($connect, $election_id_query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['category']);

if (!$stmt) {
    die("Error preparing election_id query: " . mysqli_error($connect));
}

mysqli_stmt_execute($stmt);
$election_id_result = mysqli_stmt_get_result($stmt);

if ($election_id_result) {
    $row = mysqli_fetch_assoc($election_id_result);
    $election_id = $row['election_id'];

    // Check if the voter has already applied for this election
    $checkQuery = "SELECT * FROM candidates WHERE voter_id = ? AND election_id = ?";
    $checkStmt = mysqli_prepare($connect, $checkQuery);

    if ($checkStmt) {
        mysqli_stmt_bind_param($checkStmt, "ii", $voter_id, $election_id);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);

        if ($checkResult) {
            $rows = mysqli_num_rows($checkResult);
            if ($rows > 0) {
                // Candidate has already applied, fetch and display the candidate's profile
                $candidateProfileQuery = "SELECT * FROM candidates WHERE voter_id = ? AND election_id = ?";
                $candidateProfileStmt = mysqli_prepare($connect, $candidateProfileQuery);
            
                if ($candidateProfileStmt) {
                    mysqli_stmt_bind_param($candidateProfileStmt, "ii", $voter_id, $election_id);
                    mysqli_stmt_execute($candidateProfileStmt);
                    $candidateProfileResult = mysqli_stmt_get_result($candidateProfileStmt);
            
                    if ($candidateProfileResult) {
                        $candidateProfile = mysqli_fetch_assoc($candidateProfileResult);
                    
                        // Store candidate_id in the session
                        $_SESSION['candidate_id'] = $candidateProfile['candidate_id'];
                    
                        // Use Bootstrap's responsive classes for layout
                        echo '<div class="container mt-5 d-md-flex justify-content-between bg-primary-subtle p-4 my-auto">';
                        echo '<div class="flex-grow-1 mb-4 mb-md-0 ">';
                        echo '<h2 class="mb-4">Your Candidate Profile</h2>';
                        echo '<p><strong>Candidate Name:</strong> ' . $candidateProfile['candidate_name'] . '</p>';
                        echo '<p><strong>Candidate Category:</strong> ' . $candidateProfile['candidate_category'] . '</p>';
                        echo '<p><strong>Election ID:</strong> ' . $candidateProfile['election_id'] . '</p>';
                        echo '</div>';
                    
                        // Post Campaign Message Section
                        echo '<div class="flex-grow-1 mb-4 mb-md-0 ">';
                        echo '<h2 class="mb-4">Post Your Campaign Message</h2>';
                        echo '<form action="" method="POST" enctype="multipart/form-data">';
                        echo '<div class="mb-3">';
                        echo '<label for="message_title" class="form-label">Message Title:</label>';
                        echo '<input type="text" class="form-control w-75" id="message_title" name="message_title" required>';
                        echo '</div>';
                        echo '<div class="mb-3">';
                        echo '<label for="message" class="form-label">Campaign post:</label>';
                        echo '<textarea class="form-control w-75" id="message" name="message" rows="4" required></textarea>';
                        echo '</div>';
                        echo '<div class="mb-3">';
                        echo '<label for="image" class="form-label">Image:</label>';
                        echo '<input type="file" class="form-control w-75" id="image" name="image" accept="image/*">';
                        echo '</div>';
                        echo '<button type="submit" name="post_message" class="btn px-4 btn-primary">Submit Post</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo "Error fetching candidate profile: " . mysqli_error($connect);
                    }
                    
            
                    mysqli_stmt_close($candidateProfileStmt);
                } else {
                    echo "Error preparing candidate profile query: " . mysqli_error($connect);
                }
            }
        } else {
            die("Error executing check query: " . mysqli_error($connect));
        }
    } else {
        die("Error preparing check query: " . mysqli_error($connect));
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_message'])) {
    $candidateId = $_SESSION['candidate_id'];
    $message = $_POST['message'];
    $messageTitle = $_POST['message_title']; 
    // File upload handling
    $imagePath = ''; 

    // Check if a file is selected
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'images/candidate_post/'; // Directory to store uploaded files
        $uploadedFile = $uploadDir.basename($_FILES['image']['name']);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
            $imagePath = $uploadedFile;
        } else {
            echo '<div class="alert alert-danger py-2 w-25 m-4 text-center">Failed to upload the image.</div>';
            exit;
        }
    }

    // Insert the message into the database with image and title
    $insertQuery = "INSERT INTO campaign_messages (candidate_id, message, message_title, image, post_date) VALUES (?, ?, ?, ?, NOW())";
    $insertStmt = mysqli_prepare($connect, $insertQuery);

    if ($insertStmt) {
        // Bind parameters including the new columns
        mysqli_stmt_bind_param($insertStmt, "isss", $candidateId, $message, $messageTitle, $imagePath);
        $executionResult = mysqli_stmt_execute($insertStmt);

        if ($executionResult) {
            echo '<div class="alert alert-success py-2 w-25 m-4 text-center">Message posted successfully!</div>';
        } else {
            echo '<div class="alert alert-danger py-2 w-25 m-4 text-center">Failed to post the message.</div>';
        }

        mysqli_stmt_close($insertStmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connect);
    }
}
?>
    
       
    <section id="about-us" class="py-5">
        <div class="container">
        
        
    
            <div class="row">
                <div>
                    <h1 class="text-center my-4">Upcoming Elections</h1>
                    <table class="table">
                        <thead>
                            <tr style="background-color: rgb(200, 184, 240);">
                                <th scope="col">Sl</th>
                                <th scope="col">Category</th>
                                <th scope="col">Candidates Number</th>
                                <th scope="col">Starting Date</th>
                                <th scope="col">Ending Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sN0 = 1;
                            while ($row = mysqli_fetch_assoc($fetchingData)) { ?>
                                <tr>
                                    <td><?php echo $sN0++; ?></td>
                                    <td><?php echo $row['election_category']; ?></td>
                                    <td><?php echo $row['num_candidates']; ?></td>
                                    <td><?php echo $row['starting_date']; ?></td>
                                    <td><?php echo $row['ending_date']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <button type="submit" name="apply" class="apply-election btn btn-sm btn-success" <?php echo ($row['status'] === 'Inactive') ? 'disabled' : ''; ?>> Apply</button>
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
    </section>
   
</body>

</html>