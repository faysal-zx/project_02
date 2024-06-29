<?php

if(!isset($_SESSION['admin_email'])){
    echo "<script>window.open('login.php','_self')</script>";
} else {

?>

<div class="row"><!-- 1 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <ol class="breadcrumb"><!-- breadcrumb Starts  --->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Orders
            </li>
        </ol><!-- breadcrumb Ends  --->
    </div><!-- col-lg-12 Ends -->
</div><!-- 1 row Ends -->

<div class="row"><!-- 2 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <div class="panel panel-default"><!-- panel panel-default Starts -->
            <div class="panel-heading"><!-- panel-heading Starts -->
                <h3 class="panel-title"><!-- panel-title Starts -->
                    <i class="fa fa-money fa-fw"></i> View Orders
                </h3><!-- panel-title Ends -->
            </div><!-- panel-heading Ends -->

            <div class="panel-body"><!-- panel-body Starts -->

                <!-- Search Form Starts -->
                <form method="get" action="">
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <select name="order_status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="pending" <?php if(isset($_GET['order_status']) && $_GET['order_status'] == 'pending') { echo 'selected'; } ?>>Pending</option>
                                <option value="completed" <?php if(isset($_GET['order_status']) && $_GET['order_status'] == 'completed') { echo 'selected'; } ?>>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <!-- Search Form Ends -->

                <div class="table-responsive"><!-- table-responsive Starts -->
                    <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->
                        <thead><!-- thead Starts -->
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Invoice</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Size</th>
                                <th>Order Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead><!-- thead Ends -->

                        <tbody><!-- tbody Starts -->

                        <?php

                        $i = 0;
                        $query = "SELECT * FROM pending_orders";

                        if(isset($_GET['order_status']) && $_GET['order_status'] != "") {
                            $order_status = $_GET['order_status'];
                            $query .= " WHERE order_status='$order_status'";
                        }

                        $run_orders = mysqli_query($con, $query);

                        while ($row_orders = mysqli_fetch_array($run_orders)) {
                            $order_id = $row_orders['order_id'];
                            $c_id = $row_orders['customer_id'];
                            $invoice_no = $row_orders['invoice_no'];
                            $product_id = $row_orders['product_id'];
                            $qty = $row_orders['qty'];
                            $size = $row_orders['size'];
                            $order_status = $row_orders['order_status'];

                            $get_products = "SELECT * FROM products WHERE product_id='$product_id'";
                            $run_products = mysqli_query($con, $get_products);
                            $row_products = mysqli_fetch_array($run_products);
                            $product_title = isset($row_products['product_title']) ? $row_products['product_title'] : "Unknown";

                            $i++;
                        ?>

                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <?php
                                $get_customer = "SELECT * FROM customers WHERE customer_id='$c_id'";
                                $run_customer = mysqli_query($con, $get_customer);
                                $row_customer = mysqli_fetch_array($run_customer);
                                $customer_email = isset($row_customer['customer_email']) ? $row_customer['customer_email'] : "Unknown";
                                echo $customer_email;
                                ?>
                            </td>
                            <td bgcolor="orange"><?php echo $invoice_no; ?></td>
                            <td><?php echo $product_title; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $size; ?></td>
                            <td>
                                <?php
                                $get_customer_order = "SELECT * FROM customer_orders WHERE order_id='$order_id'";
                                $run_customer_order = mysqli_query($con, $get_customer_order);
                                $row_customer_order = mysqli_fetch_array($run_customer_order);
                                $order_date = isset($row_customer_order['order_date']) ? $row_customer_order['order_date'] : "Unknown";
                                $due_amount = isset($row_customer_order['due_amount']) ? $row_customer_order['due_amount'] : "Unknown";
                                echo $order_date;
                                ?>
                            </td>
                            <td>RM<?php echo $due_amount; ?></td>
                            <td>
                                <?php
                                if($order_status=='pending'){
                                    echo '<div style="color:red;">Pending</div>';
                                } else {
                                    echo 'Completed';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="index.php?order_delete=<?php echo $order_id; ?>" >
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>
                        </tr>

                        <?php } ?>

                        </tbody><!-- tbody Ends -->
                    </table><!-- table table-bordered table-hover table-striped Ends -->
                </div><!-- table-responsive Ends -->

            </div><!-- panel-body Ends -->
        </div><!-- panel panel-default Ends -->
    </div><!-- col-lg-12 Ends -->
</div><!-- 2 row Ends -->

<?php } ?>
