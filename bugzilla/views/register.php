<?php
require_once '../services/UserService.php';

$userService = new UserService();
$roles = [];

try {
    $roles = $userService->getAllRoles();
} catch (Exception $e) {
    echo "Error fetching roles: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<h2>Register</h2>
<form method="POST" action="index.php?action=register">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="roles">Roles:</label><br>
    <?php foreach ($roles as $role): ?>
        <label for="checkers"> <?= htmlspecialchars($role->getRole()) ?> </label>
        <input id="checkers" type="checkbox" name="roles[]" value="<?= htmlspecialchars($role->getId()) ?>">
        <br>
    <?php endforeach; ?>
    <br>
    <br>

    <button type="submit">Register</button>
</form>
</body>
</html>
