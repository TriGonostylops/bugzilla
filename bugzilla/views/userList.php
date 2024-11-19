<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>User List</h1>
<ul>
    <?php
    /**
     * Loop through the array of users and display each user's name.
     *
     * @var User[] $users Array of User objects.
     */
    foreach ($users as $user): ?>
        <li><?php
            /**
             * Display the name of the user.
             * Use htmlspecialchars to prevent XSS attacks by escaping special characters.
             *
             * @see User::getName()
             */
            echo htmlspecialchars($user->getName(), ENT_QUOTES, 'UTF-8'); ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>