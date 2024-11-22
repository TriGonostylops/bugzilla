<!-- views/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../public/styles/styles.css"
    <meta charset="UTF-8">
    <title>Index Page</title>
</head>
<body>
<h1>Welcome to the Index Page!</h1>
<?php
if (isset($_SESSION['flash_message'])) {
    echo "<p>" . $_SESSION['flash_message'] . "</p>";

    unset($_SESSION['flash_message']);
}
?>

<h2>Reported Bugs</h2>

<?php if (!empty($bugs)): ?>
    <table>
        <thead>
        <tr>
            <th>Username</th>
            <th>Title</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($bugs as $bug): ?>
            <tr>
                <td><?= htmlspecialchars($bug['username']) ?></td>
                <td><?= htmlspecialchars($bug['title']) ?></td>
                <td><?= htmlspecialchars($bug['date']) ?></td>
                <td>
                    <a href="index.php?action=viewBug&b_id=<?= $bug['b_id'] ?>" class="bug-link">
                        View Details
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No bugs reported yet.</p>
<?php endif; ?>
</body>
</html>
