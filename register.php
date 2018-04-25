<?php
require 'dbconn.php';
$connection = connect_to_db("sequence");
require 'queries.php'

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

      <?php
      // Submit to database
        if(isset($_POST['submit'])) {
          $s_id = $_POST['studentid'];
          $firstname = $_POST['firstname'];
          $lastname = $_POST['lastname'];
          $pwd = $_POST['password'];
          $college = $_POST['college'];
          $grad = $_POST['gradyear'];
          $major = $_POST['major'];
          $sequence = $_POST['sequence'];

        mysqli_stmt_execute($selectStudent);
        print_r($connection->error);
        $selectStudent -> bind_result($s_id);
        if($selectStudent ->fetch()) {
          $idmessage = "Welcome $firstname $lastname ($s_id)! <br>";
        }
        else {
          mysqli_stmt_execute($insertStudent);
          print_r($connection->error);

          $cid = mysqli_stmt_insert_id($insertStudent);
          $idmessage = "There is already an account with your student ID. If you think this is a mistake, please contact admin.";
        }
        echo $idmessage;
        mysqli_stmt_close($selectStudent);
        mysqli_stmt_close($insertStudent);
        }
      ?>

<?php
// $testing = get_enum_values($connection, 'Students', 'college');
// var_dump($testing);
// print_r($testing);

      //  DROPDOWN MENUS (just the setup, the output is with the form)
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
  <script>
  function validateForm() {
      var s_id = document.forms["register"]["studentid"].value;
      var firstname = document.forms["register"]["firstname"].value;
      var lastname = document.forms["register"]["lastname"].value;
      var pwd = document.forms["register"]["password"].value;
      var grad = document.forms["register"]["gradyear"].value;

      if (!s_id || !firstname || !lastname || !pwd || !grad) {
          alert("Missing one or more required fields");
          return false;
      }
      else { return true; }
  }
  </script>

      <h1> Register </h1>
      <form name="register" method="post" onsubmit="return validateForm()">

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
      <id = "college" name="college"><?php echo $college ?>
      <span style="display:none"></span>

      <legend for="grad">Expected Graduation Year:
      <input id = "gradyear" type="text" name="gradyear" value="">
      <span style="display:none"></span>

      <legend for="major">Major:
      <id = "major" name="major"><?php echo $major ?>
      <span style="display:none"></span>

      <legend for="sequence">Sequence:
      <id = "sequence" name="sequence"><?php echo $sequence ?>
      <span style="display:none"></span>

  <br>
      <!-- Submit button  -->
      <p><input id = "submit" type="submit" name="submit" value="Submit"/></p>

      </form>

    </body>
</html>
