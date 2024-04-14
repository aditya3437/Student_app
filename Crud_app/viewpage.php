<?php include("header.php"); ?>
<?php include("dbconn.php"); ?>
    
<div class="container">
    <div class="row">
        <div class="col-md-15">
        <div class="box1">
            <a href="coursePage.php">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Course view</button>
            </a>
            <a href="viewpage.php">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Student view</button>
            </a>
            <a href="addStudent.php">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Student</button>
            </a>
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>Email</th>
                        <th>ContactNo</th>
                        <th>BirthDate</th>
                        <th>Gender</th>
                        <th>Course</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include('pagination.php'); ?>
                </tbody>
            </table>

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
            if (isset($_GET['delete_msg'])) {
                echo "<h6>" . $_GET['delete_msg'] . "</h6>";
            }
            ?>
        </div>

    </div>
</div>
</div>

