<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../public/styles/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<header><h2>Login</h2></header>

<!-- Flash Message (if any) -->
<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="flash-message error">
        <?= htmlspecialchars($_SESSION['flash_message']); ?>
        <?php unset($_SESSION['flash_message']); ?>
    </div>
<?php endif; ?>

<!-- Login Form -->
<section class="form-section">
    <form method="POST" action="index.php?action=login" class="form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</section>

</body>
</html>
