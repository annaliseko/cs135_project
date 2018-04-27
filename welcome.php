<?php
session_start();
require 'dbconn.php';
$connection = connect_to_db("sequence");
require 'queries.php'
?>

<!DOCTYPE html>
<html>
<head>
<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- js -->
<script src="newvalidate.js"></script>
<style>

body{
    background-color:beige;
}
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: red;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: white;
}

</style>
</head>

<body>

<ul>
  <?php if(isset($_SESSION['student'])){ ?>
    <li><a class="link" href="logout.php">logout</a></li>
    <li><a href="myprogress.php">My Progress</a></li>
    <li><a href="Major.php">Major</a></li>
    <li><a href="http://catalog.claremontmckenna.edu/">Courses</a></li>
<?php }
else{ ?>
  <li><a class="link" href="welcome.php">Login</a></li>
<?php } ?>
</ul>

    <center>
        <h1>Welcome to the Sequence Tracker!</h1>
        <div>
        <form name="login" method="post">
        <legend for="studentid">Student ID:
            <input type="text" name="studentid" value="">
            <span style="display:none"></span></legend>
        <legend for="password"> Password:
                <input type="password" name="password" value="">
                <span  style="display:none"> </span> </legend>
        <button type="submit" href = "">Submit</button>
        </div>
        <div>

            <h> New User?</h>
            <button type = "submit" href="register.php"> Register </button>
        </div>
    </center>



</body>








</html>
