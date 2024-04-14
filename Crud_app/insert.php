<?php
include('dbconn.php');

if (isset($_POST['add_student'])) {
  $fname = $_POST['f_name'];
  $lname = $_POST['l_name'];
  $email = $_POST['email'];
  $contactNo = $_POST['contactNo'];
  $birthdate = $_POST['birthdate'];
  $gender = $_POST['gender'];
  $courses = $_POST['courses'];

  // Validations for input fields
  if (empty($fname) || empty($lname) || empty($email) || empty($contactNo) || empty($birthdate) || empty($gender) || empty($courses)) {
    header('Location: viewpage.php?message=All fields are required!');
    exit();
  }

  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: viewpage.php?message=Invalid email address!');
    exit();
  }

  // Validate contact number
  $contactNo = preg_replace("/[^0-9]/", "", $contactNo);
  if (strlen($contactNo) != 10) {
    header('Location: viewpage.php?message=Contact number must have exactly 10 digits!');
    exit();
  }

  // Validate birthdate
  $birthdateTimestamp = strtotime($birthdate);
  if ($birthdateTimestamp === false || $birthdateTimestamp > time()) {
    header('Location: viewpage.php?message=Invalid birthdate!');
    exit();
  }

  // Check if the email already exists in the database
  $query = "SELECT * FROM `student` WHERE `Email` = '$email'";
  $result = mysqli_query($connection, $query);
  if (mysqli_num_rows($result) > 0) {
    header('Location: viewpage.php?message=This email address is already registered!');
    exit();
  }

  // Check if the student is already enrolled in the selected course
  $query = "SELECT * FROM `student` WHERE `Course` = '$courses'";
  $result = mysqli_query($connection, $query);
  if (mysqli_num_rows($result) > 0) {
    header('Location: viewpage.php?message=This student is already enrolled in the selected course!');
    exit();
  }

  // Insert data into the database
  $query = "INSERT INTO `student` (`FirstName`, `LastName`, `Email`, `ContactNo`, `BirthDate`, `Gender`, `Course`) VALUES ('$fname', '$lname', '$email', '$contactNo', '$birthdate', '$gender', '$courses')";
  $result = mysqli_query($connection, $query);

  if (!$result) {
    die("Query failed: " . mysqli_error($connection));
  } else {
    header('Location: viewpage.php?insert_msg=Your data has been added successfully');
    exit();
  }
}
?>
