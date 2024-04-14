<?php include("courseHeader.php"); ?>
<div class="box">
  <div class="container">
    <form action="insertCourse.php" method="post">
      <div class="modal-content">
        <div class="col-sm">
          <div class="modal-header">
            <h1 class="modal-title fs-2" id="exampleModalLabel">Add course</h1>
          </div>
          <br>
          <div class="form-group">
            <label for="courses">Select course:</label>
            <input type="text" name="courses" class="form-control" value="">
          </div>
        </div>
        <div class="modal-footer"><br>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input id="btn-Add" type="submit" class="btn btn-primary" name="add_course" >
        </div>
      </div>
    </form>
  </div>
</div>
