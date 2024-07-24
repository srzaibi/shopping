<?php include('config.php'); ?>
<?php include('header.php'); ?>
<?php include('db.php'); ?>

<?php
if (!isLoggedIn()) {
    redirect('login.php');
}

$order_id = $_GET['order_id'];
$amount = $_GET['amount'];
$user_id = $_SESSION['user_id'];

// Fetch user email
$sql = "SELECT email FROM users WHERE id=$user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Flag to check if payment is done
$payment_done = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transaction_id = $_POST['transaction_id'];
    $receipt_image = '';

    // Handle file upload
    if (isset($_FILES['receipt_image']) && $_FILES['receipt_image']['error'] == 0) {
        $uploadDir = 'admin/receipt/';
        $uploadDirs = 'receipt/';
        $uploadFile = $uploadDir . basename($_FILES['receipt_image']['name']);
        $uploadFiler = $uploadDirs . basename($_FILES['receipt_image']['name']);
        // Check if directory exists and is writable
        if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
            echo "Upload directory does not exist or is not writable.";
        } else {
            // Move the uploaded file
            if (move_uploaded_file($_FILES['receipt_image']['tmp_name'], $uploadFile)) {
                $receipt_image = $uploadFile;
                $receipt_imager = $uploadFiler;
            } else {
                echo "Failed to move uploaded file.";
            }
        }
    }

    // Insert transaction into the database
    $sql = "INSERT INTO transactions (user_id, order_id, transaction_id, amount, email, receipt_image) 
            VALUES ('$user_id', '$order_id', '$transaction_id', '$amount', '{$user['email']}', '$receipt_imager')";
    if ($conn->query($sql) === TRUE) {
        // Update the order's payment status
       
       

        $payment_done = true; // Set flag to true
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Payment Details</h2>
<?php if (!$payment_done): ?>
    <p>Please transfer the amount of $<?php echo $amount; ?> to the following bank account and enter the transaction ID and receipt image below:</p>
    <ul>
        <li>Bank Name: Example Bank</li>
        <li>Account Number: 123456789</li>
        <li>Account Name: Example Account</li>
        <li>IFSC Code: EXAMPL000123</li>
    </ul>

    <form method="post" action="" enctype="multipart/form-data">
        <label>Transaction ID: </label><input type="text" name="transaction_id" required><br>
        <label>Receipt Image: </label><input type="file" name="receipt_image" accept="image/*" required><br>
        <input type="submit" value="Submit Payment">
    </form>
<?php else: ?>
    <p>Thank you for your payment! Your transaction has been successfully recorded.</p>
<?php endif; ?>

<?php include('footer.php'); ?>
