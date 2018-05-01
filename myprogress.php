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
    background-color: #FFC300;
}

.active {
    color: black;
    background-color: #FFC300;
    font-weight: bold;
}

</style>
</head>

<body>

  <ul>
    <?php if(isset($_SESSION['student'])){ ?>
      <li><a class="link" href="logout.php">Logout</a></li>
      <li><a class="active" href="myprogress.php">My Progress</a></li>
      <li><a href="Major.php">Major</a></li>
      <li><a href="http://catalog.claremontmckenna.edu/">Courses</a></li>
  <?php }
  else{ ?>
    <li><a class="link" href="welcome.php">Login</a></li>
  <?php } ?>
  </ul>

<?php if(!isset($_SESSION['student'])) {
  echo "<h1> Please log in to see this page </h1>";
} else { ?>

<h1> Welcome <?php echo $_SESSION['student']; ?> </h1>
<p> Your major is: <?php echo $_SESSION['major']; ?> </p>
</br> </br>
<?php
// mysqli_stmt_execute($selectCompleted);
// mysqli_stmt_execute($selectMissing);
$selectCompleted = 0;
$selectMissing = 13;
?>
<p> Required courses completed: <?php print_r($selectCompleted) ?> </p>
<p> Required courses missing: <?php print_r($selectMissing) ?> </p>

<?php } ?>

</body>
