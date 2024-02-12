<?php require_once 'inc/connection.php' ?>
<?php require_once 'inc/header.php' ?>

    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>new Post</h4>
              <h2>add new personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
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

      if (empty($img_name)) {
        $errors['image'] = "Image is required";
        }elseif(!in_array($ImgExten , $extensions)){
         $errors['image'] = "Upload an image with an extension of jpg , jpeg or png";
       }elseif($img_size > 5000000){
          $errors['image'] = "Upload an image of maximum 5 megabyte";
        } 

        if (empty($errors)) {
            $imgNewName = uniqid() . "_" .  basename($img_name);
            $query = "INSERT INTO `posts`( `title`, `image`, `body`, `user_id`) 
            VALUES ('$title','$imgNewName','$body',1)";
            $runQuery = mysqli_query($con , $query);
            
            if ($runQuery) {
                move_uploaded_file($img_tmp , $dir . $imgNewName);
                echo "<script>alert('Post added successfully!')</script>";
                echo "<script>window.location.href='index.php';</script>";
                exit();
            }else{
              echo "<script>alert('An error occurred')</script>";
              echo "<script>window.location.href='index.php';</script>";
              exit();
            }
        }
    }
    ?>


<div class="container w-50 ">
  <div class="d-flex justify-content-center">
    <h3 class="my-5">add new Post</h3>
  </div>
  <form method="POST" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="">
        <span style="color: red;"> <?php echo isset($errors['title']) ? $errors['title'] : null ?> </span>
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Body</label>
        <textarea class="form-control" id="body" name="body"  rows="5"></textarea>
        <span style="color: red;"> <?php echo isset($errors['body']) ? $errors['body'] : null ?> </span>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">image</label>
        <input type="file" class="form-control-file" id="image" name="image" >
        <span style="color: red;"> <?php echo isset($errors['image']) ? $errors['image'] : null ?> </span>
    </div>
    <!-- <img src="uploads/<?php echo $post['image'] ?>" alt="" width="100px" srcset=""> -->
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </form>
</div>

    <?php require_once 'inc/footer.php' ?>
