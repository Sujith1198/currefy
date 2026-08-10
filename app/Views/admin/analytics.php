<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
</head>
<body class="admin-page">
    <header class="admin-topbar">
        <div><strong>Currefy Analytics</strong><span>Visitor activity overview</span></div>
        <div class="admin-topbar-actions"><span><?= esc($adminEmail) ?></span><a class="btn btn-outline" href="<?= admin_url('admin/logout') ?>">Log out</a></div>
    </header>
    <main class="admin-dashboard container">
        <div class="admin-dashboard-heading"><div><p class="admin-eyebrow">ADMIN CONSOLE</p><h1>Visitor analytics</h1><p class="admin-muted">Page visits, country, IP address, and time spent.</p></div><a class="btn btn-outline" href="<?= base_url() ?>">View site</a></div>
        <form class="admin-filter-bar glass-card" method="get" action="<?= admin_url('admin/analytics') ?>">
            <label for="analytics-range">Date range</label>
            <select id="analytics-range" name="range" class="form-select">
                <option value="24h" <?= ($filter['range'] === '24h') ? 'selected' : '' ?>>Last 24 hours</option>
                <option value="7d" <?= ($filter['range'] === '7d') ? 'selected' : '' ?>>Last 7 days</option>
                <option value="30d" <?= ($filter['range'] === '30d') ? 'selected' : '' ?>>Last 30 days</option>
                <option value="custom" <?= ($filter['range'] === 'custom') ? 'selected' : '' ?>>Custom dates</option>
                <option value="all" <?= ($filter['range'] === 'all') ? 'selected' : '' ?>>All time</option>
            </select>
            <label for="analytics-from">From</label>
            <input id="analytics-from" name="from" class="form-input" type="date" value="<?= esc($filter['from'] ?? '') ?>">
            <label for="analytics-to">To</label>
            <input id="analytics-to" name="to" class="form-input" type="date" value="<?= esc($filter['to'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">Apply filter</button>
        </form>
        <section class="admin-stats-grid">
            <div class="admin-stat glass-card"><span>Total visitors</span><strong><?= number_format($summary['visitors']) ?></strong></div>
            <div class="admin-stat glass-card"><span>Page visits</span><strong><?= number_format($summary['pageVisits']) ?></strong></div>
            <div class="admin-stat glass-card"><span>Countries</span><strong><?= number_format($summary['countries']) ?></strong></div>
            <div class="admin-stat glass-card"><span>Tracked time</span><strong><?= number_format(round($summary['seconds'] / 60, 1)) ?> min</strong></div>
        </section>
        <section class="admin-panel glass-card"><div class="admin-panel-heading"><h2>Visitors</h2><span>Latest 500 records</span></div><div class="admin-table-wrap"><table id="visitors-table" class="display"><thead><tr><th>IP address</th><th>Country</th><th>Pages</th><th>First seen</th><th>Last seen</th><th>Browser</th></tr></thead><tbody><?php foreach ($visitors as $visitor): ?><tr><td><?= esc($visitor['ip_address']) ?></td><td><?= esc($visitor['country_code'] ?: 'Unknown') ?></td><td><?= number_format($visitor['page_count']) ?></td><td><?= esc($visitor['first_seen']) ?></td><td><?= esc($visitor['last_seen']) ?></td><td><?= esc($visitor['user_agent']) ?></td></tr><?php endforeach; ?></tbody></table></div></section>
        <section class="admin-panel glass-card"><div class="admin-panel-heading"><h2>Pages and time spent</h2><span>Grouped by page</span></div><div class="admin-table-wrap"><table id="pages-table" class="display"><thead><tr><th>Page</th><th>Visits</th><th>Total time</th><th>Average time</th><th>Last seen</th></tr></thead><tbody><?php foreach ($pages as $page): ?><tr><td><?= esc($page['page_path']) ?><small><?= esc($page['page_title'] ?? '') ?></small></td><td><?= number_format($page['visits']) ?></td><td><?= number_format(round(((float) $page['total_seconds']) / 60, 1)) ?> min</td><td><?= number_format(round((float) $page['average_seconds'], 1)) ?> sec</td><td><?= esc($page['last_seen']) ?></td></tr><?php endforeach; ?></tbody></table></div></section>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="<?= base_url('assets/js/admin-analytics.js') ?>"></script>
</body>
</html>
