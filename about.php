<?php
$showAlert = false;
$showError = false;
$login = false;

//Connecting to the database
$servername = "localhost";
$username = "id17346775_root";
$password = "AS&2]Q0Lu@cbR8hH";
$database = "flp";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("Sorry we are unable to connect");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['snoEdit'])) {
    $name = $_POST["organization"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $contact = $_POST["contact"];

    // Check whether this username exists
    $existSql = "SELECT * FROM `users` WHERE name = '$name'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0){
        // $exists = true;
        $showError = "Username Already Exists";
    }
    else{
        // $exists = false; 
        if(($password == $cpassword)){
            $sql = "INSERT INTO `users` VALUES ('$name', '$password', '$contact')";
            $result = mysqli_query($conn, $sql);
            if ($result){
                $showAlert = true;
            }
        }
        else{
            $showError = "Passwords do not match";
        }
    }
}

else{
  $name = $_POST["organization"];
  $password = $_POST["password"];

   $sql = "Select * from users where name ='$name'";
   $result = mysqli_query($conn, $sql);
   $num = mysqli_num_rows($result);

   if ($num == 1){
        while($row=mysqli_fetch_assoc($result)){
            if ($password == $row['password']){ 
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $name;
                header("location: claim.php");
            } 
            else{
                $showError = "Invalid Credentials";
            }
        }
        
    } 
    else{
        $showError = "Invalid Credentials";
    }
}
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Food Listing Portal</title>
    <style>
      .fourthdiv{
            background-image: linear-gradient(navy, purple);
            color: white;
            width: 100%;
            text-align: center;
      padding-top: 30px;
      padding-bottom: 30px;
        }
        
        .fourthdiv  div{
            font-size: 110%;
            letter-spacing: 2px;
            line-height: 5px;
            padding: 10px;           
        }
      
        .fourthdiv a{
            text-decoration: none;
            margin: auto;
        }
        .fourthdiv i{
            font-size: 120%;
        }

      footer{
      padding: 10px;
      background-color: black;
      color: white;
      text-align: center;
      font-size: 18px;
      line-height: 30px;
      opacity: .9;
      }
    </style>
  </head>
  <body>

<!-- Sign Up Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/FoodPortal/about.php" method="post">
      <div class="modal-body">
      <input type="hidden" name="snoEdit" id="snoEdit">
  <div class="mb-3">
    <label for="organization" class="form-label">Organization Name</label>
    <input type="text" class="form-control" id="organization" name="organization" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <div class="mb-3">
    <label for="cpassword" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword">
    <div id="emailHelp" class="form-text">Make sure that you enter the same password</div>
  </div>
  <div class="mb-3">
    <label for="contact" class="form-label">Contact No.</label>
    <input type="tel" class="form-control" id="contact" name="contact">
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Sign Up</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/FoodPortal/about.php" method="post">
      <div class="modal-body">
  <div class="mb-3">
    <label for="organization" class="form-label">Organization Name</label>
    <input type="text" class="form-control" id="organization" name="organization" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary text">Login</button>
      </div>
      </form>
    </div>
  </div>
</div>
    
    <!-- Navbar -->
    <?php 
        Require 'navbar.php'
    ?>

    
    <h1 class="display-4 fw-bold lh-1 my-4 text-center">About Us</h1>
   <!-- Jumbotron -->
<div class="container col-xxl-8 px-4 py-4">
  <div class="row flex-lg-row-reverse align-items-center g-5 py-4">
    <div class="col-10 col-sm-8 col-lg-6">
      <img src="http://localhost/FoodPortal/thankyou.jpg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
    </div>
    <div class="col-lg-6">
      <h2 class="display-5 mb-3">Food Listing Portal</h2>
      <p class="lead">In our project the donor just have to  fill up the form with the required information.
The donor information is posted on our webpage and any number of user can claim the food.
The system designed in the way that one or more user can claim the food.
 </p>
 <p class="lead">The surplus food from the functions and gatherings can be donated easily. The visualization impact of the donation can create a positive impact on the users.  Minimizing food wastage and feeding the hunger is the main goal of the food listing portal. The Portal is targeted in two ways, the user who is donating the food and the person/organization that is claiming the food.</p>
    </div>
  </div>
</div>   
    </div>
  </div>
</div>  
    
    <h2 class="display-4 fw-bold lh-1 my-4 text-center">Team</h2>

    <!-- Cards -->
<div class="container my-5">
    <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-danger">Coder</strong>
              <h3 class="mb-0">
                Devang Mathur
              </h3><br>
              <p class="card-text mb-auto">College ID - 19CS24 <br>2nd Year Computer Science <br>Engineering College Ajmer</p>
              <a href="https://www.linkedin.com/in/devang-mathur-757a781ab/">See LinkedIn Profile</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="dev.jpg" data-holder-rendered="true">
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-primary">Designer</strong>
              <h3 class="mb-0">
                Ankit Arora
              </h3><br>
              <p class="card-text mb-auto">College ID - 19CS05 <br>2nd Year Computer Science <br>Engineering College Ajmer</p>
              <a href="https://www.linkedin.com/in/ankit-arora-2590411b1/">See LinkedIn Profile</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="Ankit Arora.jpeg" data-holder-rendered="true">
          </div>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-success">Web Hosting</strong>
              <h3 class="mb-0">
                Nikhil Purshwani
              </h3><br>
              <p class="card-text mb-auto">College ID - 19CS62 <br>2nd Year Computer Science <br>Engineering College Ajmer</p>
              <a href="index.php">See LinkedIn Profile</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="nikhil purshwani.jpeg" data-holder-rendered="true">
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-warning">Content</strong>
              <h3 class="mb-0">
                Arnav Yogi
              </h3><br>
              <p class="card-text mb-auto">College ID - 19CS12 <br>2nd Year Computer Science <br>Engineering College Ajmer</p>
              <a href="index.php">See LinkedIn Profile</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="arnav.jpg" data-holder-rendered="true">
          </div>
        </div>
      </div>
    </div>


    <div class="fourthdiv">
        <h2 style="margin-bottom: 20px;">Follow Us</h2>
        <a href="https://www.instagram.com/devang__mathur?r=nametag"><div style="color: orangered"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</div></a>
        <a href="https://www.linkedin.com/in/devang-mathur-757a781ab?lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_view_base_contact_details%3Bria%2BWWBDQd2%2FhLGAWlF0Kw%3D%3D"><div style="color: lightblue"><i class="fa fa-linkedin" aria-hidden="true"></i> LinkedIn</div></a>
        <a href="mailto:devang1234mathur@gmail.com"><div style="color: coral"><i class="fa fa-envelope-o" aria-hidden="true"></i> E-Mail</div></a>
      <a href="mailto:devang1234mathur@gmail.com"><div style="color: cornflowerblue"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</div></a>

    </div>
    
    <!-- Footer -->
    <footer>
    <div style="margin-top:20px; ">Coded by Devang Mathur</div>
    <div>© All Rights Reserved 2021</div>
    </footer>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>