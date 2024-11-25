<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../public/styles/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>

<header class="header">
    <h1>Your Profile</h1>
</header>

<!-- Flash Message Section -->
<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="flash-message error">
        <?= htmlspecialchars($_SESSION['flash_message']); ?>
        <?php unset($_SESSION['flash_message']); ?>
    </div>
<?php endif; ?>

<!-- Profile Section -->
<section class="profile-section">
    <h2>Profile Information</h2>
    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
</section>

<hr>

<!-- Bug Reports Section -->
<section class="bug-reports-section">
    <h2>Your Bug Reports</h2>
    <?php if (!empty($bugs)): ?>
        <table class="reports-table">
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

<!-- Role-Based Statistics Section -->
<section class="statistics-section">
    <h2>Statistics</h2>
    <div class="statistics">
        <?php if (in_array('developer', $roles)): ?>
            <p><strong>Patches Left:</strong> <?= $patchesCount; ?></p>
        <?php endif; ?>

        <?php if (in_array('tester', $roles)): ?>
            <p><strong>Accepted Patches:</strong> <?= $acceptedPatchesCount; ?></p>
        <?php endif; ?>
    </div>
</section>

<a href="index.php" class="back-to-index">Back to Index</a>

</body>
</html>
