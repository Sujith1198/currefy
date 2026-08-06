<!-- Speed Converter Page -->
<section class="converter-page" id="speed-page">
    <div class="container">
        <div class="page-header">
            <div class="page-icon-wrap speed-icon">🚀</div>
            <div>
                <h1 class="page-title">Speed Converter</h1>
                <p class="page-subtitle">Convert between km/h, mph, m/s, knots, Mach and speed of light</p>
            </div>
        </div>

        <div class="converter-card-main glass-card" id="speed-converter">
            <div class="unit-converter-form" id="speed-form"
                 data-endpoint="<?= base_url('speed/convert') ?>"
                 data-type="speed">
                <div class="unit-row">
                    <div class="input-group flex-1">
                        <label class="input-label" for="speed-amount">Speed</label>
                        <input type="number" id="speed-amount" class="form-input unit-amount"
                               placeholder="0" value="100" min="0" step="any">
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="speed-from">From</label>
                        <select id="speed-from" class="form-select unit-from">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'kmh') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="swap-btn-container">
                        <button class="swap-btn unit-swap" aria-label="Swap">⇄</button>
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="speed-to">To</label>
                        <select id="speed-to" class="form-select unit-to">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'mph') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-submit-container">
                    <button type="button" class="btn btn-primary unit-submit-btn">Convert Speed</button>
                </div>
                <div class="unit-result-display" id="speed-result">
                    <span class="result-placeholder">Enter speed to convert</span>
                </div>
                <div class="conversion-formula" id="speed-formula"></div>
            </div>
        </div>

        <div class="reference-section">
            <h2 class="sub-title">Speed Reference Chart</h2>
            <div class="ref-grid">
                <div class="ref-card glass-card-sm"><div class="ref-title">Speed of Sound (Mach 1)</div><div class="ref-values"><span>≈ 340.29 m/s</span><span>≈ 1224.1 km/h</span><span>≈ 761 mph</span><span>≈ 661.5 knots</span></div></div>
                <div class="ref-card glass-card-sm"><div class="ref-title">100 km/h</div><div class="ref-values"><span>= 62.137 mph</span><span>= 27.778 m/s</span><span>= 53.996 knots</span><span>= 0.0816 Mach</span></div></div>
                <div class="ref-card glass-card-sm"><div class="ref-title">Speed of Light</div><div class="ref-values"><span>≈ 299,792,458 m/s</span><span>≈ 1,079,252,848 km/h</span><span>≈ 670,616,629 mph</span></div></div>
            </div>
        </div>
    </div>
</section>
<?php include 'partials/unit_converter_script.php'; ?>
