<?php
$query = "INSERT INTO Students (s_id, firstname, lastname, pwd, college, grad, major, sequence)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
          // Can also just put in the direct values instead of these ? placeholders

// $connection is the way we connect to db
$insertStudent = $connection->prepare($query);
$insertStudent->bind_param("issssiss", $s_id, $firstname, $lastname, $pwd, $college, $grad, $major, $sequence);

// Do similar types of statements for all inserts: one for GS, purchase, cookies
$query = "SELECT s_id from Students where s_id=?";
$selectStudent = $connection->prepare($query);
$selectStudent->bind_param("i", $s_id);
