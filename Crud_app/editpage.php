<?php
include("header.php");
include('dbconn.php');

$id = $fname = $lname = $email = $contactNo = $birthdate = $gender = $courses = "";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);
    $query = "SELECT * FROM `student` WHERE `id` = '$id'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    } else {
        $row = mysqli_fetch_assoc($result);
        $fname = $row['FirstName'];
        $lname = $row['LastName'];
        $email = $row['Email'];
        $contactNo = $row['ContactNo'];
        $birthdate = $row['BirthDate'];
        $gender = $row['Gender'];
        $courses = $row['Course'];
    }
}

if (isset($_POST['update_student'])) {

    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];
    $email = $_POST['email'];
    $contactNo = $_POST['contactNo'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $courses = isset($_POST['courses']) ? $_POST['courses'] : '';

    // Check for duplicate course entry
    if (!empty($courses)) {
        $check_query = "SELECT id FROM student WHERE Course='$courses' AND id != '$id'";
        $check_result = mysqli_query($connection, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            die("Error: Course is already assigned to another student.");
        }
    }

    // Modify the update query to conditionally include the Course column
    if (!empty($courses)) {
        $query = "UPDATE `student` SET `FirstName`='$fname', `LastName`='$lname', `Email`='$email', `ContactNo`='$contactNo', `BirthDate`='$birthdate', `Gender`='$gender', `Course`='$courses' WHERE `id`='$id'";
    } else {
        $query = "UPDATE `student` SET `FirstName`='$fname', `LastName`='$lname', `Email`='$email', `ContactNo`='$contactNo', `BirthDate`='$birthdate', `Gender`='$gender' WHERE `id`='$id'";
    }

    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    } else {
        header('location:viewpage.php?update_msg=you have updated successfully');
        exit();
    }
}
?>

<div class="box">
    <div class="container">
        <form action="editpage.php?id=<?php echo $id; ?>" method="post">
            <div class="modal-content">
                <div class="col-sm">
                    <div class="modal-header">
                        <h1 class="modal-title fs-2" id="exampleModalLabel">Edit Student</h1>
                    </div>
                    <br>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="f_name">FirstName:</label>
                            <input type="text" name="f_name" class="form-control" value="<?php echo $fname; ?>"><br>
                        </div>

                        <div class="form-group">
                            <label for="l_name">LastName:</label>
                            <input type="text" name="l_name" class="form-control" value="<?php echo $lname; ?>"><br>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>"><br>
                        </div>
                        <div class="form-group">
                            <label for="contactNo">ContactNo:</label>
                            <input type="number" name="contactNo" class="form-control" value="<?php echo $contactNo; ?>"><br>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">BirthDate:</label>
                            <input type="date" name="birthdate" class="form-control" value="<?php echo $birthdate; ?>"><br>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <input type="radio" name="gender" value="Female" <?php if ($gender == "Female") echo "checked"; ?>> Female
                            <input type="radio" name="gender" value="Male" <?php if ($gender == "Male") echo "checked"; ?>> Male
                            <input type="radio" name="gender" value="Other" <?php if ($gender == "Other") echo "checked"; ?>> Other<br>
                        </div>

                        <div class="form-group">
                            <label for="courses">Select course:</label>
                            <select name="courses" class="form-control">
                                <?php
                                include('dbconn.php');
                                $query = "SELECT id, CourseName FROM `courses`";
                                $result = mysqli_query($connection, $query);

                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <option value="<?php echo $row['id']; ?>" <?php if ($courses == $row['id']) echo 'selected="selected"'; ?>><?php echo $row['CourseName']; ?></option>
                                <?php
                                    }
                                    mysqli_free_result($result);
                                } else {
                                    echo "Error: " . mysqli_error($connection);
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><br>
                    <input id="btn-Add" type="submit" class="btn btn-primary" name="update_student" value="Update">
                </div>
            </div>
        </div>
    </form>
</div>
</div>

