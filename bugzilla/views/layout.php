<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($pageTitle) ? $pageTitle : 'Bugzilla' ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Header or common navigation goes here -->
<header>
    <h1>Bug Tracker</h1>
    <!-- Navigation or menu items -->
</header>

<div id="content">
    <?= isset($content) ? $content : '' ?>  <!-- This will be replaced by the actual content of the page -->
</div>

<!-- Footer or common footer content goes here -->
<footer>
    <p>© 2024 Bug Tracker</p>
</footer>

</body>
</html>
