<?php include('config.php'); ?>
<?php include('header.php'); ?>
<?php include('db.php'); ?>

<?php
if (!isLoggedIn()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT orders.id, products.name AS product_name, products.price, products.image AS product_image, orders.address, orders.order_date, orders.payment_status 
        FROM orders 
        JOIN products ON orders.product_id = products.id 
        WHERE orders.user_id = $user_id";
$result = $conn->query($sql);
?>

<h2>Your Orders</h2>
<?php if ($result->num_rows > 0): ?>
    <ul>
        <?php while($order = $result->fetch_assoc()): ?>
            <li>
                <h3>Order ID: <?php echo $order['id']; ?></h3>
                <p>Product: <?php echo $order['product_name']; ?></p>
                <p>Price: $<?php echo number_format($order['price'], 2); ?></p>
                <?php if ($order['product_image']): ?>
                    <img src="<?php echo $order['product_image']; ?>" alt="<?php echo $order['product_name']; ?>" style="width:100px;height:100px;">
                <?php endif; ?>
                <p>Shipping Address: <?php echo $order['address']; ?></p>
                <p>Order Date: <?php echo $order['order_date']; ?></p>
                <p>Status: <?php echo $order['payment_status']; ?></p>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>You have no orders.</p>
<?php endif; ?>

<?php include('footer.php'); ?>
