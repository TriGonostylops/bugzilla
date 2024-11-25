<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../public/styles/styles.css">
    <meta charset="UTF-8">
    <title>Profile</title>
</head>
<body>
<h1>Your Profile</h1>

<?php if (isset($_SESSION['flash_message'])): ?>
    <p style="color: red;"><?= htmlspecialchars($_SESSION['flash_message']); ?></p>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>

<!-- Profile Section -->
<section>
    <h2>Profile Information</h2>
    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
</section>

<hr>

<!-- Bug Reports Section -->
<section>
    <h2>Your Bug Reports</h2>
    <?php if (!empty($bugs)): ?>
        <table>
            <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bugs as $bug): ?>
                <tr>
                    <td><?= htmlspecialchars($bug['title']); ?></td>
                    <td><?= htmlspecialchars($bug['description']); ?></td>
                    <td><?= htmlspecialchars($bug['date']); ?></td>
                    <td>
                        <a href="index.php?action=viewBug&b_id=<?= $bug['b_id']; ?>">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You haven't reported any bugs yet.</p>
    <?php endif; ?>
</section>

<a href="index.php">Back to Index</a>
</body>
</html>
