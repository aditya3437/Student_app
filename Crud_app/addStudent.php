<?php
include("header.php");
?>
<div class="box">
  <div class="container">
    <form action="insert.php" method="post">
      <div class="modal-content">
        <div class="col-sm">
          <div class="modal-header">
            <h1 class="modal-title fs-2" id="exampleModalLabel">Add Student</h1>
          </div>
          <br>
          <div class="modal-body">
            <div class="form-group">
              <label for="f_name">FirstName:</label>
              <input type="text" name="f_name" class="form-control" value=""><br>
            </div>

            <div class="form-group">
              <label for="l_name">LastName:</label>
              <input type="text" name="l_name" class="form-control" value=""><br>
            </div>

            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" name="email" class="form-control" value=""><br>
            </div>
            <div class="form-group">
              <label for="contactNo">ContactNo:</label>
              <input type="number" name="contactNo" class="form-control" value=""><br>
            </div>
            <div class="form-group">
              <label for="birthdate">BirthDate:</label>
              <input type="date" name="birthdate" class="form-control" value=""><br>
            </div>
            <div class="form-group">
              <label for="gender">Gender:</label>
              <input type="radio" name="gender" value="Female"> Female
              <input type="radio" name="gender" value="Male"> Male
              <input type="radio" name="gender" value="Other"> Other<br><br>
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
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['CourseName']; ?></option>
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
          <div class="modal-footer">
            <input id="btn-Add" type="submit" class="btn btn-primary" name="add_student">
          </div>
        </div>
      </div>
  </div>
</div>
</div>