<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../public/styles/styles.css">
    <meta charset="UTF-8">
    <title>Statistics</title>
    <!--    GRAPH INCLUDE    -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--    SWIPER INCLUDE    -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        canvas {
            max-width: 100%;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
<div>
    <h1>Statistics</h1>
</div>
<div>


    <?php if (isset($_SESSION['flash_message'])): ?>
        <p style="color: red;"><?= htmlspecialchars($_SESSION['flash_message']); ?></p>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>
<section>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <h3>Daily Statistics</h3>
                <canvas id="dailyChart"></canvas>
            </div>
            <div class="swiper-slide">
                <h3>Weekly Statistics</h3>
                <canvas id="weeklyChart"></canvas>
            </div>
            <div class="swiper-slide">
                <h3>Monthly Statistics</h3>
                <canvas id="monthlyChart"></canvas>
            </div>
            <div class="swiper-slide">
                <h3>All patch approvals by username</h3>
                <canvas id="approvalStatsChart"></canvas>
            </div>
            <div class="swiper-slide">
                <h3>All bugs reported by Username</h3>
                <canvas id="bugStatsChart"></canvas>
            </div>
        </div>
        <!-- Add navigation buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

<div>
    <form id="statisticsFilterForm" action="index.php?action=statistics" method="GET">
        <label for="filterDate">Select Date:</label>
        <input type="text" id="filterDate" name="filter_date" placeholder="YYYY-MM-DD">
        <button type="submit">Generate Statistics</button>
    </form>
</div>
</section>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#filterDate", {
            enableTime: false,
            dateFormat: "Y-m-d",
            defaultDate: new Date(),
        });
    });
</script>

<!-- Bug and Patch Summary -->
<section>
    <h2>Bug Reports</h2>
    <ul>
        <li><strong>Daily:</strong> <?= htmlspecialchars($bugStats['daily']); ?></li>
        <li><strong>Weekly:</strong> <?= htmlspecialchars($bugStats['weekly']); ?></li>
        <li><strong>Monthly:</strong> <?= htmlspecialchars($bugStats['monthly']); ?></li>
    </ul>
</section>

<section>
    <h2>Patch Submissions</h2>
    <ul>
        <li><strong>Daily:</strong> <?= htmlspecialchars($patchStats['daily']); ?></li>
        <li><strong>Weekly:</strong> <?= htmlspecialchars($patchStats['weekly']); ?></li>
        <li><strong>Monthly:</strong> <?= htmlspecialchars($patchStats['monthly']); ?></li>
    </ul>
</section>

<!-- Unapproved Patches -->
<section>
    <h2>Unapproved Patches from Last 7 Days</h2>
    <table>
        <thead>
        <tr>
            <th>Patch ID</th>
            <th>Bug ID</th>
            <th>Username</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($unapprovedPatches as $patch): ?>
            <tr>
                <td><?= htmlspecialchars($patch['p_id']); ?></td>
                <td><?= htmlspecialchars($patch['bug_id']); ?></td>
                <td><?= htmlspecialchars($patch['username']); ?></td>
                <td><?= htmlspecialchars($patch['date']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Data for existing charts
        const bugStats = JSON.parse('<?= json_encode($bugStats); ?>');
        const patchStats = JSON.parse('<?= json_encode($patchStats); ?>');

        // Daily Chart
        new Chart(document.getElementById('dailyChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Bug Reports', 'Patch Submissions'],
                datasets: [{
                    label: 'Daily Statistics',
                    data: [bugStats.daily, patchStats.daily],
                    backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            },
            options: {scales: {y: {beginAtZero: true}}}
        });
        console.log(bugStats);
        console.log(patchStats);

        // Weekly Chart
        new Chart(document.getElementById('weeklyChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Bug Reports', 'Patch Submissions'],
                datasets: [{
                    label: 'Weekly Statistics',
                    data: [bugStats.weekly, patchStats.weekly],
                    backgroundColor: ['rgba(255, 159, 64, 0.5)', 'rgba(75, 192, 192, 0.5)'],
                    borderColor: ['rgba(255, 159, 64, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {scales: {y: {beginAtZero: true}}}
        });

        // Monthly Chart
        new Chart(document.getElementById('monthlyChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Bug Reports', 'Patch Submissions'],
                datasets: [{
                    label: 'Monthly Statistics',
                    data: [bugStats.monthly, patchStats.monthly],
                    backgroundColor: ['rgba(153, 102, 255, 0.5)', 'rgba(255, 206, 86, 0.5)'],
                    borderColor: ['rgba(153, 102, 255, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            },
            options: {scales: {y: {beginAtZero: true}}}
        });

        // Patch Approvals by Username Chart
        const approvalStats = JSON.parse('<?= json_encode($approvalStats); ?>');
        new Chart(document.getElementById('approvalStatsChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: approvalStats.map(item => item.username),
                datasets: [{
                    label: 'Approvals',
                    data: approvalStats.map(item => item.approval_count),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {scales: {y: {beginAtZero: true}}}
        });

        // Bug Reports by Username Chart
        const userBugStats = JSON.parse('<?= json_encode($userBugStats); ?>');
        new Chart(document.getElementById('bugStatsChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: userBugStats.map(item => item.username),
                datasets: [{
                    label: 'Bugs Reported',
                    data: userBugStats.map(item => item.bug_count),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {scales: {y: {beginAtZero: true}}}
        });
    });
    const swiper = new Swiper('.swiper-container', {
        loop: true,
        autoHeight: true, // Enable dynamic height adjustment
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

</script>

<a href="index.php">Back to Index</a>
</body>
</html>
