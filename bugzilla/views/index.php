<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/styles.css">
    <title>Index Page</title>
</head>
<body>

<!-- Header Section -->
<header>
    <h1>Welcome to the Index Page!</h1>
</header>

<!-- Flash Message Section -->
<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="flash-message <?php echo isset($_SESSION['flash_message_type']) ? $_SESSION['flash_message_type'] : ''; ?>">
        <?php
        echo $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        ?>
    </div>
<?php endif; ?>

<!-- Search Bar -->
<section id="search-bar">
    <form method="get" action="index.php" class="search-form">
        <input type="hidden" name="action" value="search">
        <input type="text" name="query" placeholder="Search by username or title" required>
        <button type="submit">Search</button>
    </form>
</section>

<!-- Reported Bugs Section -->
<section id="bugs-section">
    <h2>Reported Bugs</h2>

    <?php if (!empty($bugs)): ?>
        <table class="bugs-table">
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
                        <a href="index.php?action=viewBug&b_id=<?= $bug['b_id'] ?>" class="bug-link">View Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No bugs reported yet.</p>
    <?php endif; ?>
</section>

</body>
</html>
