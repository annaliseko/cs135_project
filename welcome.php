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

.error {
  font-weight: bold;
  color: red;
}

</style>
    <?php
      ///////////////////////////////////
      // REGISTER POSTING TO DATABASE ///
      ///////////////////////////////////
        if(isset($_POST['submit'])) {
          $s_id = $_POST['studentid'];
          $firstname = $_POST['firstname'];
          $lastname = $_POST['lastname'];
          $pwd = $_POST['password'];
          $college = $_POST['college'];
          $grad = $_POST['gradyear'];
          $major = $_POST['major'];
          $sequence = $_POST['sequence'];

        $user = $firstname . " " . $lastname;
        $_SESSION['student'] = $user;
        $_SESSION['major'] = $major;
        $_SESSION['sequence'] = $sequence;
        $_SESSION['id'] = $s_id;


        // do a select query on table Major to get the m_id based on the variable $major
        // select m_id from Major where  m_name = $major
        // the query will return a result, and you should store result in a variable called $m_id
        $mquery = "SELECT m_id FROM Major where m_name = '$major'";
        $mresult = perform_query($connection, $mquery);
        $arrthing = Array();
        while ($row = mysqli_fetch_array ($mresult, MYSQLI_ASSOC)){
          $arrthing[] =  $row['m_id'];
        }
        $m_id=implode(", ",$arrthing);
        $_SESSION['m_id'] = $m_id;

        mysqli_stmt_execute($selectStudent);
        if($selectStudent ->fetch()) {
         echo "There is already an account with your student ID. If you think this is a mistake, please contact admin.";
        }
        else {
          mysqli_stmt_execute($insertStudent);
          mysqli_stmt_insert_id($insertStudent);
        }
        mysqli_stmt_close($selectStudent);
        mysqli_stmt_close($insertStudent);
        }


        ////////////////////////////////
        // LOGIN CHECK WITH DATABASE ///
        ////////////////////////////////
        if(isset($_POST['login'])) {
          $s_id = $_POST['sid'];
          $pwd = $_POST['pwd'];

          mysqli_stmt_execute($selectLogin);
          if($selectLogin ->fetch()) {
            while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)){
              $firstname = $row['firstname'];
              $lastname = $row['lastname'];
              $grad = $row['grad'];
              $major = $row['major'];
              $m_id = $row['m_id'];
              $sequence = $row['sequence'];
            }
            $user = $firstname . " " . $lastname;
            $_SESSION['student'] = $user;
            $_SESSION['major'] = $major;
            $_SESSION['sequence'] = $sequence;
            $_SESSION['id'] = $s_id;
            $_SESSION['m_id'] = $m_id;
          }
          else {
            mysqli_stmt_execute($selectLogin);
            echo "<div class='error'>Invalid Login Credentials</div>";
          }
          mysqli_stmt_close($selectLogin);
      }
      ?>

    <?php
      ///////////////////////////////
      // DROPDOWN FOR ENUM VALUES ///
      ///////////////////////////////
      $col_result = mysqli_query($connection, "SELECT DISTINCT college FROM Students");
      $college="<select name='college'>";
      while ($row = mysqli_fetch_array($col_result)) {
      $college .= "<option value='" . $row['college'] . "'>" . $row['college'] . "</option>";
      }
      $college .= '</select>';

      $m_result = mysqli_query($connection, "SELECT DISTINCT m_name FROM Major");
      $major="<select name='major'>";
      while ($row = mysqli_fetch_array($m_result)) {
        $major .= "<option value='" . $row['m_name'] . "'>" . $row['m_name'] . "</option>";
      }
      $major .= '</select>';

      $q_result = mysqli_query($connection, "SELECT DISTINCT q_name FROM Sequence");
      $sequence="<select name='sequence'>";
      while ($row = mysqli_fetch_array($q_result)) {
        $sequence .= "<option value='" . $row['q_name'] . "'>" . $row['q_name'] . "</option>";
      }
      $sequence .= '</select>';
    ?>

</head>

<body>

<ul>
  <?php if(isset($_SESSION['student'])){ ?>
    <li><a class="link" href="logout.php">Logout</a></li>
    <li><a href="myprogress.php">My Progress</a></li>
    <li><a href="Major.php">Major</a></li>
    <li><a href="http://catalog.claremontmckenna.edu/">Courses</a></li>
<?php }
else{ ?>
  <li><a class="link" href="welcome.php">Login</a></li>
<?php } ?>
</ul>
    <center>
      <?php if(!isset($_SESSION['student'])){ ?>
        <h1>Welcome to the Sequence Tracker!</h1>
        <div>
        <form name="login" method="post">
        <legend for="sid">Student ID:
            <input type="text" name="sid" value="">
            <span style="display:none"></span></legend>
        <legend for="pwd"> Password:
                <input type="pwd" name="pwd" value="">
                <span  style="display:none"> </span> </legend>
        <input id = "login" type="submit" name="login" value="Log In"/>
        </div>
        <div>
        </div>
    </center>

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
  }
  </script>
    <center>
      <h1> Register </h1>
      <form name="register" method="post" onsubmit="return validateForm()">

      <!-- Username, password, phone number, email input fields -->
      <legend for="studentid">Student ID:
      <input id = "studentid" type="text" name="studentid" value="">
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
      <?php echo $college ?>
      <span style="display:none"></span>

      <legend for="grad">Expected Graduation Year:
      <input id = "gradyear" type="text" name="gradyear" value="">
      <span style="display:none"></span>

      <legend for="major">Major:
      <?php echo $major ?>
      <span style="display:none"></span>

      <legend for="sequence">Sequence:
      <?php echo $sequence ?>
      <span style="display:none"></span>

  <br>
      <!-- Submit button  -->
      <p><input id = "submit" type="submit" name="submit" value="Submit"/></p>

      </form>
    <?php } else {?>
    <h1> Welcome <?php echo $_SESSION['student']; ?> !</h1>
    <h3> Student ID: <?php echo $_SESSION['id']; ?> </br>
      Major: <?php echo $_SESSION['major']; ?> </br>
      Sequence: <?php echo $_SESSION['sequence']; ?> </h3>
    <?php } ?>
      </center>


</body>


</html>
