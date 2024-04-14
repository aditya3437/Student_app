<?php

include("dbconn.php");

$query = "SELECT * FROM courses";
$result = mysqli_query($connection, $query);

?>
<div class="container">
 <div class="row">
 <div class="col-md-15">
<div class="box1">
    <tbody>
    <?php include("coursePagination.php"); ?>
    </tbody>
    
  <?php
  if (isset($_GET['message'])) {
    echo "<h6>" . $_GET['message'] . "</h6>";
  }
  ?>
  <?php
  if (isset($_GET['insert_msg'])) {
    echo "<h6>" . $_GET['insert_msg'] . "</h6>";
  }
  ?>
  <?php
  if (isset($_GET['update_msg'])) {
    echo "<h6>" . $_GET['update_msg'] . "</h6>";
  }
  ?>
  <?php
  if (isset($_GET['deleted_msg'])) {
    echo "<h6>" . $_GET['deleted_msg'] . "</h6>";
  }
  ?>
</div>
</div>
 </div>
</div>
