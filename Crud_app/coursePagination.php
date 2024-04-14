<?php
include("courseHeader.php");
include("dbconn.php");

$limit = 5;

// Get total number of rows
$query = "SELECT COUNT(*) as total FROM courses";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$total_rows = $row['total'];

// Calculate total pages
$total_pages = ceil($total_rows / $limit);

// Get current page number
$page_number = isset($_GET['page']) ? $_GET['page'] : 1;
$page_number = max(1, min($page_number, $total_pages));

// Calculate offset
$offset = ($page_number - 1) * $limit;

// Fetch data for the current page
$query = "SELECT * FROM courses ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($connection, $query);

?>
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
                <a href="addCourse.php">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Course</button>
                </a>
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course</th>
                            <th>View</th>
                            <th>Delete</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td>
                                    <?php echo !empty($row['CourseName']) ? $row['CourseName'] : ""; ?>
                                </td>
                                <td> <a href="coursePage.php?id=<?php echo $row['id']; ?>" class="btn btn-success">View</a></td>
                                <td> <a href="deletedCourse.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a></td>
                                <td> <a href="coursePagetxt.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Edit</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class='pagination'>
                    <?php
                    // Previous page button
                    if ($page_number > 1) {
                        echo "<a class='btn btn-primary' href='?page=" . ($page_number - 1) . "'> Prev </a>";
                    }

                    // Page numbers
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page_number) {
                            echo "<a class='btn btn-success' href='?page=" . $i . "'>" . $i . " </a>";
                        } else {
                            echo "<a href='?page=" . $i . "'>" . $i . " </a>";
                        }
                    }

                    // Next page button
                    if ($page_number < $total_pages) {
                        echo "<a class='btn btn-primary' href='?page=" . ($page_number + 1) . "'>Next </a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
