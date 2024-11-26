<?php $isLoggedIn = isset($_SESSION['user']); ?>
<link rel="stylesheet" href="../public/styles/styles.css">

<nav class="navbar">
    <ul class="nav-list">
        <li><a href="index.php" class="nav-link">Home</a></li>
        <li><a href="index.php?action=statistics" class="nav-link">Statistics</a></li>
        <?php if (isset($_SESSION['roles']) && in_array('admin', $_SESSION['roles'])): ?>
            <li><a href="index.php?action=admin" class="nav-link">Admin Dashboard</a></li>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
            <li><a href="index.php?action=reportBug" class="nav-link">Report a Bug</a></li>
            <li><a href="index.php?action=profile" class="nav-link">Profile</a></li>
            <li><a href="index.php?action=logout" class="nav-link">Logout</a></li>
        <?php else: ?>
            <li><a href="index.php?action=register" class="nav-link">Register</a></li>
            <li><a href="index.php?action=login" class="nav-link">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
