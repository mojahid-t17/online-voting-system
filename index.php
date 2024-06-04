<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Election</title>
  <!-- gogle fonts link -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Poppins&display=swap" rel="stylesheet">
  <!-- boostrap css link  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- css link  -->
  <link rel="stylesheet" href="styles/style.css">

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
              <a class="nav-link active"  aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#contact">Contact</a>
            </li>
            <button class=" btn mx-4  "> <a style="text-decoration: none;" class="text-light" href="admin_login.php">Admin Login</a></button>

          </ul>

        </div>
      </div>
    </nav>
    <!-- header banner section -->

    <div  class="d-flex flex-column flex-md-row my-4 mx-4 rounded bg-violet-100 ">
      <div class="p-5">
        <h1 class="fw-bold "><span style="color: rgb(247, 104, 89);">Your vote, your power </span> shaping the future
          with every click</h1>
        <h2 class="text-violet fw-bold mt-4">Let's Vote </h2>
        <p>
          Your vote holds immense power, serving as a catalyst for shaping the future with every click. In the
          democratic process, each ballot is a crucial contribution that influences policies, leaders, and the overall
          trajectory of society. It's too easy to vote in our software .</p>
        <button class="fs-6 btn mb-4"><a class="text-light text-decoration-none" href="voter_login.php">Voter LogIn</a></button>
        <h5>If you don't have account please click to<a class="text-decoration-none " href="voter_reg.php" > Voter Registration</a>
        </h5>
      </div>
      <div class="w-100 pt-0 pt-md-5">
        <img class="w-100 " src="home_img/election.png" alt="">
      </div>
    </div>



  </header>
  <main>
    <!-- features section -->
    <section class="mx-4 " >
      <h1  class=" fw-bold fs-1 my-4 mx-auto text-center  pb-2 w-50">OUR FEATURES</h1>
      <div>
        <div class="container-fluid row row-cols-1 row-cols-md-3 g-4">
          <div class="col">
            <div class=" card  shadow  bg-body-tertiary rounded h-100">
              <img src="home_img/features1.jpg" class="card-img-top h-50 w-50 mx-auto" alt="...">
              <div class="card-body h-75">
                <h5 class="card-title text-center fw-bold "> Voter Registration</h5>
                <p class="card-text ">Allows individuals to register as voters by providing necessary details, ensuring a verified and eligible voter database.</p>
                <p class="text-center text-violet"><i class="fa-solid fa-arrow-right"></i></p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class=" card  shadow  bg-body-tertiary rounded h-100">
              <img src="home_img/features2.jpg" class="card-img-top h-50 w-50 mx-auto mt-2" alt="...">
              <div class="card-body h-75">
                <h5 class="card-title text-center fw-bold">Candidate Information </h5>
                <p class="card-text">A centralized database containing comprehensive details about each candidate, including their relevant information</p>
                <p class="text-center text-violet"><i class="fa-solid fa-arrow-right"></i></p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class=" card  shadow  bg-body-tertiary rounded h-100">
              <img src="home_img/features3.jpg" class="card-img-top  h-50 w-50 mx-auto mt-2" alt="...">
              <div class="card-body h-75">
                <h5 class="card-title text-center fw-bold"> Voting Interface </h5>
                <p class="card-text">Provides a user-friendly platform for voters to cast their votes electronically, promoting  accessibility and convenience.
                  </p>
                  <p class="text-center text-violet"><i class="fa-solid fa-arrow-right"></i></p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class=" card  shadow  bg-body-tertiary rounded h-100">
              <img src="home_img/features4.jpg" class="card-img-top h-50 w-50 mx-auto mt-2" alt="...">
              <div class="card-body">
                <h5 class="card-title text-center fw-bold"> Vote Tracking</h5>
                <p class="card-text">Allows voters to verify whether their vote was successfully recorded and provides a tracking 
                  mechanism for election monitoring.</p>
                  <p class="text-center text-violet"><i class="fa-solid fa-arrow-right"></i></p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class=" card  shadow  bg-body-tertiary rounded h-100">
              <img src="home_img/features5.jpg" class="card-img-top h-50 w-50 mx-auto " alt="...">
              <div class="card-body">
                <h5 class="card-title text-center fw-bold">NewsFeed</h5>
                <p class="card-text">Allows the candidate to post their election campaign on the NewsFeed .</p>
                <p class="text-center text-violet"><i class="fa-solid fa-arrow-right"></i></p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class=" card  shadow  bg-body-tertiary rounded h-100">
              <img src="home_img/features6.jpg" class="card-img-top h-50 w-50 mx-auto" alt="...">
              <div class="card-body">
                <h5 class="card-title text-center fw-bold">Administrator Dashboard</h5>
                <p class="card-text">Offers a centralized control panel for administrators to manage the entire voting process and resolve any issues promptly.</p>
                <p class="text-center text-violet"><i class="fa-solid fa-arrow-right"></i></p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
    <!-- about us section -->
    <section >
      <div class=" my-5 mx-5" >
        <div class="row justify-content-center align-items-center">
          <div class="col-md-5">
            <img src="home_img/about-us.png" class="img-fluid rounded-start h-75 w-75" alt="...">
          </div>
          <div class="col-md-7 ">
            <div id ="about">
              <h2 class="fw-bold ">About Us </h2>
              <p class="card-text">Online voting System is a mini project of  Software Engineering & Information System Design course in our University.The core aim of our project is to empower citizens by providing a user friendly platform that allows them to cast their votes from the convenience of their homes or  any location with an internet connection.</p>
              <button class="fs-6 btn mb-2"><a class="text-light text-decoration-none" href="">Explore More</a></button>
            </div>
          </div>
        </div>
      </div>
    </section>
    
  </main>
  <footer class="container-fluid mb-0 py-4 text-light bg-violet">
       <div id="contact" class=" d-md-flex justify-content-around">
        <div>
           <h4>Contact Us </h4>
           <p>Phone : 01500 00 00 00</p>
           <p>Email : info@gmail.com</p>
           <small>All rights reserved mojahidulislamt17@gmail.com</small>
        </div>
        <div>
          <h4>location</h4>
          <p>Hazari Lane, Chattogram,Bangladesh</p>
        </div>
       </div> 
      
        
       
  </footer>

  <!-- boostrap script link  -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <!-- font awsome script -->
  <script src="https://kit.fontawesome.com/a48a021ab7.js" crossorigin="anonymous"></script>
</body>

</html>