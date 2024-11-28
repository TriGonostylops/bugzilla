<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
<h1>Admin Dashboard</h1>

<?php if (isset($_SESSION['flash_message'])): ?>
    <p style="color: green;"><?= htmlspecialchars($_SESSION['flash_message']); ?></p>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>

<h2>Manage Users</h2>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['u_id']); ?></td>
            <td><?= htmlspecialchars($user['username']); ?></td>
            <td><?= htmlspecialchars($user['email']); ?></td>
            <td>
                <form action="index.php?action=delete_user" method="POST" style="display: inline;">
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['u_id']); ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2>Manage Bug Reports</h2>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Title</th>
        <th>Description</th>
        <th>System Requirements</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($bugs as $bug): ?>
        <tr>
            <td><?= htmlspecialchars($bug['b_id']); ?></td>
            <td><?= htmlspecialchars($bug['username']); ?></td>
            <td><?= htmlspecialchars($bug['title']); ?></td>
            <td><?= htmlspecialchars($bug['description']); ?></td>
            <td><?= htmlspecialchars($bug['date']); ?></td>
            <td>
                <form action="index.php?action=delete_bug" method="POST" style="display: inline;">
                    <input type="hidden" name="bug_id" value="<?= htmlspecialchars($bug['b_id']); ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to Home</a>
</body>
</html>
