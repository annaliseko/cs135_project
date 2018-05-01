<?php
$query = "INSERT INTO Students (s_id, firstname, lastname, pwd, college, grad, m_id, major, sequence)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
          // Can also just put in the direct values instead of these ? placeholders

// $connection is the way we connect to db
// $insertStudent = $connection->prepare($query);
// $insertStudent->bind_param("issssiiss", $s_id, $firstname, $lastname, $pwd, $college, $grad, $m_id, $major, $sequence);
//

if ($stmt = $connection->prepare($query)) {

    $stmt->bind_param("issssiiss", $s_id, $firstname, $lastname, $pwd, $college, $grad, $m_id, $major, $sequence);

    // execute it and all...
} else {
    die("Errormessage: ". $connection->error);
}


// Do similar types of statements for all inserts: one for GS, purchase, cookies
//QUERY FOR COURSES STUDENTS HAVE TAKEN SO FAR

$query1 = "SELECT * FROM Courses, Completed WHERE Courses.c_id = Completed.c_id and Completed.s_id = ?";
$selectStudent = $connection->prepare($query1);
if ($selectStudent) {
  $selectStudent->bind_param("i", $s_id);
} else{
  print_r($connection->error);
}

// QUERY FOR COURSES STUDENT HAS NOT TAKEN SO FAR

$query2 = "SELECT * FROM Courses, Completed WHERE Courses.c_id = Completed.c_id AND Completed.s_id = ? AND Courses.c_id
NOT IN (SELECT c_id FROM Courses WHERE Courses.m_id = ?)";
$selectStudent = $connection->prepare($query2);
if ($selectStudent) {
  $selectStudent->bind_param("ii", $s_id, $m_id);
} else{
  print_r($connection->error);
}
