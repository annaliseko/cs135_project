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

mysqli_stmt_execute($selectElectives);
mysqli_stmt_store_result($selectElectives);
$electivesTaken = mysqli_stmt_num_rows($selectElectives);

$countMissing = "SELECT COUNT(c_id) as numMissing FROM Courses WHERE Courses.m_id = $m_id AND Courses.is_required = 1 AND Courses.c_id NOT IN
(SELECT Courses.c_id FROM Courses, Completed WHERE Courses.c_id = Completed.c_id AND Completed.s_id = $s_id)";
$missing = perform_query($connection, $countMissing);
$row = mysqli_fetch_array($missing, MYSQLI_ASSOC);
$rowMissing = $row['numMissing'];

$qry = "SELECT Courses.c_id FROM Courses, Completed WHERE Courses.c_id = Completed.c_id and Completed.s_id = $s_id AND Courses.is_required = 1";
$result1 = perform_query($connection, $qry);
$completed = Array();
while ($row = mysqli_fetch_array ($result1, MYSQLI_ASSOC)){
  $completed[] =  $row['c_id'];
}
$completedCourses=implode(", ",$completed);

$query = "SELECT c_id FROM Courses WHERE Courses.m_id = $m_id AND Courses.is_required = 1 AND Courses.c_id NOT IN
(SELECT Courses.c_id FROM Courses, Completed WHERE Courses.c_id = Completed.c_id AND Completed.s_id = $s_id)";
$result2 = perform_query($connection, $query);
$missing = Array();
while ($row = mysqli_fetch_array ($result2, MYSQLI_ASSOC)){
  $missing[] =  $row['c_id'];
}
$missingCourses=implode(", ",$missing);

$querye = "SELECT * FROM Courses, Completed WHERE Courses.c_id = Completed.c_id AND Completed.s_id = $s_id
AND Courses.m_id = $m_id AND Courses.c_id NOT IN(SELECT c_id FROM Courses WHERE Courses.is_required = 1)";
$resulte = perform_query($connection, $querye);
$elec = Array();
while ($row = mysqli_fetch_array ($resulte, MYSQLI_ASSOC)){
  $elec[] =  $row['c_id'];
}
$elecCourses=implode(", ",$elec);

$credqry = "SELECT credits FROM Major WHERE m_id = $m_id";
$result3 = perform_query($connection, $credqry);
$cred = Array();
while ($row = mysqli_fetch_array ($result3, MYSQLI_ASSOC)){
  $cred[] =  $row['credits'];
}
$credits=implode(", ",$cred);

$rquery = "SELECT COUNT(c_id) as reqCourses FROM Courses WHERE m_id = $m_id AND is_required = 1";
$requiredC = perform_query($connection, $rquery);
$row = mysqli_fetch_array($requiredC, MYSQLI_ASSOC);
$elecCount = $row['reqCourses'];
$electives = $credits - $elecCount;

$aquery = "SELECT * FROM Courses, Completed WHERE Courses.c_id = Completed.c_id and Completed.s_id = $s_id";
$allC = perform_query($connection, $aquery);
$allCourses = Array();
while ($row = mysqli_fetch_array ($allC, MYSQLI_ASSOC)){
  $allCourses[] =  $row['c_id'];
}
$allCompleted=implode(", ",$allCourses);


if (empty($completedCourses)) {
  $rowCompleted = '0.00';
  $rowMissing = $credits;
    echo "in if statment";
  $missingCourses = 'You have not taken any courses that fulfill this major yet. Please see course catalog.';
}

?>
<h3> Major Requirements: </h3>
<p> Required courses completed: <b><?php print_r($rowCompleted) ?> </b></br> <i><?php echo 'Courses: '. $completedCourses; ?> </i></p>
<p> Required courses missing: <b><?php print_r($rowMissing) ?> </b></br> <i><?php echo 'Courses: '. $missingCourses; ?> </i></p>
<p> Electives taken: <b><?php print_r($electivesTaken . ' / ' . $electives) ?> </b></br> <i><?php echo 'Courses: '. $elecCourses; ?> </i></p>
<h3> Your Courses: </h3>
<p> Course IDs that start with 0 = CS, 1 = Econ, 2 = Math </p>
<p> All courses completed: <i><?php echo $allCompleted; ?> </i></p>
<?php } ?>



