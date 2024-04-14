<?php
include("courseHeader.php");
include("dbconn.php");

$id = $courses = "";

if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($connection, $_GET['id']);
  $query = "SELECT * FROM `courses` WHERE `id` = '$id'";
  $result = mysqli_query($connection, $query);

  if (!$result) {
      die("Query failed" . mysqli_error($connection, $query));
  } else {
      $row = mysqli_fetch_assoc($result);
      $courses = $row['CourseName'];
  }
}

if (isset($_POST['update_course'])) {
  $id = $_POST['id'];
  $coursename = isset($_POST['courses']) ? $_POST['courses'] : ''; // handle empty or null values

  if (empty($coursename)) {
    echo "Course name cannot be empty!";
  } else {
    $check_query = "SELECT * FROM `courses` WHERE `CourseName`='$coursename' AND `id` != '$id'";
    $check_result = mysqli_query($connection, $check_query);
  
    if(mysqli_num_rows($check_result) > 0) {
      echo "Course name already exists!";
    } else {
      $query = "UPDATE `courses` SET `CourseName`='$coursename' WHERE `id`='$id'";
      $result = mysqli_query($connection, $query);

      if (!$result) {
        echo "Failed to update course";
      } else {
        header("Location: coursePage.php?update_msg=Course updated successfully");
        exit();
      }
    }
  }
}
?>

<div class="box">
  <div class="container">
    <form action="coursePage.php" method="post">
      <div class="modal-content">
        <div class="col-sm">
          <div class="modal-header">
            <h1 class="modal-title fs-2" id="exampleModalLabel">Edit course</h1>
          </div>
          <br>
          <div class="form-group">
            <label for="courses">Select course:</label>
            <input type="text" name="courses" class="form-control" value="<?php echo $courses; ?>"><br>
          </div>
        </div>
        <div class="modal-footer"><br>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input id="btn-Add" type="submit" class="btn btn-primary" name="update_course" value="Update">
        </div>
      </div>
    </form>
  </div>
</div>
