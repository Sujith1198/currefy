<!-- Weight Converter Page -->
<section class="converter-page" id="weight-page">
    <div class="container">
        <div class="page-header">
            <div class="page-icon-wrap weight-icon">⚖️</div>
            <div>
                <h1 class="page-title">Weight Converter</h1>
                <p class="page-subtitle">Convert between kilograms, pounds, ounces, stone, grams and more</p>
            </div>
        </div>

        <div class="converter-card-main glass-card" id="weight-converter">
            <div class="unit-converter-form" id="weight-form"
                 data-endpoint="<?= base_url('weight/convert') ?>"
                 data-type="weight">

                <div class="unit-row">
                    <div class="input-group flex-1">
                        <label class="input-label" for="weight-amount">Amount</label>
                        <input type="number" id="weight-amount" class="form-input unit-amount"
                               placeholder="0" value="1" min="0" step="any">
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="weight-from">From</label>
                        <select id="weight-from" class="form-select unit-from">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'kg') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="swap-btn-container">
                        <button class="swap-btn unit-swap" aria-label="Swap units">⇄</button>
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="weight-to">To</label>
                        <select id="weight-to" class="form-select unit-to">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'lb') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-submit-container">
                    <button type="button" class="btn btn-primary unit-submit-btn">Convert Weight</button>
                </div>

                <div class="unit-result-display" id="weight-result">
                    <span class="result-placeholder">Enter amount to convert</span>
                </div>

                <div class="conversion-formula" id="weight-formula"></div>
            </div>
        </div>

        <!-- Quick Reference Table -->
        <div class="reference-section">
            <h2 class="sub-title">Weight Reference Chart</h2>
            <div class="ref-grid" id="weight-ref-grid">
                <div class="ref-card glass-card-sm">
                    <div class="ref-title">1 Kilogram</div>
                    <div class="ref-values">
                        <span>= 2.20462 lb</span>
                        <span>= 1000 g</span>
                        <span>= 35.274 oz</span>
                        <span>= 0.157473 stone</span>
                    </div>
                </div>
                <div class="ref-card glass-card-sm">
                    <div class="ref-title">1 Pound</div>
                    <div class="ref-values">
                        <span>= 0.453592 kg</span>
                        <span>= 453.592 g</span>
                        <span>= 16 oz</span>
                        <span>= 0.0714286 stone</span>
                    </div>
                </div>
                <div class="ref-card glass-card-sm">
                    <div class="ref-title">1 Stone</div>
                    <div class="ref-values">
                        <span>= 6.35029 kg</span>
                        <span>= 14 lb</span>
                        <span>= 224 oz</span>
                        <span>= 6350.29 g</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'partials/unit_converter_script.php'; ?>
