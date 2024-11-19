<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advertisement List</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Advertisement List</h1>
<ul>
    <?php
    /**
     * Loop through the array of advertisements and display each one.
     *
     * @var Advertisement[] $ads Array of Advertisement objects.
     */
    foreach ($ads as $ad): ?>
        <li>
            <strong><?php
                /**
                 * Display the title of the advertisement.
                 * Use htmlspecialchars to prevent XSS attacks by escaping special characters.
                 *
                 * @see Advertisement::getTitle()
                 */
                echo htmlspecialchars($ad->getTitle(), ENT_QUOTES, 'UTF-8'); ?></strong>
            by <?php
            /**
             * Display the name of the user who posted the advertisement.
             * Use htmlspecialchars to prevent XSS attacks by escaping special characters.
             *
             * @see Advertisement::getUserName()
             */
            echo htmlspecialchars($ad->getUserName(), ENT_QUOTES, 'UTF-8'); ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>