<?php
require_once "../inc/connection.php";
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM posts WHERE id = $id";
    $runQuery = mysqli_query($con , $query);
    if (mysqli_num_rows($runQuery) == 1) {
        $post = mysqli_fetch_assoc($runQuery);
        if (!empty($post)) {
            unlink("../upload/" .$post['image']);
        }

        $deleteQuery = "DELETE FROM posts WHERE id = $id";
        $result = mysqli_query($con , $deleteQuery);

    if ($result) {
        echo "<script>alert('Post deleted successfully!')</script>";
        echo "<script>window.location.href='../index.php';</script>";
        exit();
        
    }else{
        echo "<script>alert('Error while deleting')</script>";
        echo "<script>window.location.href='../index.php';</script>";
    }
}
}else{
    header("location:../index.php");
}
?>