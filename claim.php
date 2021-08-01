<?php

session_start();

if (!isset($_SESSION['loggedin']) or $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit();
}

$insert = false;
$claim = false;
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

if(isset($_GET['claim'])){
  $sno = $_GET['claim'];
  $claim = true;
  $sql = "DELETE FROM `donation` WHERE `sno`= $sno";
  $result = mysqli_query($conn, $sql);
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

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
      <form action="/FoodPortal/sign_up.php" method="post">
      <div class="modal-body">
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
        <button type="button" class="btn btn-primary">Sign Up</button>
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
      <form action="/FoodPortal/sign_up.php" method="post">
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
        <button type="button" class="btn btn-primary text">Login</button>
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
    if ($claim) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success! </strong> Your have succesfully claimed the food. You can collect it
    from the given address.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  ?>

    <h1 class="fw-bold text-center my-5">Available Food</h1>

     <!-- Table -->
  <div class="container my-5">
    <table class="table table-hover table-striped table-dark py-3" id="myTable">
      <thead>
        <tr>
          <th scope="col">S. No.</th>
          <th scope="col">Name</th>
          <th scope="col">Contact</th>
          <th scope="col">Address</th>
          <th scope="col">City</th>
          <th scope="col">Capacity</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM donation";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $sno = $sno + 1;
          echo "<tr>
          <th scope='row'>" . $sno . "</th>
          <td>" . $row['name'] . "</td>
          <td>" . $row['contact'] . "</td>
          <td>" . $row['address'] . "</td>
          <td>" . $row['city'] . "</td>
          <td>" . $row['capacity'] . "</td>
          <td><button class='claim btn btn-sm btn-warning' id= d" . $row['sno'] . ">Claim</button> </td>
        </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <p class="lead fw-bold text-center">***Please note Address and Contact of Donor before Claiming  ***</p> 

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

    <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>

  <script>
  deletes = document.getElementsByClassName('claim');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit", );
        sno = e.target.id.substr(1, );

        if (confirm("Are you sure want to Claim this food?")) {
          console.log("yes");
          window.location = `/FoodPortal/claim.php?claim=${sno}`;
        } else {
          console.log("no");
        }
      })
    })
    </script>
</body>
</html>