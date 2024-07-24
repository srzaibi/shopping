<?php include('config.php'); ?>
<?php include('header.php'); ?>
<?php include('db.php'); ?>

<?php
if (!isLoggedIn()) {
    redirect('login.php');
}

$product_id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id=$product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'];
    $user_id = $_SESSION['user_id'];

    // Insert order into the database
    $sql = "INSERT INTO orders (user_id, product_id, address) VALUES ('$user_id', '$product_id', '$address')";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        redirect("payment.php?order_id=$order_id&amount=" . $product['price']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Buy <?php echo $product['name']; ?></h2>
<h4>Buy <?php echo $product['description']; ?></h4>
<h3>Buy <?php echo $product['price']; ?></h3>
<br>
<br>
<form method="post" action="">
    <label>Shipping Address: </label><input type="text" name="address" required><br>
    <br>
    <input class="bt" type="submit" value="Buy Now">
</form>

<?php include('footer.php'); ?>
