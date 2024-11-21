<!-- views/index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
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
</body>
</html>
