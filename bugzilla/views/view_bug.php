<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/styles.css">
    <title>Bug Details</title>
</head>
<body>
<h1>Bug Details</h1>
<!-- Flash Message Section -->
<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="flash-message <?php echo isset($_SESSION['flash_message_type']) ? $_SESSION['flash_message_type'] : ''; ?>">
        <?php
        echo $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        ?>
    </div>
<?php endif; ?>

<?php if ($bug): ?>
    <!-- Bug Information Section -->
    <section id="bug-info">
        <p><strong>Username:</strong> <?= htmlspecialchars($bug['username']); ?></p>
        <p><strong>Title:</strong> <?= htmlspecialchars($bug['title']); ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($bug['description']); ?></p>
        <p><strong>System Requirements:</strong> <?= htmlspecialchars($bug['system_requirements']); ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($bug['date']); ?></p>
    </section>

    <!-- Comment Form -->
    <?php if (isset($_SESSION['user'])): ?>
        <section id="comment-form">
            <h3>Leave a Comment</h3>
            <form action="index.php?action=add_comment&bug_id=<?= htmlspecialchars($bug['b_id']); ?>" method="post">
                <textarea name="message" rows="4" cols="50" placeholder="Write your comment here..." required></textarea><br>
                <button type="submit">Submit Comment</button>
            </form>
        </section>
    <?php else: ?>
        <p><a href="index.php?action=login">Log in</a> to leave a comment or patch.</p>
    <?php endif; ?>


    <!-- Comments Section -->
    <section id="comments">
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
    </section>
    <!-- Patch Form (for Developers) -->
    <?php if (isset($_SESSION['user']) && in_array('developer', $_SESSION['roles'])): ?>
        <section id="patch-form">
            <h3>Leave a Patch</h3>
            <form action="index.php?action=add_patch&bug_id=<?= htmlspecialchars($bug['b_id']); ?>" method="post">
                <textarea name="code" rows="4" cols="50" placeholder="Enter your patch code here..." required></textarea><br>
                <textarea name="message" rows="4" cols="50" placeholder="Leave a message about the patch..." required></textarea><br>
                <button type="submit">Submit Patch</button>
            </form>
        </section>
    <?php endif; ?>

    <!-- Patches Section -->
    <section id="patches">
        <h3>Patches</h3>
        <?php
        // Fetch patches using PatchService
        $patches = $this->patchService->getPatchesByBugId($bug['b_id']);
        if ($patches || in_array('developer', $_SESSION['roles'])): ?>
            <ul>
                <?php foreach ($patches as $patch): ?>
                    <li>
                        <p><strong><?= htmlspecialchars($patch['username']); ?></strong> patched:</p>
                        <p><strong>Message:</strong> <?= htmlspecialchars($patch['message']); ?></p>
                        <pre><code><?= htmlspecialchars($patch['code']); ?></code></pre>

                        <p><em><?= htmlspecialchars($patch['date']); ?></em></p>
                        <?php if (isset($_SESSION['user']) && in_array('tester', $_SESSION['roles'])): ?>
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
            <p>No patches yet.</p>
        <?php endif; ?>
    </section>

<?php else: ?>
    <p>Bug not found.</p>
<?php endif; ?>

<a href="index.php?action=index" class="back-link">Back to Index</a>
</body>
</html>
