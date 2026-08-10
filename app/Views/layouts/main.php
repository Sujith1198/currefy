<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="base-url" content="<?= base_url() ?>">
    <meta name="base-url" content="<?= base_url() ?>">
    <meta name="description" content="<?= esc($description ?? 'Currefy - Free currency and unit converter with daily updated rates.') ?>">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="<?= esc($title ?? 'Currefy') ?>">
    <meta property="og:description" content="<?= esc($description ?? '') ?>">
    <meta property="og:type" content="website">
    <title><?= esc($title ?? 'Currefy - Currency & Unit Converter') ?></title>

    <link rel="icon" type="image/png" href="assets/images/logo.png">

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <!-- Security Headers via meta (server headers also set in .htaccess) -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
</head>
<body>

<!-- Navigation -->
<nav class="navbar" id="main-nav">
    <div class="nav-container">
        <a href="<?= base_url() ?>" class="nav-logo" id="nav-logo">
            <img src="assets/images/logo.png" alt="Currefy" class="logo-img">
            <span class="logo-text">Currefy</span>
        </a>

        <button class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <ul class="nav-menu" id="nav-menu" role="navigation">
            <li><a href="<?= base_url('currency') ?>" class="nav-link <?= (uri_string() === 'currency') ? 'active' : '' ?>" id="nav-currency">
                <span class="nav-icon">💱</span> Currency
            </a></li>
            <li><a href="<?= base_url('seller-calculator') ?>" class="nav-link <?= (uri_string() === 'seller-calculator') ? 'active' : '' ?>" id="nav-seller">
                <span class="nav-icon">🧾</span> Seller
            </a></li>
            <li><a href="<?= base_url('timezone') ?>" class="nav-link <?= (uri_string() === 'timezone') ? 'active' : '' ?>" id="nav-timezone">
                <span class="nav-icon">🌍</span> Time Zone
            </a></li>
            <li><a href="<?= base_url('data-storage') ?>" class="nav-link <?= (uri_string() === 'data-storage') ? 'active' : '' ?>" id="nav-data">
                <span class="nav-icon">💾</span> Data Storage
            </a></li>
            <li><a href="<?= base_url('weight') ?>" class="nav-link <?= (uri_string() === 'weight') ? 'active' : '' ?>" id="nav-weight">
                <span class="nav-icon">⚖️</span> Weight
            </a></li>
            <li class="nav-dropdown">
                <button class="nav-link nav-dropdown-toggle" id="nav-more" aria-haspopup="true" aria-expanded="false">
                    <span class="nav-icon">🔧</span> More ▾
                </button>
                <ul class="nav-dropdown-menu" role="menu">
                    <li><a href="<?= base_url('temperature') ?>" class="nav-link <?= (uri_string() === 'temperature') ? 'active' : '' ?>" id="nav-temperature" role="menuitem">🌡️ Temperature</a></li>
                    <li><a href="<?= base_url('length') ?>" class="nav-link <?= (uri_string() === 'length') ? 'active' : '' ?>" id="nav-length" role="menuitem">📏 Length</a></li>
                    <li><a href="<?= base_url('area') ?>" class="nav-link" id="nav-area" role="menuitem">📐 Area</a></li>
                    <li><a href="<?= base_url('speed') ?>" class="nav-link" id="nav-speed" role="menuitem">🚀 Speed</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<main class="main-content" id="main-content">
    <?= $content ?>
</main>

<!-- Footer -->
<footer class="footer" id="main-footer">
    <div class="footer-container">
        <div class="footer-brand">
            <img src="assets/images/logo.png" alt="Currefy" class="logo-img">
            <strong>Currefy</strong>
        </div>
        <div class="footer-links">
            <a href="<?= base_url('currency') ?>">Currency</a>
            <a href="<?= base_url('weight') ?>">Weight</a>
            <a href="<?= base_url('temperature') ?>">Temperature</a>
            <a href="<?= base_url('length') ?>">Length</a>
            <a href="<?= base_url('area') ?>">Area</a>
            <a href="<?= base_url('speed') ?>">Speed</a>
            <a href="<?= base_url('data-storage') ?>">Data</a>
            <a href="<?= base_url('timezone') ?>">Timezone</a>
        </div>
        <div class="footer-info">
            <?php if (!empty($lastUpdated)): ?>
            <p class="footer-updated">💹 Rates last updated: <strong><?= esc($lastUpdated) ?></strong></p>
            <?php endif; ?>
            <p class="footer-copy">© <?= date('Y') ?> Currefy.com · Built with CodeIgniter 4 · Exchange data from ECB via Frankfurter.app</p>
        </div>
    </div>
</footer>

<!-- JavaScript -->
<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