<h3> Add Courses </h3>
<?php
///////////////////////////////////////////////////
/// COMMENTED OUT WHAT WE WANTED TO TRY TO DO  ///
/////    see limitations in final write up   /////
//////////////////////////////////////////////////

if(isset($_POST['addCS'])) {
  $s_id = $_SESSION['id'];
  $c_id = $_POST['cs'];
  $pass = 1;

  mysqli_stmt_execute($selectAdd);
  if($selectAdd->fetch()) {
    echo "Cannot add course: You have already taken this course";
  }
  else {
    mysqli_stmt_execute($insertAdd);
    mysqli_stmt_insert_id($insertAdd);
    echo "Course successfully added (please refresh to see updated changes)";
  }
  mysqli_stmt_close($selectAdd);
  mysqli_stmt_close($insertAdd);
}


if(isset($_POST['addEcon'])) {
  $s_id = $_SESSION['id'];
  $c_id = $_POST['econ'];
  $pass = 1;

  mysqli_stmt_execute($selectAdd);

  if($selectAdd ->fetch()) {
    echo "Cannot add course: You have already taken this course";
  }
  else {
    mysqli_stmt_execute($insertAdd);
    print_r($connection->error);

    $cid = mysqli_stmt_insert_id($insertAdd);
    echo "Course successfully added (please refresh to see updated changes)";
  }
  mysqli_stmt_close($selectAdd);
  mysqli_stmt_close($insertAdd);
}

if(isset($_POST['addMath'])) {
  $s_id = $_SESSION['id'];
  $c_id = $_POST['math'];
  $pass = 1;

  mysqli_stmt_execute($selectAdd);
  if($selectAdd ->fetch()) {
   echo "Cannot add course: You have already taken this course";
  }
  else {
    mysqli_stmt_execute($insertAdd);
    mysqli_stmt_insert_id($insertAdd);
    echo "Course successfully added (please refresh to see updated changes)";
  }
  mysqli_stmt_close($selectAdd);
  mysqli_stmt_close($insertAdd);
}

$cs_result = mysqli_query($connection, "SELECT DISTINCT c_id FROM Courses WHERE c_id LIKE '0%' ORDER BY c_id");
if(mysqli_num_rows($cs_result)){
$cs= '<select name="cs">';
while($rs=mysqli_fetch_array($cs_result)){
      $cs.='<option>'.$rs['c_id'].'</option>';
  }
}
$cs.='</select>';
?>

<form name="addCS" method="post">
  <legend for="cs">Computer Science courses:
  <?php echo $cs ?>
  <span style="display:none"></span>
<input id = "addCS" type="submit" name="addCS" value="Add"/>
</form><p></p>

<?php
$e_result = mysqli_query($connection, "SELECT DISTINCT c_id FROM Courses WHERE c_id LIKE '1%' ORDER BY c_id");
if(mysqli_num_rows($e_result)){
$econ= '<select name="econ">';
while($rs=mysqli_fetch_array($e_result)){
      $econ.='<option>'.$rs['c_id'].'</option>';
  }
}
$econ.='</select>';
?>

<form name="addEcon" method="post">
  <legend for="econ">Economics courses:
  <?php echo $econ ?>
  <span style="display:none"></span>
<input id = "addEcon" type="submit" name="addEcon" value="Add"/>
</form>
<p></p>
<?php

$m_result = mysqli_query($connection, "SELECT DISTINCT c_id FROM Courses WHERE c_id LIKE '2%' ORDER BY c_id");
if(mysqli_num_rows($m_result)){
$math= '<select name="math">';
while($rs=mysqli_fetch_array($m_result)){
      $math.='<option>'.$rs['c_id'].'</option>';
  }
}
$math.='</select>';
?>
<form name="addMath" method="post">
  <legend for="math">Mathematics courses:
  <?php echo $math ?>
  <span style="display:none"></span>
<input id = "addMath" type="submit" name="addMath" value="Add"/>
</form>

</body>
