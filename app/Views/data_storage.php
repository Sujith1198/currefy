<!-- Data Storage Converter Page -->
<section class="converter-page" id="data-storage-page">
    <div class="container">
        <div class="page-header">
            <div class="page-icon-wrap data-icon">💾</div>
            <div>
                <h1 class="page-title">Data Storage Converter</h1>
                <p class="page-subtitle">Convert between bits, bytes, KB, MB, GB, TB, PB and binary units</p>
            </div>
        </div>

        <div class="converter-card-main glass-card" id="data-converter">
            <div class="unit-converter-form" id="data-form"
                 data-endpoint="<?= base_url('data-storage/convert') ?>"
                 data-type="data">
                <div class="unit-row">
                    <div class="input-group flex-1">
                        <label class="input-label" for="data-amount">Size</label>
                        <input type="number" id="data-amount" class="form-input unit-amount"
                               placeholder="0" value="1" min="0" step="any">
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="data-from">From</label>
                        <select id="data-from" class="form-select unit-from">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'gb') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="swap-btn-container">
                        <button class="swap-btn unit-swap" aria-label="Swap">⇄</button>
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="data-to">To</label>
                        <select id="data-to" class="form-select unit-to">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'mb') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-submit-container">
                    <button type="button" class="btn btn-primary unit-submit-btn">Convert Data</button>
                </div>
                <div class="unit-result-display" id="data-result">
                    <span class="result-placeholder">Enter data size to convert</span>
                </div>
                <div class="conversion-formula" id="data-formula"></div>
            </div>
        </div>

        <div class="reference-section">
            <h2 class="sub-title">Storage Reference Chart</h2>
            <div class="ref-grid">
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Gigabyte (GB)</div><div class="ref-values"><span>= 1,024 MB</span><span>= 1,048,576 KB</span><span>= ~1.07 GiB</span><span>= 8,589,934,592 bits</span></div></div>
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Terabyte (TB)</div><div class="ref-values"><span>= 1,024 GB</span><span>= 1,048,576 MB</span><span>= ~1.10 TiB</span></div></div>
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Petabyte (PB)</div><div class="ref-values"><span>= 1,024 TB</span><span>= 1,048,576 GB</span><span>= ~1.13 PiB</span></div></div>
            </div>
        </div>
    </div>
</section>
<?php include 'partials/unit_converter_script.php'; ?>
