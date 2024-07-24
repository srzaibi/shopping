<?php include('config.php'); ?>
<?php include('header.php'); ?>
<?php include('db.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            redirect('index.php');
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }
}
?>


<body>
<div class="grid">
            <h2>Login</h2>
<form method="post" action="">
   
    <label>Username: </label><input type="text" name="username" required><br>
    <label>Password: </label><input type="password" name="password" required><br>
    
    <br>
    <input type="submit" value="Login">

    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</form>
</div>
</body>
<style>




.grid {
    background: #ffffff;
    padding: 2rem;
    justify-content: center;
    margin: top 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
    text-align: left;
}



body{
    text-align: -webkit-center;
    margin: left 0;
    margin: right 0;
    margin-bottom: 1.5rem;
    
}

label {
    display: block;
    margin-bottom: 0.5rem;
    color: #666666;
    
    font-weight: bold;
}

input{
    width: 94%;
    


    padding: 0.75rem;
    border: 1px solid #dddddd;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

input:focus {
    border-color: #007bff;
    outline: none;
}


p {
    margin-top: 1rem;
    color: #666666;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

</style>
</body>
<?php include('footer.php'); ?>







