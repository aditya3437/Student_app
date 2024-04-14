<?php

include('dbconn.php');

$limit = 5;
$page_number = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

// Form processing and filtering
if (isset($_POST['filtered'])) {
    $firstname = $_POST['f_name'];
    $course = isset($_POST['courses']) ? $_POST['courses'] : '';

    // Build the query based on the provided filters
    $query = "SELECT * FROM student";
    $whereClause = "";
    $filters = array();

    // Filter by first name
    if (!empty($firstname)) {
        $filters[] = "FirstName LIKE '%$firstname%'";
    }

    // Filter by course
    if (!empty($course)) {
        $filters[] = "Course = '$course'";
    }

    // Construct the WHERE clause
    if (!empty($filters)) {
        $whereClause = " WHERE " . implode(" AND ", $filters);
    }

    // Finalize the query
    $query .= $whereClause;

    // Fetch distinct first names if filtered by first name
    $distinct_first_names = array();
    if (!empty($firstname)) {
        $distinct_query = "SELECT DISTINCT FirstName  FROM student WHERE FirstName LIKE '%$firstname%'";
        $distinct_result = mysqli_query($connection, $distinct_query);
        if ($distinct_result) {
            while ($row = mysqli_fetch_assoc($distinct_result)) {
                $distinct_first_names[] = $row['FirstName'];
            }
            mysqli_free_result($distinct_result);
        } else {
            echo "Error fetching distinct first names: " . mysqli_error($connection);
        }
    }

    $filterApplied = true;
} else {
    $query = "SELECT * FROM student";
    $filterApplied = false;
}

// Pagination calculation
$result = mysqli_query($connection, $query);
$total_rows = mysqli_num_rows($result);
$total_pages = ceil($total_rows / $limit);
$offset = ($page_number - 1) * $limit;

// Retrieve data based on query and pagination
$getQuery = $query . " ORDER BY id DESC LIMIT " . $offset . ',' . $limit;
$result = mysqli_query($connection, $getQuery);

// Display the retrieved results on the webpage  
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td>" . $row['ContactNo'] . "</td>";
    echo "<td>" . $row['BirthDate'] . "</td>";
    echo "<td>" . $row['Gender'] . "</td>";

    // Fetching course name as before
    echo "<td>";
    if ($row['Course'] != '') {
        $course_query = "SELECT CourseName FROM `Courses` WHERE id = '{$row['Course']}'";
        $result_course = mysqli_query($connection, $course_query);
        if ($result_course && mysqli_num_rows($result_course) > 0) {
            $course_row = mysqli_fetch_assoc($result_course);
            echo $course_row['CourseName'];
            mysqli_free_result($result_course);
        } else {
            echo "Error fetching course: " . mysqli_error($connection);
        }
    }
    echo "</td>";

    echo "<td><a href='deletepage.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td>";
    echo "<td><a href='editpage.php?id=" . $row['id'] . "' class='btn btn-success'>Edit</a></td>";
    echo "</tr>";
}

// Pagination links
echo "<div class='pagination'>";
if ($page_number > 1) {
    echo "<a class='btn btn-primary' href='viewpage.php?page=" . ($page_number - 1) . "'> Prev </a>";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page_number) {
        echo "<a class='btn btn-success' href='viewpage.php?page=" . $i . "'>" . $i . " </a>";
    } else {
        echo "<a href='viewpage.php?page=" . $i . "'>" . $i . " </a>";
    }
}

if ($page_number < $total_pages) {
    echo "<a class='btn btn-primary' href='viewpage.php?page=" . ($page_number + 1) . "'>Next </a>";
}

echo "</div>";

// Form for filtering
?>

<form action="" method="post">
    <div class="formstable">
        <div class="col-md-2">
            <input placeholder="firstname" type="text" name="f_name" class="form-control" value="">
            <br>
        </div>
        <div class="col-md-2">
            <select name="courses" class="form-select">
                <option value="">None</option>
                <?php
                $courseQuery = "SELECT id, CourseName FROM `Courses`";
                $courseResult = mysqli_query($connection, $courseQuery);

                if ($courseResult) {
                    while ($courseRow = mysqli_fetch_assoc($courseResult)) {
                        ?>
                        <option value="<?php echo $courseRow['id']; ?>"><?php echo $courseRow['CourseName']; ?></option>
                        <?php
                    }
                    mysqli_free_result($courseResult);
                } else {
                    echo "Error: " . mysqli_error($connection);
                }
                ?>
            </select>
        </div>

        <div class="col-md-1">
            <button name="filtered" type="submit" class="btn btn-primary">Filter</button>
        </div>

        <div class="col-md-2">
            <a href="viewpage.php" class="btn btn-danger">Reset</a>
        </div>
    </div>
</form>

<?php
// Display all first names if filtered by first name
if ($filterApplied && !empty($distinct_first_names)) {
    echo "Similar first names: " . implode(", ", $distinct_first_names);
} elseif (!$filterApplied) {
    echo "No filters applied.";
} else {
    echo "Something went wrong!!";
}
?>
