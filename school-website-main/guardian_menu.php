<?php
session_start();
//check if who is login
if (!isset($_SESSION['guardian-name'])) {

  header("Location: index.php");
  exit();
}

//$loginchild = "";
$loginchildname = "";
//isset($_SESSION['login-child']) && 
if(isset($_SESSION['kid-name'])){

//$loginchild .= $_SESSION['login-child'];
$loginchildname .= $_SESSION['kid-name'];

}

//$loginchildjson = json_encode($loginchild);
$loginchildnamejson = json_encode($loginchildname);
$guardian = $_SESSION['guardian-name'];
$guardianjson = json_encode($guardian);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main</title>

  <style>
    body {
      background-image: url(img/background.jpg);
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      background-size: cover;

    }


    button:hover {
      background-color: rgb(204, 153, 0) !important;
    }

    button {
      background-color: rgb(148, 76, 43);
      color: rgb(15, 13, 15);
      height: 50px;
      font-family: 'Times New Roman', Times, serif;
      font-size: 150px;
      width: 200px;

    }


    .btn1 {
      background-color: transparent;

    }

    .btn1 button {
      background-color: rgb(148, 76, 43);
    }

    @media only screen and (max-width: 414px) {



      img {
        width: 200px;
        height: 70px;
      }

      button {
        font-size: 30px;
      }
    }
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="icon" href="data:,">

</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body loading="lazy">

  <audio id="background-audio" src="music/Puzzle Dance (@fowksprod).mp3" autoplay loop>
    Your browser does not support the audio element.
  </audio>
  <!-- this is side bar -->
  <nav class="btn1 navbar fixed-top">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="span navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Home
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="index.php">Go to Login Page</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Settings
              </a>
              <ul class="dropdown-menu">
                <li>
                  <label class="text-center">Music: <input type="range" id="rangeaudio" style="width: 250px;" min="0" max="100" value="100"></label>
                </li>
              </ul>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Child Registeration
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#myModalforaddchild" data-bs-toggle="modal" data-bs-target="#myModalforaddchild">Register a child</a>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- modal for adding child -->
  <div class="modal fade" id="myModalforaddchild">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Child Account</h1>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="child-name" class="col-form-label">Child name:</label>
              <input type="text" class="form-control" id="child-name" autocomplete="off" required>
            </div>
            <div class="mb-3">
              <label for="user-age" class="col-form-label">Age:</label>
              <input type="text" class="form-control" id="user-age" autocomplete="off" required>
            </div>
            <div class="mb-3">
              <label for="child-user-name" class="col-form-label">Username:</label>
              <input type="text" class="form-control" id="child-user-name" autocomplete="off" required>
            </div>
            <div class="mb-3">
              <label for="childpassword" class="col-form-label">Password:</label>
              <input class="form-control" id="childpassword" autocomplete="off" required></input>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="child()">ADD</button>
        </div>
      </div>
    </div>
  </div>

  <div class="choicemode position-absolute top-50 start-50 translate-middle d-grid gap-2">

    <button class="rounded" onclick="change()">Start</button>

  </div>

  <script>

   //this is notification if child is login and will alert guardian
  // const aleruser =  //$loginchildjson ?>;
   const childname1 = <?= $loginchildnamejson ?>;
   if(childname1 !=""){
      alert('si '+ childname1 + 'ay nag login');
      console.log('si '+ childname1 + 'ay nag login');
   }

    // <!-- this is button to go on game.php file -->
    function change() {
      window.location = "game.php";
    }
    // i retrieve the value from modal and convert it to js then pass it on function.php
    function child() {
      const valueget = <?= $guardianjson ?>;
      const childname = document.getElementById('child-name').value;
      const childusername = document.getElementById('child-user-name').value;
      const age = document.getElementById('user-age').value;
      const password = document.getElementById('childpassword').value;
      if (childusername === "" || password === "") {
        alert("Please fill in the required fields");
      } else if (childusername.length < 6 || password.length < 16) {
        alert("Username must be at least 6 characters and password must be at least 16 characters");
      } else {

        const data = {
          parent: valueget,
          childsname: childname,
          cun: childusername,
          age: age,
          cpuse: password
        };

        $.ajax({

          url: 'function.php',
          method: 'Post',
          data: data,
          dataType: 'text',
          success: function(response) {
            //regular expression to check if the response is successful
            const receive_response = response.match(/Successful|this is already exists|Username already exists|Password already exists/);
            if (receive_response[0] === "Successful") {
              alert("User registered successfully");
            } else if (receive_response[0] === "this is already exists") {

              alert("you are already registered");


            } else if (receive_response[0] === "Username already exists") {

              alert("Username already exists");


            } else if (receive_response[0] === "Password already exists") {

              alert("Password already exists");


            } else {
              alert("An error occurred. Please try again.");
            }
          }


        });
        $('#myModalforaddchild').modal('hide');
        document.getElementById('child-name').value = "";
        document.getElementById('child-user-name').value = "";
        document.getElementById('user-age').value = "";
        document.getElementById('childpassword').value = "";

      }

    }

    const rangevolume = document.getElementById('rangeaudio');
    const audiovolume = document.getElementById('background-audio');
    rangevolume.addEventListener('input', function() {

      audiovolume.volume = rangevolume.value / 100;

    });

    document.body.addEventListener('click', function() {
      var audioElement = document.getElementById('background-audio');

      audioElement.play();

    }, {

      once: true

    });
  </script>

</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>