<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../public/styles/styles.css"
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Report</title>
</head>
<body>
<h2>Bug Report</h2>

<form method="POST" action="index.php?action=reportBug">
    <label for="title">Bug Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required></textarea><br><br>

    <label for="system_requirements">System Requirements (OS, User-Agent):</label><br>
    <input type="text" id="system_requirements" name="system_requirements" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" required><br><br>

    <button type="submit">Submit Bug Report</button>
</form>
</body>
</html>
