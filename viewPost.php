<?php require_once 'inc/connection.php' ?>
<?php require_once 'inc/header.php' ?>

    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>View Post</h4>
              <h2>View personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $query = "SELECT users.name , posts.* from users join posts on users.id = posts.user_id where posts.id = $id";
      $result = mysqli_query($con , $query);
      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
      }else{
        header("location:index.php");
      }
    }else{
      header("location:index.php");
    }
    ?>

    <div class="best-features about-features">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Our post image</h2>
            </div>
          </div>
          <div class="col-md-6">
            <div class="right-image">
              <img src="upload/<?php echo $row['image'] ?>" alt="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="left-content">
              <h4><?php echo $row['title'] ?></h4>
              <p><?php echo $row['body'] ?></p>
              <p>Author: <?php echo $row['name'] ?></p>
              <?php
              if (isset($_SESSION['user_id'])) {
                ?>
              <div class="d-flex justify-content-center">
              <form action="editPost.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <button type="submit" name="delete" class="btn btn-success mr-3">Edit post</button>
                  </form>
              
                  <form action="handle/deletepost.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <button type="submit" name="delete" class="btn btn-danger" onclick="alert('Are you sure?')">Delete</button>
                  </form>
              </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
</div>

    <?php require_once 'inc/footer.php' ?>
