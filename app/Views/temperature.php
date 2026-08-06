<!-- Temperature Converter Page -->
<section class="converter-page" id="temperature-page">
    <div class="container">
        <div class="page-header">
            <div class="page-icon-wrap temp-icon">🌡️</div>
            <div>
                <h1 class="page-title">Temperature Converter</h1>
                <p class="page-subtitle">Convert between Celsius, Fahrenheit, Kelvin, Rankine and Réaumur</p>
            </div>
        </div>

        <div class="converter-card-main glass-card" id="temp-converter">
            <div class="unit-converter-form" id="temp-form"
                 data-endpoint="<?= base_url('temperature/convert') ?>"
                 data-type="temperature">

                <div class="unit-row">
                    <div class="input-group flex-1">
                        <label class="input-label" for="temp-amount">Temperature</label>
                        <input type="number" id="temp-amount" class="form-input unit-amount"
                               placeholder="0" value="100" step="any">
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="temp-from">From</label>
                        <select id="temp-from" class="form-select unit-from">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'c') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="swap-btn-container">
                        <button class="swap-btn unit-swap" aria-label="Swap">⇄</button>
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="temp-to">To</label>
                        <select id="temp-to" class="form-select unit-to">
                            <?php foreach ($units as $key => $unit): ?>
                            <option value="<?= esc($key) ?>" <?= ($key === 'f') ? 'selected' : '' ?>>
                                <?= esc($unit['name']) ?> (<?= esc($unit['symbol']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-submit-container">
                    <button type="button" class="btn btn-primary unit-submit-btn">Convert Temperature</button>
                </div>

                <div class="unit-result-display" id="temp-result">
                    <span class="result-placeholder">Enter temperature to convert</span>
                </div>
                <div class="conversion-formula" id="temp-formula"></div>
            </div>
        </div>

        <!-- Common Temperatures Reference -->
        <div class="reference-section">
            <h2 class="sub-title">Common Temperature References</h2>
            <div class="ref-grid">
                <div class="ref-card glass-card-sm">
                    <div class="ref-title">Water Boiling Point</div>
                    <div class="ref-values">
                        <span>100 °C</span><span>212 °F</span><span>373.15 K</span>
                    </div>
                </div>
                <div class="ref-card glass-card-sm">
                    <div class="ref-title">Water Freezing Point</div>
                    <div class="ref-values">
                        <span>0 °C</span><span>32 °F</span><span>273.15 K</span>
                    </div>
                </div>
                <div class="ref-card glass-card-sm">
                    <div class="ref-title">Human Body Temp</div>
                    <div class="ref-values">
                        <span>37 °C</span><span>98.6 °F</span><span>310.15 K</span>
                    </div>
                </div>
                <div class="ref-card glass-card-sm">
                    <div class="ref-title">Absolute Zero</div>
                    <div class="ref-values">
                        <span>-273.15 °C</span><span>-459.67 °F</span><span>0 K</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('partials/unit_converter_script') ?>
