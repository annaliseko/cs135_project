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
      <li><a href="http://catalog.claremontmckenna.edu/" target="_blank">Courses</a></li>
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


$credqry = "SELECT credits FROM Major WHERE m_id = $m_id";
$result3 = perform_query($connection, $credqry);
$cred = Array();
while ($row = mysqli_fetch_array ($result3, MYSQLI_ASSOC)){
  $cred[] =  $row['credits'];
}
$credits=implode(", ",$cred);

if (empty($completedCourses)) {
  $rowCompleted = '0.00';
  $rowMissing = $credits;
  $missingCourses = 'All Courses in Major (see course catalog)';
}

?>
<p> Required courses completed: <b><?php print_r($rowCompleted) ?> </b></br> <i><?php echo 'Courses: '. $completedCourses; ?> </i></p>
<p> Required courses missing: <b><?php print_r($rowMissing) ?> </b></br> <i><?php echo 'Courses: '. $missingCourses; ?> </i></p>
</br></br>
<?php } ?>



<!-- <h4> Add Courses </h4> -->
<?php
///////////////////////////////////////////////////
/// COMMENTED OUT WHAT WE WANTED TO TRY TO DO  ///
/////    see limitations in final write up   /////
//////////////////////////////////////////////////

// if(isset($_POST['addCS'])) {
//   $s_id = $_SESSION['id'];
//   $c_id = $_POST['cs'];
//   $pass = 1;
//
//   mysqli_stmt_execute($selectAdd);
//   if($selectAdd->fetch()) {
//     echo "Cannot add course: You have already taken this course";
//   }
//   else {
//     mysqli_stmt_execute($insertAdd);
//     mysqli_stmt_insert_id($insertAdd);
//     echo "Course successfully added";
//   }
//   mysqli_stmt_close($selectAdd);
//   mysqli_stmt_close($insertAdd);
// }
//
//
// if(isset($_POST['addEcon'])) {
//   $s_id = $_SESSION['id'];
//   $c_id = $_POST['econ'];
//   $pass = 1;
//
//   mysqli_stmt_execute($selectAdd);
//
//   if($selectAdd ->fetch()) {
//     echo "Cannot add course: You have already taken this course";
//   }
//   else {
//     mysqli_stmt_execute($insertAdd);
//     print_r($connection->error);
//
//     $cid = mysqli_stmt_insert_id($insertAdd);
//     echo "Course $cid successfully added";
//   }
//   mysqli_stmt_close($selectAdd);
//   mysqli_stmt_close($insertAdd);
// }
//
// if(isset($_POST['addMath'])) {
//   $s_id = $_SESSION['id'];
//   $c_id = $_POST['math'];
//   $pass = 1;
//
//   mysqli_stmt_execute($selectAdd);
//   if($selectAdd ->fetch()) {
//    echo "Cannot add course: You have already taken this course";
//   }
//   else {
//     mysqli_stmt_execute($insertAdd);
//     mysqli_stmt_insert_id($insertAdd);
//     echo "Course successfully added";
//   }
//   mysqli_stmt_close($selectAdd);
//   mysqli_stmt_close($insertAdd);
// }
//
// $cs_result = mysqli_query($connection, "SELECT DISTINCT c_id FROM Courses WHERE c_id LIKE '0%' ORDER BY c_id");
// if(mysqli_num_rows($cs_result)){
// $cs= '<select name="cs">';
// while($rs=mysqli_fetch_array($cs_result)){
//       $cs.='<option>'.$rs['c_id'].'</option>';
//   }
// }
// $cs.='</select>';
?>

<!-- <form name="addCS" method="post">
  <legend for="cs">Computer Science courses:
  <?php //echo $cs ?>
  <span style="display:none"></span>
<input id = "addCS" type="submit" name="addCS" value="Add"/>
</form><p></p> -->

<?php
// $e_result = mysqli_query($connection, "SELECT DISTINCT c_id FROM Courses WHERE c_id LIKE '1%' ORDER BY c_id");
// if(mysqli_num_rows($e_result)){
// $econ= '<select name="econ">';
// while($rs=mysqli_fetch_array($e_result)){
//       $econ.='<option>'.$rs['c_id'].'</option>';
//   }
// }
// $econ.='</select>';
?>

<!-- <form name="addEcon" method="post">
  <legend for="econ">Economics courses:
  <?php // echo $econ ?>
  <span style="display:none"></span>
<input id = "addEcon" type="submit" name="addEcon" value="Add"/>
</form>
<p></p> -->
<?php

// $m_result = mysqli_query($connection, "SELECT DISTINCT c_id FROM Courses WHERE c_id LIKE '2%' ORDER BY c_id");
// if(mysqli_num_rows($m_result)){
// $math= '<select name="math">';
// while($rs=mysqli_fetch_array($m_result)){
//       $math.='<option>'.$rs['c_id'].'</option>';
//   }
// }
// $math.='</select>';
?>
<!-- <form name="addMath" method="post">
  <legend for="math">Mathematics courses:
  <?php // echo $math ?>
  <span style="display:none"></span>
<input id = "addMath" type="submit" name="addMath" value="Add"/>
</form> -->

</body>
