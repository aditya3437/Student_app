<?php
include('dbconn.php');

if(isset($_POST['add_course'])) {
  $courses = $_POST['courses'];

  if(empty($courses)) {
    header('Location: coursePage.php?message=You need to fill in the course name!');
    exit();
  }

  // Check if the course already exists
  $check_query = "SELECT * FROM courses WHERE CourseName = '$courses'";
  $check_result = mysqli_query($connection, $check_query);
  if(mysqli_num_rows($check_result) > 0) {
    header('Location: coursePage.php?message=Course already exists!');
    exit();
  }

  $query = "INSERT INTO `courses` (`CourseName`) VALUES ('$courses')";
  $result = mysqli_query($connection, $query);
  
  if(!$result) {
    die("Query failed: " . mysqli_error($connection));
  } else {
    header('Location: coursePage.php?insert_msg=Your data has been added successfully');
    exit();
  }
}
?>
