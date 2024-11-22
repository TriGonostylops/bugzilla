<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../public/styles/styles.css"
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

    <!-- Allow Developer to Leave a Patch -->
    <?php if (isset($_SESSION['user']) && in_array('developer', $_SESSION['roles'])): ?>
        <h3>Leave a Patch</h3>
        <form action="index.php?action=add_patch&bug_id=<?= htmlspecialchars($bug['b_id']); ?>" method="post">
            <textarea name="code" rows="4" cols="50" placeholder="Enter your patch code here..." required></textarea><br>
            <textarea name="message" rows="4" cols="50" placeholder="Leave a message about the patch..." required></textarea><br>
            <button type="submit">Submit Patch</button>
        </form>
    <?php else: ?>
        <p><a href="index.php?action=login">Log in</a> to leave a patch.</p>
    <?php endif; ?>

    <!-- Patches Section -->
    <h3>Patches</h3>
    <?php
// Fetch patches using the method from PatchService
    $patches = $this->patchService->getPatchesByBugId($bug['b_id']);
    if ($patches): ?>
        <ul>
            <?php foreach ($patches as $patch): ?>
                <li>
                    <p><strong><?= htmlspecialchars($patch['username']); ?></strong> patched:</p>
                    <p><em><?= htmlspecialchars($patch['date']); ?></em></p>
                    <p><strong>Message:</strong> <?= htmlspecialchars($patch['message']); ?></p>
                    <pre><code><?= htmlspecialchars($patch['code']); ?></code></pre>

                    <?php if (isset($_SESSION['user']) && (in_array('tester', $_SESSION['roles']))): ?>
                        <?php if ($patch['is_approved'] == 0 && $patch['username'] != $_SESSION['user']['username']): ?>
                            <form action="index.php?action=approve_patch&patch_id=<?= htmlspecialchars($patch['p_id']); ?>&bug_id=<?= htmlspecialchars($bug['b_id']); ?>" method="post">
                                <button type="submit">Approve Patch</button>
                            </form>
                        <?php else: ?>
                            <p>This patch has already been approved or you cannot approve your own patch.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No patches yet. Be the first to submit a patch!</p>
    <?php endif; ?>
    <!-- Comments Section -->
    <h3>Comments</h3>
    <?php if ($comments): ?>
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
