<?php $isLoggedIn = isset($_SESSION['user']); ?>
<link rel="stylesheet" href="../public/styles/styles.css">

<nav class="navbar">
    <ul class="nav-list">
        <li><a href="index.php" class="nav-link">Home</a></li>

        <?php if ($isLoggedIn): ?>
            <li><a href="index.php?action=reportBug" class="nav-link">Report a Bug</a></li>
            <li><a href="index.php?action=profile" class="nav-link">Profile</a></li>
            <li><a href="index.php?action=statistics" class="nav-link">Statistics</a></li>
            <li><a href="index.php?action=logout" class="nav-link">Logout</a></li>
        <?php else: ?>
            <li><a href="index.php?action=register" class="nav-link">Register</a></li>
            <li><a href="index.php?action=login" class="nav-link">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
