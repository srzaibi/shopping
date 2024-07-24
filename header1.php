<header>
    <h1>Shopping Website</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isLoggedIn()): ?>
                <li><a href="products.php">Products</a></li>
                <li><a href="order.php">My Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
