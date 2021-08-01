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

elseif (isset($_POST['login'])) {
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
else{
  $name = $_POST["name"];
  $email = $_POST["email"];
  $number = $_POST["number"];
  $address = $_POST["address"];
  $city = $_POST["city"];
  $capacity = $_POST["capacity"];

  $sql = "INSERT INTO `donation` (`name`, `email`, `contact`, `address`, `city`, `capacity`) VALUES ('$name', '$email', '$number', '$address', '$city', 
  '$capacity')";
  $result = mysqli_query($conn, $sql);
  if ($result){
   $showAlert = true;
  }
  else{
        $showError = "Error Occured";
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
      <form action="/FoodPortal/index.php" method="post">
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
    <label for="contact" class="form-label">Contact</label>
    <input type="tel" class="form-control" id="contact" name="contact">
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary text">Sign Up</button>
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
      <form action="/FoodPortal/index.php" method="post">
      <div class="modal-body">
        <input type="hidden" name="login" id="login">
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

    <?php
    if ($showAlert) {
      echo '<div class="alert alert-success alert-dismissible fade show m-0" role="alert">
      <strong>Success!</strong> Your entry has been recorded successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    if ($showError) {
      echo '<div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
      <strong>Error!</strong> '. $showError .'
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <!-- Carousal -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="http://localhost/FoodPortal/img1.png" class="d-block w-100" alt="..." style="height: 400px">
      <div class="carousel-caption d-none d-md-block">
      </div>
    </div>
    <div class="carousel-item">
      <img src="http://localhost/FoodPortal/img.jpg" class="d-block w-100" alt="..." style="height: 400px">
      <div class="carousel-caption d-none d-md-block">
      </div>
    </div>
    <div class="carousel-item">
      <img src ="http://localhost/FoodPortal/img3.jpg" class="d-block w-100" alt="..." style="height: 400px">
      <div class="carousel-caption d-none d-md-block">
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<h1 class="font-italic text-center mt-5 fw-bold">Welcome to Excessive Food Listing Portal</h1>
<blockquote style="font-style: italic; font-size: 25px;" class="text-center fw-bold">"GIVE FROM YOUR HEART"</blockquote>

<p class="text-center my-4  px-5" style="font-size: 20px">Food listing portal is a mission to end hunger and no wasting of food to make a hungry-free world.
The focus of this project is to reduce the amount of food wasted and being used to the needy people.</p> <p class="text-center my-4 px-5" style="font-size: 20px"> We would love to partner with organisations working towards a similar cause. Reach out to us if you’re an NGO, private organisation or educational institute that is in need of support.</p>


 <!-- Donate Food-->
  <div class="container" id="donate">
  <div class="row align-items-center g-lg-5 py-5">
    <div class="col-lg-7 text-center text-lg-start">
      <h1 class="display-4 fw-bold lh-1 mb-3">Donate Food - Lets help the needy </h1>
      <p class="col-lg-10 fs-4"> Donate the extra food left in marriages, parties or anywhere & feed the needy people. Your little contribution can fill the hunger of starving people. </p>
      <p class="col-lg-10 fs-4">You just to fill a little details - Your name, Address, Contact and Capacity of food for how many people.</p>
    </div>
    <div class="col-md-10 mx-auto col-lg-5">
      <form class="p-4 p-md-5 border rounded-3 bg-light" action="/FoodPortal/index.php" method="POST">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingName" name="name" placeholder="Name">
            <label for="floatingName">Donor Name</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
            <label for="floatingInput">Email Address</label>
          </div>
          <div class="form-floating mb-3">
            <input type="tel" class="form-control" id="floatingNum" name="number" placeholder="Phone no.">
            <label for="floatingNum">Phone No.</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingAddress" name="address" placeholder="Address">
            <label for="floatingAddress">Address</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingCity" name="city" placeholder="city">
            <label for="floatingCity">City</label>
          </div>
          <div class="form-floating mb-3">
            <input type="number" class="form-control" id="floatingcap" name="capacity" placeholder="capacity">
            <label for="floatingcap">Food Capacity (No. of Persons)</label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Confirm</button>
          <hr class="my-4">
          <small class="text-muted">By clicking confirm, you agree that you are not filling fake information.</small>
        </form>
      </div>
    </div>
    </div>

    <p class="lead fw-bold text-center">***You must need to sign up and login to claim the food ***</p> 
    
    <div class="fourthdiv">
        <h2 style="margin-bottom: 20px;">Follow Us</h2>
        <a href="https://www.instagram.com/devang__mathur?r=nametag"><div style="color: orangered"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</div></a>
        <a href="https://www.linkedin.com/in/devang-mathur-757a781ab?lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_view_base_contact_details%3Bria%2BWWBDQd2%2FhLGAWlF0Kw%3D%3D"><div style="color: lightblue"><i class="fa fa-linkedin" aria-hidden="true"></i> LinkedIn</div></a>
        <a href="mailto:devang1234mathur@gmail.com"><div style="color: coral"><i class="fa fa-envelope-o" aria-hidden="true"></i> E-Mail</div></a>
      <a href="mailto:devang1234mathur@gmail.com"><div style="color: cornflowerblue"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</div></a>

    </div>
    
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