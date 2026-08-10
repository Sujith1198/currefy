<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="admin-page">
    <main class="admin-login-wrap">
        <section class="admin-login-card glass-card">
            <div class="page-icon-wrap currency-icon">🔐</div>
            <p class="admin-eyebrow">PRIVATE AREA</p>
            <h1>Administrator login</h1>
            <p class="admin-muted">Sign in to view Currefy visitor analytics.</p>
            <?php if (!empty($error)): ?><div class="admin-alert"><?= esc($error) ?></div><?php endif; ?>
            <form method="post" action="<?= base_url('index.php/admin/login') ?>" class="admin-form">
                <?= csrf_field() ?>
                <label class="input-label" for="admin-email">Email</label>
                <input class="form-input" id="admin-email" name="email" type="email" value="<?= esc(old('email')) ?>" required autocomplete="username">
                <label class="input-label" for="admin-password">Password</label>
                <input class="form-input" id="admin-password" name="password" type="password" required autocomplete="current-password">
                <button class="btn btn-primary" type="submit">Sign in</button>
            </form>
            <a class="admin-back-link" href="<?= base_url() ?>">Back to Currefy</a>
        </section>
    </main>
</body>
</html>
