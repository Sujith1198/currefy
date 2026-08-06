<!-- Area Converter Page -->
<section class="converter-page" id="area-page">
    <div class="container">
        <div class="page-header">
            <div class="page-icon-wrap area-icon">📐</div>
            <div>
                <h1 class="page-title">Area Converter</h1>
                <p class="page-subtitle">Convert between square meters, acres, hectares, square feet and more</p>
            </div>
        </div>

        <div class="converter-card-main glass-card" id="area-converter">
            <div class="unit-converter-form" id="area-form"
                 data-endpoint="<?= base_url('area/convert') ?>"
                 data-type="area">
                <div class="unit-row">
                    <div class="input-group flex-1">
                        <label class="input-label" for="area-amount">Area</label>
                        <input type="number" id="area-amount" class="form-input unit-amount"
                               placeholder="0" value="1" min="0" step="any">
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="area-from">From</label>
                        <select id="area-from" class="form-select unit-from">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'ha') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="swap-btn-container">
                        <button class="swap-btn unit-swap" aria-label="Swap">⇄</button>
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="area-to">To</label>
                        <select id="area-to" class="form-select unit-to">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'acre') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-submit-container">
                    <button type="button" class="btn btn-primary unit-submit-btn">Convert Area</button>
                </div>
                <div class="unit-result-display" id="area-result">
                    <span class="result-placeholder">Enter area to convert</span>
                </div>
                <div class="conversion-formula" id="area-formula"></div>
            </div>
        </div>

        <div class="reference-section">
            <h2 class="sub-title">Area Reference Chart</h2>
            <div class="ref-grid">
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Hectare</div><div class="ref-values"><span>= 10,000 m²</span><span>= 2.47105 acres</span><span>= 0.01 km²</span><span>= 107,639 ft²</span></div></div>
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Acre</div><div class="ref-values"><span>= 4046.86 m²</span><span>= 0.404686 ha</span><span>= 43,560 ft²</span><span>= 4840 yd²</span></div></div>
                <div class="ref-card glass-card-sm"><div class="ref-title">1 Square Mile</div><div class="ref-values"><span>= 2.58999 km²</span><span>= 258.999 ha</span><span>= 640 acres</span><span>= 27,878,400 ft²</span></div></div>
            </div>
        </div>
    </div>
</section>
<?php include 'partials/unit_converter_script.php'; ?>
