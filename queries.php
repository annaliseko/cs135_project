<?php
$query = "INSERT INTO Students (s_id, firstname, lastname, pwd, college, grad, m_id, major, sequence)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
          // Can also just put in the direct values instead of these ? placeholders

// $connection is the way we connect to db
$insertStudent = $connection->prepare($query);
$insertStudent->bind_param("issssiiss", $s_id, $firstname, $lastname, $pwd, $college, $grad, $m_id, $major, $sequence);

$querys = "SELECT s_id from Students where s_id=?";
$selectStudent = $connection->prepare($querys);
if ($selectStudent) {
$selectStudent->bind_param("i", $s_id);
} else{
  print_r($connection->error);
}

$querylogin = "SELECT s_id from Students where s_id = ? AND pwd = ?";
$selectLogin = $connection->prepare($querylogin);
if ($selectLogin) {
$selectLogin->bind_param("is", $s_id, $pwd);
} else{
  print_r($connection->error);
}

//QUERY FOR COURSES STUDENTS HAVE TAKEN SO FAR
$query1 = "SELECT * FROM Courses, Completed WHERE Courses.c_id = Completed.c_id and Completed.s_id = ? AND Courses.is_required = 1";
$selectCompleted = $connection->prepare($query1);
if ($selectCompleted) {
  $selectCompleted->bind_param("i", $s_id);
} else{
  print_r($connection->error);
}

// QUERY FOR COURSES STUDENT HAS NOT TAKEN SO FAR
$query2 = "SELECT * FROM Courses WHERE Courses.m_id = ? AND Courses.is_required = 1 AND Courses.c_id NOT IN
(SELECT Courses.c_id FROM Courses, Completed WHERE Courses.c_id = Completed.c_id AND Completed.s_id = ?)";
$selectMissing = $connection->prepare($query2);
if ($selectMissing) {
  $selectMissing->bind_param("ii", $s_id, $m_id);
} else {
    die("Errormessage: ". $connection->error);
}

// ELECTIVES TAKEN SO FAR
$querye = "SELECT * FROM Courses, Completed WHERE Courses.c_id = Completed.c_id AND Completed.s_id = ?
AND Courses.m_id = ? AND Courses.c_id NOT IN(SELECT c_id FROM Courses WHERE Courses.is_required = 1)";
$selectElectives = $connection->prepare($querye);
if ($selectElectives) {
  $selectElectives->bind_param("ii", $s_id, $m_id);
} else {
    die("Errormessage: ". $connection->error);
}

$queryall= "SELECT * FROM Courses, Completed WHERE Courses.c_id = Completed.c_id and Completed.s_id = ?";
$allCompleted = $connection->prepare($queryall);
if ($allCompleted) {
  $allCompleted->bind_param("i", $s_id);
} else{
  print_r($connection->error);
}

$query3 = "SELECT * FROM Courses, Completed WHERE Courses.c_id = Completed.c_id and Completed.s_id = ? AND Courses.q_id = 1";
$cs = $connection->prepare($query3);
if ($cs) {
  $cs->bind_param("i", $s_id);
} else{
  print_r($connection->error);
}

$query4 = "SELECT * FROM Courses, Completed WHERE Courses.c_id = Completed.c_id and Completed.s_id = ? AND Courses.q_id = 2";
$fe = $connection->prepare($query4);
if ($fe) {
  $fe->bind_param("i", $s_id);
} else{
  print_r($connection->error);
}

$query5 = "SELECT * FROM Major WHERE m_id = ?";
$credits = $connection->prepare($query5);
if ($credits) {
  $credits->bind_param("i", $m_id);
} else{
  print_r($connection->error);
}

$query6 = "INSERT INTO Completed (s_id, c_id, pass)
          VALUES (?, ?, ?)";

$insertAdd = $connection->prepare($query6);
$insertAdd->bind_param("idi", $s_id, $c_id, $pass);

$query7 = "SELECT * FROM Completed WHERE s_id=? AND c_id=?";
$selectAdd = $connection->prepare($query7);
if ($selectAdd) {
$selectAdd->bind_param("ii", $s_id, $c_id);
} else{
  print_r($connection->error);
}
