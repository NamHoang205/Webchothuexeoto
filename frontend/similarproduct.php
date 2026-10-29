<?php


// Initialize $id_product as null or a default value
$id_product = null;
if (isset($_GET['tbl_category']) && isset($_GET['id'])) {
    $id_category = mysqli_real_escape_string($mysqli, $_GET['tbl_category']);
    $id_product = mysqli_real_escape_string($mysqli, $_GET['id']); // Set the $id_product variable
} else {
    $id_category = '';
}

// SQL Query to join product and tbl_category based on category_id
$sql_products = mysqli_query($mysqli, "
    SELECT p.*, c.category_name 
    FROM product p
    JOIN tbl_category c ON p.category_id = c.category_id
    WHERE p.category_id = '$id_category' 
    " . ($id_product ? "AND p.product_id != '$id_product'" : "") . " 
    LIMIT 4
");

// Check for query error
if (!$sql_products) {
    echo "Error: " . mysqli_error($mysqli);
    exit;
}
?>


<div class="container d-flex justify-content-center mt-50 mb-50">
    <div class="row col-12 text-roboto">
        <?php
        // Loop through products and display them
        while ($row_product = mysqli_fetch_array($sql_products)) {
        ?>
            <div class="col-md-3 col-sm-12 mt-2">
                <div class="card text-center">
                    <div class="card-body">
                        <a href="?quanli=chitietsp&id=<?php echo $row_product['product_id'] ?>&category=<?php echo $row_product['category_id'] ?>" class="card-img-actions">
                            <img src="images/<?php echo $row_product['product_image'] ?>" class="card-img img-fluid" width="96" height="350" alt="">
                        </a>
                    </div>

                    <div class="card-body bg-light text-center">
                        <div class="item-info-product mb-2">
                            <h4 class="pt-1">
                                <a href="?quanli=chitietsp&id=<?php echo $row_product['product_id'] ?>&category=<?php echo $row_product['category_id'] ?>" class="card-img-actions">
                                    <?php echo $row_product['product_name'] ?>
                                </a>
                            </h4>
                        </div>

                        <div class="info-product-price my-2">
                            <!-- Display the release year and author information -->
                            <p class="release-year"><strong>Năm phát hành: </strong><?php echo $row_product['release_year'] ?></p>
                            <p class="author-name"><strong>Tác giả: </strong><?php echo $row_product['author_name'] ?></p>
                        </div>

                        <form action="?quanli=giohang" method="post">
                            <input type="hidden" name="tensanpham" value="<?php echo $row_product['product_name'] ?>" />
                            <input type="hidden" name="sanpham_id" value="<?php echo $row_product['product_id'] ?>" />
                            <input type="hidden" name="hinhanh" value="<?php echo $row_product['product_image'] ?>" />
                            <input type="hidden" name="soluong" value="1" />

                            <button type="submit" name="themgiohang" class="btn bg-cart"><i class="fa fa-cart-plus mr-2"></i> Thêm vào giỏ</button>
                        </form>

                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
