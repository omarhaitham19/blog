<?php require_once 'inc/connection.php' ?>
<?php require_once 'inc/header.php' ?>
 <!-- Page Content -->
 <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Edit Post</h4>
              <h2>edit your personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php

    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $query = "SELECT * from posts where id = $id";
      $result = mysqli_query($con , $query);
      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
      }else{
        header("location:index.php");
      }
    }else{
      header("location:index.php");
    }


    if (isset($_POST['submit'])) {
      function validate_input($input){
        $input = trim($input);
        $input = htmlspecialchars($input);
        $input = stripcslashes($input);
        return $input;
    }

    $title = mysqli_real_escape_string($con ,ucfirst(validate_input($_POST['title'])));
    $body = mysqli_real_escape_string($con , validate_input($_POST['body']));
    $img = $_FILES['image'];
    $img_name = mysqli_real_escape_string($con , $_FILES['image']['name']);
    $img_tmp = $_FILES['image']['tmp_name'];
    $img_size = $_FILES['image']['size'];
    $ImgExten =strtolower(pathinfo($img_name , PATHINFO_EXTENSION));
    $extensions = ['jpg' , 'jpeg' , 'png'];
    $dir = 'upload/';

    $errors = [];

    if (empty($title)) {
        $errors['title'] = "title is required";
    } elseif (is_numeric($title)) {
        $errors['title'] = "Only letters and White space are allowed";
      } 

      if (empty($body)) {
        $errors['body'] = "body is required";
    } elseif (is_numeric($body)) {
        $errors['body'] = "Only letters and White space are allowed";
      } 

      $query = "SELECT `id`,  `image` FROM `posts` WHERE `id` = $id";
      $result = mysqli_query($con , $query);
      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $oldImage = $row['image'];

        if (!empty($_FILES['image']['name'])) {
          if(!in_array($ImgExten , $extensions)){
            $errors['image'] = "Upload an image with an extension of jpg , jpeg or png";
          }elseif($img_size > 5000000){
            $errors['image'] = "Upload an image of maximum 5 megabyte";
            }
              $newName = uniqid() . "_" .  basename($img_name);
            
        }else{
          $newName = $oldImage;
        }

        if (empty($errors)) {

        $updateQuery = "UPDATE `posts` SET `title`='$title',`image`='$newName',`body`='$body' WHERE `id` = $id";
        $runQuery = mysqli_query($con , $updateQuery);
        if ($runQuery) {
          if (!empty($_FILES['image']['name'])) {
            unlink("upload/" . $oldImage);
            move_uploaded_file($img_tmp , $dir . $newName);
          }

          echo "<script>alert('Post updated successfully!')</script>";
          echo "<script>window.location.href='viewPost.php?id=$id';</script>";
          exit();


        }else{
          echo "<script>alert('Error while updating')</script>";
          echo "<script>window.location.href='index.php';</script>";
          exit();
        }

        }
      }else{
        header("location:index.php");
      }
    }
    ?>





<div class="container w-50 ">
<div class="d-flex justify-content-center">
    <h3 class="my-5">edit Post</h3>
  </div>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($row['title']) ? $row['title'] : null ?>">
            <span style="color: red;"> <?php echo isset($errors['title']) ? $errors['title'] : null ?> </span>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control" id="body" name="body" rows="5"><?php echo isset($row['body']) ? $row['body'] : null ?></textarea>
            <span style="color: red;"> <?php echo isset($errors['body']) ? $errors['body'] : null ?> </span>
          </div>
        <div class="mb-3">
            <label for="body" class="form-label">image</label>
            <input type="file" class="form-control-file" id="image" name="image" >
            <span style="color: red;"> <?php echo isset($errors['image']) ? $errors['image'] : null ?> </span>
          </div>
        <img src="upload/<?php echo $row['image'] ?>" alt="" width="100px" srcset="">
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>


<?php require_once 'inc/footer.php' ?>