<?php
require_once 'inc/connection.php';
require_once 'inc/header.php';


?>
<div class="banner header-text">
    <div class="owl-banner owl-carousel">
        <div class="banner-item-01">
            <div class="text-content">
             
            </div>
        </div>
        <div class="banner-item-02">
            <div class="text-content">
               
            </div>
        </div>
        <div class="banner-item-03">
            <div class="text-content">
             
            </div>
        </div>
    </div>
</div>

<?php
$limit = 3;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$total_records_query = "SELECT COUNT(*) as total FROM `posts`";
$total_records_result = mysqli_query($con, $total_records_query);
$total_records = mysqli_fetch_assoc($total_records_result)['total'];
$total_pages = ceil($total_records / $limit);

if ($page > $total_pages || $page < 0) {
    header("location:index.php");
    exit(); 
}

$offset = ($page - 1) * $limit;

$query = "SELECT `id`, `title`, `image`, SUBSTRING(`body`, 1, 53) AS body, `created_at` FROM `posts` LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);
?>

<?php if (mysqli_num_rows($result) > 0) : ?>
    <div class="latest-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Latest Posts</h2>
                    </div>
                </div>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="col-md-4">
                        <div class="product-item">
                            <a href="#"><img src="upload/<?php echo $row['image'] ?>" width="100" height="200" alt=""></a>
                            <div class="down-content">
                                <a href="#"><h4><?php echo $row['title']; ?></h4></a>
                                <h6><?php echo $row['created_at']; ?></h6>
                                <p><?php echo $row['body'] . "..."; ?></p>

                                <div class="d-flex justify-content-end">
                                    <a href="viewPost.php?id=<?php echo $row['id'] ?>" class="btn btn-info ">view</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="container">
        <p>No posts found</p>
    </div>
<?php endif; ?>

<div class="container d-flex justify-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item"><a class="page-link text-danger" href="?page=<?php echo ($page - 1); ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item"><a class="page-link<?php echo ($i == $page) ? " active" : ""; ?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>

            <?php if ($page < $total_pages) : ?>
                <li class="page-item"><a class="page-link text-success" href="?page=<?php echo ($page + 1); ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php require_once 'inc/footer.php'; ?>
