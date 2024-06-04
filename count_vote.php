<?php
session_start();

if (!isset($_SESSION['voter_name'])) {
    // Redirect to voter_login.php if the user is not logged in
    header('Location: voter_login.php');
    exit();
}

include('connect.php');

$voter_category = $_SESSION['category'];

// Fetch active election details
$electionQuery = "SELECT election_id, election_category FROM elections WHERE status = 'active' LIMIT 1";
$electionResult = mysqli_query($connect, $electionQuery);

if ($electionResult) {
    $electionRow = mysqli_fetch_assoc($electionResult);
    $electionId = $electionRow['election_id'];
    $electionCategory = $electionRow['election_category'];
} else {
    echo "Error fetching election details: " . mysqli_error($connect);
}

// Check if the voter has already voted
$checkVoteQuery = "SELECT COUNT(*) as voteCount FROM result WHERE voter_id = ? AND election_id = ?";
$checkVoteStmt = mysqli_prepare($connect, $checkVoteQuery);

if ($checkVoteStmt) {
    mysqli_stmt_bind_param($checkVoteStmt, "ii", $_SESSION['voter_id'], $electionId);
    mysqli_stmt_execute($checkVoteStmt);
    $checkVoteResult = mysqli_stmt_get_result($checkVoteStmt);

    if ($checkVoteResult) {
        $voteCountRow = mysqli_fetch_assoc($checkVoteResult);
        $hasVoted = ($voteCountRow['voteCount'] > 0);

        mysqli_stmt_close($checkVoteStmt);
    } else {
        echo "Error checking vote status: " . mysqli_error($connect);
    }
} else {
    echo "Error preparing vote check query: " . mysqli_error($connect);
}

// Fetch candidate data for the given election and all categories based on the voter's category
$sql = "SELECT c.candidate_id, v.voter_id, v.voter_name, v.voter_age, v.category AS voter_category, v.photo, COUNT(r.voter_id) as vote_count
        FROM candidates c
        JOIN voter_registration v ON c.voter_id = v.voter_id
        LEFT JOIN result r ON c.candidate_id = r.candidate_id AND r.election_id = ?
        WHERE c.election_id = ?
        GROUP BY c.candidate_id";

