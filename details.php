<?php

session_start();

include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");

?>

<?php

$product_id = @$_GET['pro_id'];

$get_product = "select * from products where product_url='$product_id'";

$run_product = mysqli_query($con,$get_product);

$check_product = mysqli_num_rows($run_product);

if($check_product == 0){
    echo "<script> window.open('index.php','_self') </script>";
} else {
    $row_product = mysqli_fetch_array($run_product);

    $p_cat_id = $row_product['p_cat_id'];
    $pro_id = $row_product['product_id'];
    $pro_title = $row_product['product_title'];
    $pro_price = $row_product['product_price'];
    $pro_desc = $row_product['product_desc'];
    $pro_img1 = $row_product['product_img1'];
    $pro_img2 = $row_product['product_img2'];
    $pro_img3 = $row_product['product_img3'];
    $pro_label = $row_product['product_label'];
    $pro_psp_price = $row_product['product_psp_price'];
    $pro_features = $row_product['product_features'];
    $pro_video = $row_product['product_video'];
    $status = $row_product['status'];
    $pro_url = $row_product['product_url'];

    if($pro_label == ""){
        // Do nothing
    } else {
        $product_label = "
        <a class='label sale' href='#' style='color:black;'>
        <div class='thelabel'>$pro_label</div>
        <div class='label-background'> </div>
        </a>
        ";
    }

    $get_p_cat = "select * from product_categories where p_cat_id='$p_cat_id'";
    $run_p_cat = mysqli_query($con,$get_p_cat);
    $row_p_cat = mysqli_fetch_array($run_p_cat);
    $p_cat_title = $row_p_cat['p_cat_title'];
?>

<main>
    <!-- HERO -->
    <div class="nero">
        <div class="nero__heading">
            <span class="nero__bold">Product </span>View
        </div>
        <p class="nero__text">
        </p>
    </div>
</main>

<div id="content"><!-- content Starts -->
    <div class="container"><!-- container Starts -->

        <div class="col-md-12"><!-- col-md-12 Starts -->
            <div class="row" id="productMain"><!-- row Starts -->
                <div class="col-sm-6"><!-- col-sm-6 Starts -->
                    <div id="mainImage"><!-- mainImage Starts -->
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators"><!-- carousel-indicators Starts -->
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                            </ol><!-- carousel-indicators Ends -->

                            <div class="carousel-inner"><!-- carousel-inner Starts -->
                                <div class="item active">
                                    <center>
                                        <img src="admin_area/product_images/<?php echo $pro_img1; ?>" class="img-responsive">
                                    </center>
                                </div>

                                <div class="item">
                                    <center>
                                        <img src="admin_area/product_images/<?php echo $pro_img2; ?>" class="img-responsive">
                                    </center>
                                </div>

                                <div class="item">
                                    <center>
                                        <img src="admin_area/product_images/<?php echo $pro_img3; ?>" class="img-responsive">
                                    </center>
                                </div>
                            </div><!-- carousel-inner Ends -->

                            <a href="#myCarousel" class="left carousel-control" data-slide="prev"><!-- left carousel-control Starts -->
                                <span class="glyphicon glyphicon-chevron-left"> </span>
                                <span class="sr-only"> Previous </span>
                            </a><!-- left carousel-control Ends -->

                            <a class="right carousel-control" href="#myCarousel" data-slide="next"><!-- right carousel-control Starts -->
                                <span class="glyphicon glyphicon-chevron-right"> </span>
                                <span class="sr-only"> Next </span>
                            </a><!-- right carousel-control Ends -->
                        </div>
                    </div><!-- mainImage Ends -->

                    <?php echo $product_label; ?>
                </div><!-- col-sm-6 Ends -->

                <div class="col-sm-6"><!-- col-sm-6 Starts -->
                    <div class="box"><!-- box Starts -->
                        <h1 class="text-center"> <?php echo $pro_title; ?> </h1>

                        <?php
                        if(isset($_POST['add_cart'])){
                            $ip_add = getRealUserIp();
                            $p_id = $pro_id;
                            $product_qty = $_POST['product_qty'];
                            $product_size = $_POST['product_size'];

                            $check_product = "select * from cart where ip_add='$ip_add' AND p_id='$p_id'";
                            $run_check = mysqli_query($con,$check_product);

                            if(mysqli_num_rows($run_check)>0){
                                echo "<script>alert('This Product is already added in cart')</script>";
                                echo "<script>window.open('$pro_url','_self')</script>";
                            } else {
                                $get_price = "select * from products where product_id='$p_id'";
                                $run_price = mysqli_query($con,$get_price);
                                $row_price = mysqli_fetch_array($run_price);

                                $pro_price = $row_price['product_price'];
                                $pro_psp_price = $row_price['product_psp_price'];
                                $pro_label = $row_price['product_label'];

                                if($pro_label == "Sale" or $pro_label == "Gift"){
                                    $product_price = $pro_psp_price;
                                } else {
                                    $product_price = $pro_price;
                                }

                                $query = "insert into cart (p_id,ip_add,qty,p_price,size) values ('$p_id','$ip_add','$product_qty','$product_price','$product_size')";
                                $run_query = mysqli_query($db,$query);
                                echo "<script>window.open('$pro_url','_self')</script>";
                            }
                        }
                        ?>

                        <form action="" method="post" class="form-horizontal"><!-- form-horizontal Starts -->
                            <?php
                            if($status == "product"){
                            ?>
                            <div class="form-group"><!-- form-group Starts -->
                                <label class="col-md-5 control-label">Product Quantity</label>
                                <div class="col-md-7"><!-- col-md-7 Starts -->
                                    <select name="product_qty" class="form-control">
                                        <option>Select quantity</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div><!-- col-md-7 Ends -->
                            </div><!-- form-group Ends -->

                            <div class="form-group"><!-- form-group Starts -->
                                <label class="col-md-5 control-label">Product Size</label>
                                <div class="col-md-7"><!-- col-md-7 Starts -->
                                    <select name="product_size" class="form-control">
                                        <option>Select a Size</option>
                                        <option>Small</option>
                                        <option>Medium</option>
                                        <option>Large</option>
                                    </select>
                                </div><!-- col-md-7 Ends -->
                            </div><!-- form-group Ends -->
                            <?php } else { ?>
                            <div class="form-group"><!-- form-group Starts -->
                                <label class="col-md-5 control-label">Bundle Quantity</label>
                                <div class="col-md-7"><!-- col-md-7 Starts -->
                                    <select name="product_qty" class="form-control">
                                        <option>Select quantity</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div><!-- col-md-7 Ends -->
                            </div><!-- form-group Ends -->

                            <div class="form-group"><!-- form-group Starts -->
                                <label class="col-md-5 control-label">Bundle Size</label>
                                <div class="col-md-7"><!-- col-md-7 Starts -->
                                    <select name="product_size" class="form-control">
                                        <option>Select a Size</option>
                                        <option>Small</option>
                                        <option>Medium</option>
                                        <option>Large</option>
                                    </select>
                                </div><!-- col-md-7 Ends -->
                            </div><!-- form-group Ends -->
                            <?php } ?>

                            <?php
                            if($status == "product"){
                                if($pro_label == "Sale" or $pro_label == "Gift"){
                                    echo "
                                    <p class='price'>
                                    Product Price : <del> RM$pro_price </del><br>
                                    Product sale Price : RM$pro_psp_price
                                    </p>
                                    ";
                                } else {
                                    echo "
                                    <p class='price'>
                                    Product Price : RM$pro_price
                                    </p>
                                    ";
                                }
                            } else {
                                if($pro_label == "Sale" or $pro_label == "Gift"){
                                    echo "
                                    <p class='price'>
                                    Bundle Price : <del> RM$pro_price </del><br>
                                    Bundle sale Price : RM$pro_psp_price
                                    </p>
                                    ";
                                } else {
                                    echo "
                                    <p class='price'>
                                    Bundle Price : RM$pro_price
                                    </p>
                                    ";
                                }
                            }
                            ?>

                            <p class="text-center buttons">
                                <button class="btn btn-primary" type="submit" name="add_cart">
                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                </button>
                                <button class="btn btn-primary" type="submit" name="add_wishlist">
                                    <i class="fa fa-heart"></i> Add to Wishlist
                                </button>
                            </p>
                        </form><!-- form-horizontal Ends -->
                    </div><!-- box Ends -->
                </div><!-- col-sm-6 Ends -->
            </div><!-- row Ends -->

            <div class="box" id="details"><!-- box Starts -->
                <p>
                    <h4>Product Details</h4>
                    <p>
                        <?php echo $pro_desc; ?>
                    </p>
                    <h4>Size</h4>
                    <ul>
                        <li>Small</li>
                        <li>Medium</li>
                        <li>Large</li>
                    </ul>
                    <h4>Features</h4>
                    <p><?php echo $pro_features; ?></p>
                    <hr>
                    <div class="row"><!-- row Starts -->
                        <div class="col-sm-12"><!-- col-sm-12 Starts -->
                            <h4>Video</h4>
                            <iframe src="<?php echo $pro_video; ?>" width="560" height="315" frameborder="0" allowfullscreen></iframe>
                        </div><!-- col-sm-12 Ends -->
                    </div><!-- row Ends -->
                </p>
            </div><!-- box Ends -->
        </div><!-- col-md-12 Ends -->

        <div class="col-md-12"><!-- col-md-12 Starts -->
            <div class="row same-height-row"><!-- row same-height-row Starts -->
                <div class="col-md-3 col-sm-6"><!-- col-md-3 col-sm-6 Starts -->
                    <div class="box same-height"><!-- box same-height Starts -->
                        <h3 class="text-center">You also like these Products</h3>
                    </div><!-- box same-height Ends -->
                </div><!-- col-md-3 col-sm-6 Ends -->

                <?php
                $get_products = "select * from products order by rand() LIMIT 0,3";
                $run_products = mysqli_query($con,$get_products);

                while($row_products = mysqli_fetch_array($run_products)){
                    $pro_id = $row_products['product_id'];
                    $pro_title = $row_products['product_title'];
                    $pro_price = $row_products['product_price'];
                    $pro_img1 = $row_products['product_img1'];
                    $pro_label = $row_products['product_label'];
                    $manufacturer_id = $row_products['manufacturer_id'];

                    $get_manufacturer = "select * from manufacturers where manufacturer_id='$manufacturer_id'";
                    $run_manufacturer = mysqli_query($db,$get_manufacturer);
                    $row_manufacturer = mysqli_fetch_array($run_manufacturer);
                    $manufacturer_name = $row_manufacturer['manufacturer_title'];

                    $pro_psp_price = $row_products['product_psp_price'];

                    if($pro_label == "Sale" or $pro_label == "Gift"){
                        $product_price = "<del> RM$pro_price </del>";
                        $product_psp_price = "| RM$pro_psp_price";
                    } else {
                        $product_psp_price = "";
                        $product_price = "RM$pro_price";
                    }

                    if($pro_label == ""){
                        // Do nothing
                    } else {
                        $product_label = "
                        <a class='label sale' href='#' style='color:black;'>
                        <div class='thelabel'>$pro_label</div>
                        <div class='label-background'> </div>
                        </a>
                        ";
                    }

                    echo "
                    <div class='col-md-3 col-sm-6 center-responsive'>
                    <div class='product'>
                    <a href='details.php?pro_id=$pro_id'>
                    <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                    </a>
                    <div class='text'>
                    <center>
                    <p class='btn btn-primary'> $manufacturer_name </p>
                    </center>
                    <hr>
                    <h3><a href='details.php?pro_id=$pro_id'> $pro_title </a></h3>
                    <p class='price'> $product_price $product_psp_price </p>
                    <p class='buttons'>
                    <a href='details.php?pro_id=$pro_id' class='btn btn-default'>View details</a>
                    <a href='details.php?pro_id=$pro_id' class='btn btn-primary'>
                    <i class='fa fa-shopping-cart'></i> Add to cart
                    </a>
                    </p>
                    </div>
                    $product_label
                    </div>
                    </div>
                    ";
                }
                ?>
            </div><!-- row same-height-row Ends -->
        </div><!-- col-md-12 Ends -->

        <div class="col-md-12"><!-- col-md-12 Starts -->
            <?php include("includes/footer.php"); ?>
        </div><!-- col-md-12 Ends -->
    </div><!-- container Ends -->
</div><!-- content Ends -->

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
<?php } ?>
