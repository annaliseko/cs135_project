<?php
require 'dbconn.php';
$connection = connect_to_db("sequence");
// require 'sequence.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="my celebration poll">
        <meta name="author" content="Annalise Ko">

        <!-- The above meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <title>Register</title>

        <!-- Bootstrap (incase u need nice grid layout -->
        <!-- download it from the website: http://getbootstrap.com
             it was too large to include in template folder, but i included link below -->
        <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" >

        <!-- jQuery  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <!-- CSS  -->
        <link rel="stylesheet" href="css/validate.css">
        <!-- JavaScript  -->
        <script src="validate.js"></script>
    </head>

<body>
  <!-- DROPDOWN MENUS (move this later to appropriate part in form)-->
<?php
  $col_result = mysqli_query($connection, "SELECT college FROM Students");
  if (!$col_result) {
        echo("<p>Error performing query:" . mysql_error() . "<p>");
        exit();
    }
  $college="<select>";
  while ($row = mysqli_fetch_array($col_result)) {
  $college .= "<option value='" . $row['college'] . "'>" . $row['college'] . "</option>";
  }
  $college .= '</select>';
  echo $college;

  $m_result = mysqli_query($connection, "SELECT m_name FROM Major");
  $major="<select>";
  while ($row = mysqli_fetch_array($m_result)) {
  $major .= "<option value='" . $row['m_name'] . "'>" . $row['m_name'] . "</option>";
  }
  $major .= '</select>';
  echo $major;

  $q_result = mysqli_query($connection, "SELECT q_name FROM Sequence");
  $sequence="<select>";
  while ($row = mysqli_fetch_array($q_result)) {
  $sequence .= "<option value='" . $row['q_name'] . "'>" . $row['q_name'] . "</option>";
  }
  $sequence .= '</select>';
  echo $sequence;
?>
      <h1> Register </h1>
      <form name="register" method="post">

      <b> Information: </b>

      <!-- Username, password, phone number, email input fields -->
      <legend for="s_id">Student ID:
      <input id = "student" type="text" name="s_id" value=""> </legend>

      <legend for="firstname">First Name:
      <input id = "firstname" type="firstname" name="firstname" value=""> </legend>

      <legend for="lastname">Last Name:
      <input id = "lastname" type="lastname" name="lastname" value=""> </legend>

      <legend for="pwd">Password:
      <input id = "password" type="password" name="password" value=""> </legend>

      <!-- <legend for="college">College:
      <input id = "email" type="text" name="email" value=""> </legend>

      <legend for="grad">Expected Graduation Year:
      <input id = "email" type="text" name="email" value=""> </legend>

      <legend for="major">Major:
      <input id = "email" type="text" name="email" value=""> </legend>

      <legend for="sequence">Sequence:
      <input id = "email" type="text" name="email" value=""> </legend> -->

  <br>
      <!-- Submit button  -->
      <p><input id = "submit" type="button" value="Submit"/></p>

      </form>

    </body>
</html>
