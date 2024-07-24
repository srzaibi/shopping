<?php include('config.php'); ?>
<?php include('header.php'); ?>
<?php include('db.php'); ?>

<?php
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<h2>Products</h2>
<?php if ($result->num_rows > 0): ?>
    <ul>
        <?php while($product = $result->fetch_assoc()): ?>
            <li>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width:100%;height:200px;">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <br>
                <p style="font-weight: bold;">$<?php echo $product['price']; ?></p>
                <a class="bt" href="buy.php?id=<?php echo $product['id']; ?>">Buy Now</a>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No products available.</p>
<?php endif; ?>

<?php include('footer.php'); ?>
