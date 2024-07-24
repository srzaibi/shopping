<?php include('config.php'); ?>
<?php include('header.php'); ?>
<?php include('db.php'); ?>

<?php
// Check if user is logged in and if they are an admin (this example assumes a simple admin check)
if (!isLoggedIn()) {
    redirect('login.php');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Insert product into the database
    $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')";
    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Add Product</h2>
<form method="post" action="" enctype="multipart/form-data">
    <label>Product Name: </label><input type="text" name="name" required><br>
    <label>Description: </label><textarea name="description" required></textarea><br>
    <label>Price: </label><input type="text" name="price" required><br>
    <label>Image: </label><input type="file" name="image" required><br>
    <input type="submit" value="Add Product">
</form>

<?php include('footer.php'); ?>
