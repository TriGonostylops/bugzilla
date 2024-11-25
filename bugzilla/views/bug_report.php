<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../public/styles/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Report</title>
</head>
<body>

<header><h2>Bug Report</h2></header>

<!-- Bug Report Form -->
<section class="form-section">
    <form method="POST" action="index.php?action=reportBug" class="form">
        <label for="title">Bug Title:</label>
        <input type="text" id="title" name="title" required>
        <br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <label for="system_requirements">System Requirements (OS, User-Agent):</label>
        <input type="text" id="system_requirements" name="system_requirements" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" required>
        <br>
        <br>

        <button type="submit">Submit Bug Report</button>
    </form>
</section>

</body>
</html>
