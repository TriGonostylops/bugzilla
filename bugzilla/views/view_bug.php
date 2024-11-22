<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bug Details</title>
</head>
<body>
<h1>Bug Details</h1>
<?php if ($bug): ?>
    <p><strong>Username:</strong> <?= htmlspecialchars($bug['username']) ?></p>
    <p><strong>Title:</strong> <?= htmlspecialchars($bug['title']) ?></p>
    <p><strong>Description:</strong> <?= htmlspecialchars($bug['description']) ?></p>
    <p><strong>System Requirements:</strong> <?= htmlspecialchars($bug['system_requirements']) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($bug['date']) ?></p>
    <br><br>

    <!-- Comment Form -->
    <?php if (isset($_SESSION['user'])): ?>
        <h3>Leave a Comment</h3>
        <form action="index.php?action=add_comment&bug_id=<?= htmlspecialchars($bug['b_id']); ?>" method="post">
            <textarea name="message" rows="4" cols="50" placeholder="Write your comment here..." required></textarea><br>
            <button type="submit">Submit Comment</button>
        </form>
    <?php else: ?>
        <p><a href="index.php?action=login">Log in</a> to leave a comment.</p>
    <?php endif; ?>

    <!-- Comments Section -->
    <h3>Comments</h3>
    <?php if (!empty($comments)): ?>
        <ul>
            <?php foreach ($comments as $comment): ?>
                <li>
                    <p><strong><?= htmlspecialchars($comment['username']); ?></strong> said:</p>
                    <p><?= htmlspecialchars($comment['message']); ?></p>
                    <p><em><?= htmlspecialchars($comment['date']); ?></em></p>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No comments yet. Be the first to comment!</p>
    <?php endif; ?>

<?php else: ?>
    <p>Bug not found.</p>
<?php endif; ?>
<a href="index.php?action=index">Back to Index</a>
</body>
</html>
