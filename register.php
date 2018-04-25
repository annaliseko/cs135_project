<?php
require 'dbconn.php';
$connection = connect_to_db("sequence");
// $query = "SELECT * FROM Students";
// $result = perform_query($connection, $query);
// $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
// echo "<pre>"; print_r($row); echo "</pre>";
//
// function get_enum_values($conn, $table, $field )
// {
//     $type = perform_query($conn, "SHOW COLUMNS FROM $table WHERE Field = '$field'")[0]["Type"];
//     $result = mysqli_fetch_array($type, MYSQLI_ASSOC);
//     // preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
//     // $enum = explode("','", $matches[1]);
//     return $result;
// }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <title>Register</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="newvalidate.js"></script>

  <!-- DROPDOWN MENUS (move this later to appropriate part in form)-->
<?php
// $testing = get_enum_values($connection, 'Students', 'college');
// var_dump($testing);
// print_r($testing);


      $col_result = mysqli_query($connection, "SELECT DISTINCT college FROM Students");
      $college="<select>";
      while ($row = mysqli_fetch_array($col_result)) {
      $college .= "<option value='" . $row['college'] . "'>" . $row['college'] . "</option>";
      }
      $college .= '</select>';

      $m_result = mysqli_query($connection, "SELECT DISTINCT m_name FROM Major");
      $major="<select>";
      while ($row = mysqli_fetch_array($m_result)) {
        $major .= "<option value='" . $row['m_name'] . "'>" . $row['m_name'] . "</option>";
      }
      $major .= '</select>';

      $q_result = mysqli_query($connection, "SELECT DISTINCT q_name FROM Sequence");
      $sequence="<select>";
      while ($row = mysqli_fetch_array($q_result)) {
        $sequence .= "<option value='" . $row['q_name'] . "'>" . $row['q_name'] . "</option>";
      }
      $sequence .= '</select>';
    ?>
    </head>
<body>
      <h1> Register </h1>
      <form name="register" method="post">

      <b> Information: </b>

      <!-- Username, password, phone number, email input fields -->
      <legend for="studentid">Student ID:
      <input id = "student" type="text" name="studentid" value="">
      <span style="display:none"></span></legend>

      <legend for="firstname">First Name:
      <input id = "firstname" type="firstname" name="firstname" value="">
      <span style="display:none"></span></legend>

      <legend for="lastname">Last Name:
      <input id = "lastname" type="lastname" name="lastname" value="">
      <span style="display:none"></span></legend>

      <legend for="password">Password:
      <input id = "password" type="password" name="password" value="">
      <span style="display:none"></span></legend>

      <legend for="college">College:
      <input id = "email" type="text" name="email" value=""> </legend>

      <legend for="grad">Expected Graduation Year:
      <input id = "email" type="text" name="email" value=""> </legend>

      <legend for="major">Major:
      <input id = "email" type="text" name="email" value=""> </legend>

      <legend for="sequence">Sequence:
      <input id = "email" type="text" name="email" value=""> </legend>

  <br>
      <!-- Submit button  -->
      <p><input id = "submit" type="button" value="Submit"/></p>

      </form>

    </body>
</html>
