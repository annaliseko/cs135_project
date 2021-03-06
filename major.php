<?php
session_start();
$chk = @md5(
$_SERVER[ 'HTTP_ACCEPT_CHARSET' ] .
$_SERVER[ 'HTTP_ACCEPT_ENCODING' ] .
$_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] .
$_SERVER[ 'HTTP_USER_AGENT' ]);

if (empty($_SESSION))
	$_SESSION['key'] = $chk;
else if ($_SESSION['key'] != $chk)
	session_destroy();
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
      <li><a href="myprogress.php">My Progress</a></li>
      <li><a class="active" href="Major.php">Major</a></li>
      <li><a href="http://catalog.claremontmckenna.edu/" target="_blank">Courses</a></li>
  <?php }
  else{ ?>
    <li><a class="link" href="welcome.php">Login</a></li>
  <?php } ?>
  </ul>

<?php if(!isset($_SESSION['student'])) {
  echo "<h1> Please log in to see this page </h1>";
} else {
  $s_id = $_SESSION['id'];
  $m_id = $_SESSION['m_id'];
  mysqli_stmt_execute($cs);
  mysqli_stmt_store_result($cs);
  $csCourses = mysqli_stmt_num_rows($cs);
  mysqli_stmt_free_result($cs);
  mysqli_stmt_close($cs);

  mysqli_stmt_execute($fe);
  mysqli_stmt_store_result($fe);
  $feCourses = mysqli_stmt_num_rows($fe);
  mysqli_stmt_free_result($fe);
  mysqli_stmt_close($fe);
  ?>

<h1> Welcome <?php echo $_SESSION['student']; ?> </h1>
<p> Your major is: <?php echo $_SESSION['major']; ?> </p>
<p> Your sequence is: <?php echo $_SESSION['sequence']; ?> </p>
</br>
<p> Based on the courses you've taken, here is your progress for some sequences that you can complete: </p>
<p> Computer Science: <?php echo $csCourses ?> / 6 </p>
<p> Financial Economics: <?php echo $feCourses ?> / 5 </p>

<?php } ?>
</body>
