<?php
$isLoggedIn = isset($_SESSION['user']);
?>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>

        <?php if ($isLoggedIn): ?>
            <li><a href="index.php?action=logout">Logout</a></li>
            <li><a href="index.php?action=reportBug">Report a bug</a></li>
        <?php else: ?>
            <li><a href="index.php?action=register">Register</a></li>
            <li><a href="index.php?action=login">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
