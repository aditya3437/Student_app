<?php
include("dbconn.php");

if(isset($_GET['id'])){
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($connection, $_GET['id']);
    $query = "DELETE FROM `courses` WHERE `id` = '$id'";
    $result = mysqli_query($connection, $query);
    
    if(!$result){
        die("Query failed: " . mysqli_error($connection));
    }
    else{
        header('location:coursepage.php?deleted_msg=you have deleted the record.');
        exit(); // Ensure script stops execution after redirection
    }
}
?>