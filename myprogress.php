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
<p> Your major is: <?php echo $_SESSION['major']; ?> </br> <i>Major ID: <?php echo $_SESSION['m_id']; ?> </i></p>
<?php
$s_id = $_SESSION['id'];
$m_id = $_SESSION['m_id'];
mysqli_stmt_execute($selectCompleted);
mysqli_stmt_store_result($selectCompleted);
$rowCompleted = mysqli_stmt_num_rows($selectCompleted);
mysqli_stmt_free_result($selectCompleted);
mysqli_stmt_close($selectCompleted);

mysqli_stmt_execute($selectMissing);
mysqli_stmt_store_result($selectMissing);
$rowMissing = mysqli_stmt_num_rows($selectMissing);


$qry = "SELECT Courses.c_id FROM Courses, Completed WHERE Courses.c_id = Completed.c_id and Completed.s_id = $s_id";
$result1 = perform_query($connection, $qry);
$completed = Array();
while ($row = mysqli_fetch_array ($result1, MYSQLI_ASSOC)){
  $completed[] =  $row['c_id'];
}
$completedCourses=implode(", ",$completed);

$query = "SELECT Courses.c_id FROM Courses, Completed WHERE Courses.c_id = Completed.c_id AND Completed.s_id = $s_id AND Courses.c_id
NOT IN (SELECT c_id FROM Courses WHERE Courses.m_id = $m_id AND Courses.is_required = 1)";
$result2 = perform_query($connection, $query);
$missing = Array();
while ($row = mysqli_fetch_array ($result2, MYSQLI_ASSOC)){
  $missing[] =  $row['c_id'];
}
$missingCourses=implode(", ",$missing);


?>
<p> Required courses completed: <b><?php print_r($rowCompleted) ?> </b></br> <i><?php echo 'Courses: '. $completedCourses; ?> </i></p>
<p> Required courses missing: <b><?php print_r($rowMissing) ?> </b></br> <i><?php echo 'Courses: '. $missingCourses; ?> </i></p>

<?php } ?>

</body>
