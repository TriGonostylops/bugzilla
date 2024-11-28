<?php
require_once '../services/UserService.php';

$userService = new UserService();
$roles = []; // Initialize as an empty array

try {
    $roles = $userService->getAllRoles(); // Fetch roles
} catch (Exception $e) {
    echo "Error fetching roles: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../public/styles/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<header><h2>Register</h2></header>

<!-- Flash Message (if any) -->
<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="flash-message error">
        <?= htmlspecialchars($_SESSION['flash_message']); ?>
        <?php unset($_SESSION['flash_message']); ?>
    </div>
<?php endif; ?>

<!-- Register Form -->
<section class="form-section">
    <form method="POST" action="index.php?action=register" class="form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="roles">Roles:</label><br><br>
        <?php foreach ($roles as $role): ?>
            <?php if (strtolower($role->getRole()) === 'reporter'): ?>
                <!-- Always checked and disabled for the "Reporter" role -->
                <label for="role<?= $role->getId() ?>"><?= htmlspecialchars($role->getRole()) ?></label><br>
                <input type="checkbox" id="role<?= $role->getId() ?>" name="roles[]" value="<?= htmlspecialchars($role->getId()) ?>" checked disabled>
                <!-- Hidden input ensures the "Reporter" role is submitted with the form -->
                <input type="hidden" name="roles[]" value="<?= htmlspecialchars($role->getId()) ?>">
            <?php else: ?>
                <!-- Render other roles as normal -->
                <label for="role<?= $role->getId() ?>"><?= htmlspecialchars($role->getRole()) ?></label><br>
                <input type="checkbox" id="role<?= $role->getId() ?>" name="roles[]" value="<?= htmlspecialchars($role->getId()) ?>">
            <?php endif; ?>
        <?php endforeach; ?>

        <button type="submit">Register</button>
    </form>
</section>

</body>
</html>