$stmt = mysqli_prepare($connect, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ii", $electionId, $electionId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch and store the results in an array
    $candidates = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $candidates[] = $row;
    }

    mysqli_stmt_close($stmt);

    // Filter candidates where voter category and candidate category are the same
    $filteredCandidates = array_filter($candidates, function ($candidate) use ($voter_category) {
        return $candidate['voter_category'] == $voter_category;
    });

    if (isset($_POST['submit_vote']) && !$hasVoted) {
        $voterId = $_SESSION['voter_id'];
        $selectedCandidateId = $_POST['candidate_id']; // Use the selected candidate_id from the form

        // Get the details of the selected candidate
        $selectedCandidateQuery = "SELECT v.voter_id, v.voter_name, v.voter_age, v.category AS voter_category, v.photo
                                    FROM candidates c
                                    JOIN voter_registration v ON c.voter_id = v.voter_id
                                    WHERE c.candidate_id = ? AND c.election_id = ?";
        
        $selectedCandidateStmt = mysqli_prepare($connect, $selectedCandidateQuery);

        if ($selectedCandidateStmt) {
            mysqli_stmt_bind_param($selectedCandidateStmt, "ii", $selectedCandidateId, $electionId);
            mysqli_stmt_execute($selectedCandidateStmt);
            $selectedCandidateResult = mysqli_stmt_get_result($selectedCandidateStmt);

            if ($selectedCandidateResult && $row = mysqli_fetch_assoc($selectedCandidateResult)) {
                $selectedCandidate = $row;

                // Display the details of the selected candidate
                echo "Selected Candidate: ";
                echo "Name: " . $selectedCandidate['voter_name'] . "<br>";
                echo "Age: " . $selectedCandidate['voter_age'] . "<br>";
                echo "Category: " . $selectedCandidate['voter_category'] . "<br>";
                // echo "Photo: <img src='images/voter-reg-img/" . $selectedCandidate['photo'] . "' alt='Candidate Photo'><br>";

                // Insert or update the vote in the result table
                $updateResultQuery = "INSERT INTO result (voter_id, candidate_id, election_id) VALUES (?, ?, ?)";
                $updateResultStmt = mysqli_prepare($connect, $updateResultQuery);

                if ($updateResultStmt) {
                    mysqli_stmt_bind_param($updateResultStmt, "iii", $voterId, $selectedCandidateId, $electionId);
                    $executionResult = mysqli_stmt_execute($updateResultStmt);

                    if ($executionResult) {
                        echo "Vote counted successfully!";
                        $hasVoted = true;
                    } else {
                        echo "Error executing statement: " . mysqli_error($connect);
                    }

                    mysqli_stmt_close($updateResultStmt);
                } else {
                    echo "Error preparing statement: " . mysqli_error($connect);
                }
            } else {
                echo "Error fetching selected candidate details: " . mysqli_error($connect);
            }

            mysqli_stmt_close($selectedCandidateStmt);
        } else {
            echo "Error preparing selected candidate query: " . mysqli_error($connect);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ CSS link ---------->
    <link rel="stylesheet" href="styles/voter_home.css">

    <!-- Head -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>

<body>
    <header>
        <!-- Nav bar section -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary position-sticky">
            <div class="container-fluid">
                <a class="fs-4 text-violet ms-4 " href=""><i class="fa-solid fa-check-to-slot"></i></a>
                <a class="navbar-brand text-violet fw-bold fs-4" href="#">ONLINE VOTING SYSTEM</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
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
                        <button class="ms-2 btn me-4 fs-6 btn-violet" type="submit"><a class="text-light"
                                href="voter_logout.php">Log Out</a></button>

                    </ul>

                </div>
            </div>
        </nav>
    </header>

      <!-- Main content section -->
      <section id="candidates" class="container mt-4 bg-primary-subtle px-4">
        <h1 class="text-center my-4 pt-4 text-violet">Seclect your Candidate </h1>
        <div class="row">
            <?php
            foreach ($filteredCandidates as $row) {
                $imageUrl = $row['photo'];
                $voterName = $row['voter_name'];
                $age = $row['voter_age'];
                $voteCount = $row['vote_count'];
            ?>
                <div class="col col-md-4 col-xl-3 col-sm-6 col-12 mb-4">
                    <div class="card h-100">
                        <div class="h-50 my-2">
                            <img src="images/voter-reg-img/<?php echo $imageUrl; ?>" class="card-img-top px-4 rounded-circle shadow-4-stron" alt="Candidate Photo">
                        </div>
                        <div class="card-body mt-4 h-25">
                            <h5 class="card-title text-violet">Name: <?php echo $voterName; ?></h5>
                            <p class="card-text">Age: <?php echo $age; ?></p>

                            <form action="" method="POST">
                                <input type="hidden" name="candidate_id" value="<?php echo $row['candidate_id']; ?>">
                                <?php if (!$hasVoted) : ?>
                                    <button type="submit" name="submit_vote" class="btn btn-violet text-light">Vote</button>
                                <?php else : ?>
                                    <button type="button" class="btn btn-secondary" disabled>Voted</button>
                                    <p class="mt-2">Total Votes: <?php echo $voteCount; ?></p>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
        <?php
// ... (your existing code) ...

if (isset($_POST['submit_vote']) && !$hasVoted) {
    $voterId = $_SESSION['voter_id'];

    // Find the candidate ID based on the session category
    $selectedCandidateId = null;
    foreach ($filteredCandidates as $row) {
        if ($row['voter_id'] == $voterId) {
            $selectedCandidateId = $row['candidate_id'];
            break;
        }
    }

    if ($selectedCandidateId !== null) {
        // Insert or update the vote in the result table
        $updateResultQuery = "INSERT INTO result (voter_id, candidate_id, election_id) VALUES (?, ?, ?)";
        $updateResultStmt = mysqli_prepare($connect, $updateResultQuery);

        if ($updateResultStmt) {
            mysqli_stmt_bind_param($updateResultStmt, "iii", $voterId, $selectedCandidateId, $electionId);
            $executionResult = mysqli_stmt_execute($updateResultStmt);

            if ($executionResult) {
                echo "Vote counted successfully!";
                $hasVoted = true;
            } else {
                // Display any SQL errors
                echo "Error executing statement: " . mysqli_error($connect);
            }

            mysqli_stmt_close($updateResultStmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($connect);
        }
    } else {
        // Debug information
        echo "Debug: Candidates array for current voter: ";
        print_r($filteredCandidates);
        echo "Debug: Voter ID from session: $voterId";
        echo "Error: Candidate not found for the current voter.";
    }
}
?>

            <script>
                function submitVote(candidateId) {
                    document.getElementById('candidate_id').value = candidateId;
                    document.getElementById('voteForm').submit();
                }
            </script>
</body>

</html>