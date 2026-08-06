<!-- Length Converter Page -->
<section class="converter-page" id="length-page">
    <div class="container">
        <div class="page-header">
            <div class="page-icon-wrap length-icon">📏</div>
            <div>
                <h1 class="page-title">Length Converter</h1>
                <p class="page-subtitle">Convert meters, kilometers, feet, miles, inches, nautical miles and more</p>
            </div>
        </div>

        <div class="converter-card-main glass-card" id="length-converter">
            <div class="unit-converter-form" id="length-form"
                 data-endpoint="<?= base_url('length/convert') ?>"
                 data-type="length">
                <div class="unit-row">
                    <div class="input-group flex-1">
                        <label class="input-label" for="length-amount">Distance</label>
                        <input type="number" id="length-amount" class="form-input unit-amount"
                               placeholder="0" value="1" min="0" step="any">
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="length-from">From</label>
                        <select id="length-from" class="form-select unit-from">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'km') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="swap-btn-container">
                        <button class="swap-btn unit-swap" aria-label="Swap">⇄</button>
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="length-to">To</label>
                        <select id="length-to" class="form-select unit-to">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'mi') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-submit-container">
                    <button type="button" class="btn btn-primary unit-submit-btn">Convert Length</button>
                </div>
                <div class="unit-result-display" id="length-result">
                    <span class="result-placeholder">Enter distance to convert</span>
                </div>
                <div class="conversion-formula" id="length-formula"></div>
            </div>
        </div>

        <div class="reference-section">
            <h2 class="sub-title">Length Reference Chart</h2>
            <div class="ref-grid">
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Kilometer</div><div class="ref-values"><span>= 1000 m</span><span>= 0.621371 mi</span><span>= 3280.84 ft</span><span>= 0.539957 nmi</span></div></div>
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Mile</div><div class="ref-values"><span>= 1.60934 km</span><span>= 1609.34 m</span><span>= 5280 ft</span><span>= 1760 yd</span></div></div>
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Foot</div><div class="ref-values"><span>= 0.3048 m</span><span>= 30.48 cm</span><span>= 12 in</span><span>= 0.333333 yd</span></div></div>
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Nautical Mile</div><div class="ref-values"><span>= 1852 m</span><span>= 1.852 km</span><span>= 1.15078 mi</span><span>= 6076.12 ft</span></div></div>
            </div>
        </div>
    </div>
</section>
<?php include 'partials/unit_converter_script.php'; ?>
