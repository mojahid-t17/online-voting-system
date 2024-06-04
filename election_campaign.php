<?php
session_start(); // Start the session

include('connect.php'); // Include your database connection

// Assuming you have a session variable for the voter's category
$voterCategory = isset($_SESSION['category']) ? $_SESSION['category'] : '';

// Fetch campaign messages from the database based on the voter's category
$fetchQuery = "SELECT c.message, c.post_date, c.message_title, c.image, ca.candidate_name
               FROM campaign_messages c
               JOIN candidates ca ON c.candidate_id = ca.candidate_id
               WHERE ca.candidate_category = ?  -- Add this condition
               ORDER BY c.post_date DESC";

$stmt = mysqli_prepare($connect, $fetchQuery);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $voterCategory);
    mysqli_stmt_execute($stmt);
    $fetchResult = mysqli_stmt_get_result($stmt);

    if (!$fetchResult) {
        echo "Error fetching campaign messages: " . mysqli_error($connect);
    }
} else {
    echo "Error preparing fetch query: " . mysqli_error($connect);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewpoint" content="width=device-width,initial-scale=1.0">
    <title>News Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/election_campaign.css">
    <script src="https://kit.fontawesome.com/3a42cd3bfc.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav>
        <div class="nav-left">
            <img src="images/logo.png" class="logo">
            <ul>
                <li><img src="images/notification.png"></li>
                <li><img src="images/inbox.png"></li>
                <li><img src="images/video.png"></li>
            </ul>
        </div>
        <div class="nav-right">
            <div class="search-box">
                <img src="images/search.png">
                <input type="text" placeholder="Search">
            </div>
            <div class="nav-user-icon ">
            <button style="background-color:white;" class="ms-2 btn me-4 fs-6 " type="submit"><a class="text-decoration-none"   href="voter_logout.php">Log Out</a></button>

            </div>

        </div>

    </nav>

    <div class="container">
        <!------------left-sidebar-------------->
        <div class="left-sidebar">
            <div class="imp-links mt-5">
                <a href="#"><img src="images/news.png">Latest News</a>
                <a href="candidates_apply.php"><img src="images/friends.png"> Your profile</a>
                <a href="candidates.php"><img src="images/group.png"> Candidates</a>
                <a href="#"><img src="images/watch.png"> Watch</a>
                <a href="#">See More</a>
            </div>
            <div class="shortcut-links">
            <a class="mt-4" href="voter_home.php">Back</a>

            </div>
        </div>
        <!------------main-content-------------->
        <div class="main-content">

          

            <div class="row row-cols-1  g-4">
                <?php
                if (mysqli_num_rows($fetchResult) > 0) {
                    while ($row = mysqli_fetch_assoc($fetchResult)) {
                        $candidateName = $row['candidate_name'];
                        $message = $row['message'];
                        $messageTitle = $row['message_title'];
                        $imagePath = $row['image'];
                        $postDate = $row['post_date'];
                        ?>

                        <div class="col">
                            <div class="card h-100 post-container">
                                <?php if (!empty($imagePath)): ?>
                                    <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="Campaign Image">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title py-3 fw-bold">
                                        Candidate Name:
                                        <?php echo $candidateName; ?>
                                    </h5>
                                    <p class="text-primary"><span>Posted on :</span>
                                    <span class="float-end">
                                        <?php echo $postDate; ?>
                                    </span></p>
                                    <h3 class="card-subtitle mb-2 text-success">
                                        <?php echo $messageTitle; ?>
                                    </h3>
                                    <p class="card-text">
                                        <?php echo $message; ?>
                                    </p>
                                </div>
                                <div class="card-footer text-primary">
                                <div class="post-row">
                    <div class="activity-icons">
                        <div><img src="images/like-blue.png"> 120</div>
                        <div><img src="images/comments.png"> 55</div>
                        <div><img src="images/share.png"> 12</div>
                    </div>
                    
                </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<p>No campaign messages available.</p>";
                }
                ?>
            </div>
            <div class="post-container">
               

                

                <div class="post-row">
                    
                    
                </div>

            </div>


        </div>
        <!------------right-sidebar-------------->
        <div class="right-sidebar mt-4">
            <div class="sidebar-title">
                <h4>Events</h4>
                <a href="#">See all</a>

            </div>

            <div class="event">
                <div class="left-event">
                    <h3>18</h3>
                    <span>Janyary</span>
                </div>
                <div class="right-event">
                    <h4>Teachers voting</h4>
                    <p><i class="fa-solid fa-location-dot"></i> Premier University</p>
                    <a href="#">More info</a>
                </div>

            </div>

            <div class="event">
                <div class="left-event">
                    <h3>12</h3>
                    <span>Janyary</span>
                </div>
                <div class="right-event">
                    <h4>Club leader voting</h4>
                    <p><i class="fa-solid fa-location-dot"></i> Premier cricket club</p>
                    <a href="#">More info</a>
                </div>

            </div>
            <div class="sidebar-title">
                <h4>Advertisement</h4>
                <a href="#">Close</a>

            </div>
            <img src="images/advertisement.png" class="sidebar-ads">
            <div class="sidebar-title">
                <h4>Conversation</h4>
                <a href="#">Hide Chat</a>

            </div>
            <div class="online-list">
                <div class="online">
                    <img src="images/prof-admins.png" alt="">
                </div>
                <p> Md Mehraj</p>
            </div>
            <div class="online-list">
                <div class="online">
                    <img src="images/prof-admins.png" alt="">
                </div>
                <p> Mojahidul Islam</p>
            </div>
            <div class="online-list">
                <div class="online">
                    <img src="images/prof-admins.png" alt="">
                </div>
                <p> Bijeta Chowdhury</p>
            </div>
            <div class="online-list">
                <div class="online">
                    <img src="images/prof-admins.png" alt="">
                </div>
                <p> Md Sayed</p>
            </div>

        </div>

    </div>
</body>

</html>