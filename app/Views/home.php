<!-- Home Page - Hero + Converter Grid -->

<!-- Hero Section -->
<section class="hero" id="hero-section">
    <div class="hero-bg-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>
    <div class="hero-content">
        <div class="hero-badge">
            <span class="badge-dot"></span>
            Live Exchange Rates · Updated Daily
        </div>
        <h1 class="hero-title">Convert <span class="gradient-text">Anything</span>,<br>Instantly.</h1>
        <p class="hero-subtitle">
            Currency, weight, temperature, length, area, speed, and data storage — all in one place.
            Exchange rates sourced daily from the European Central Bank.
        </p>
        <div class="hero-cta">
            <a href="<?= base_url('currency') ?>" class="btn btn-primary" id="hero-cta-currency">
                <span>💱</span> Convert Currency
            </a>
            <a href="#converters" class="btn btn-outline" id="hero-cta-explore">
                Explore All Converters
            </a>
        </div>
        <?php if (!empty($lastUpdated)): ?>
        <div class="hero-update-badge">
            <span class="update-dot"></span>
            Rates updated: <?= esc($lastUpdated) ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Quick Currency Widget on Homepage -->
<section class="quick-convert-section" id="quick-convert">
    <div class="container">
        <div class="quick-card glass-card" id="quick-currency-card">
            <div class="quick-card-header">
                <h2>⚡ Quick Currency Converter</h2>
                <p>Powered by ECB rates</p>
            </div>
            <div class="quick-convert-form">
                <div class="form-row">
                    <div class="input-group">
                        <label for="qc-amount">Amount</label>
                        <input type="number" id="qc-amount" placeholder="1.00" value="1" min="0" step="any" class="form-input">
                    </div>
                    <div class="input-group">
                        <label for="qc-from">From</label>
                        <select id="qc-from" class="form-select">
                            <option value="USD">🇺🇸 USD - US Dollar</option>
                            <option value="EUR">🇪🇺 EUR - Euro</option>
                            <option value="GBP">🇬🇧 GBP - British Pound</option>
                            <option value="INR">🇮🇳 INR - Indian Rupee</option>
                            <option value="JPY">🇯🇵 JPY - Japanese Yen</option>
                            <option value="CAD">🇨🇦 CAD - Canadian Dollar</option>
                            <option value="AUD">🇦🇺 AUD - Australian Dollar</option>
                            <option value="CHF">🇨🇭 CHF - Swiss Franc</option>
                            <option value="CNY">🇨🇳 CNY - Chinese Yuan</option>
                            <option value="SGD">🇸🇬 SGD - Singapore Dollar</option>
                        </select>
                    </div>
                    <div class="swap-btn-container">
                        <button class="swap-btn" id="qc-swap" aria-label="Swap currencies" title="Swap">⇄</button>
                    </div>
                    <div class="input-group">
                        <label for="qc-to">To</label>
                        <select id="qc-to" class="form-select">
                            <option value="EUR">🇪🇺 EUR - Euro</option>
                            <option value="USD">🇺🇸 USD - US Dollar</option>
                            <option value="GBP">🇬🇧 GBP - British Pound</option>
                            <option value="INR">🇮🇳 INR - Indian Rupee</option>
                            <option value="JPY">🇯🇵 JPY - Japanese Yen</option>
                            <option value="CAD">🇨🇦 CAD - Canadian Dollar</option>
                            <option value="AUD">🇦🇺 AUD - Australian Dollar</option>
                            <option value="CHF">🇨🇭 CHF - Swiss Franc</option>
                            <option value="CNY">🇨🇳 CNY - Chinese Yuan</option>
                            <option value="SGD">🇸🇬 SGD - Singapore Dollar</option>
                        </select>
                    </div>
                </div>
                <div class="result-display" id="qc-result">
                    <span class="result-placeholder">Enter an amount to convert</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Converters Grid -->
<section class="converters-section" id="converters">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">All Converters</h2>
            <p class="section-subtitle">Professional-grade conversion tools at your fingertips</p>
        </div>

        <div class="converters-grid" id="converters-grid">

            <a href="<?= base_url('currency') ?>" class="converter-card glass-card" id="card-currency">
                <div class="card-icon-wrap currency-icon">💱</div>
                <h3>Currency</h3>
                <p>Live exchange rates from ECB. 30+ currencies updated daily.</p>
                <div class="card-badge">Live Rates</div>
                <span class="card-arrow">→</span>
            </a>

            <a href="<?= base_url('weight') ?>" class="converter-card glass-card" id="card-weight">
                <div class="card-icon-wrap weight-icon">⚖️</div>
                <h3>Weight</h3>
                <p>kg, lbs, oz, stone, grams, metric tons, carats and more.</p>
                <div class="card-badge">12 Units</div>
                <span class="card-arrow">→</span>
            </a>

            <a href="<?= base_url('temperature') ?>" class="converter-card glass-card" id="card-temperature">
                <div class="card-icon-wrap temp-icon">🌡️</div>
                <h3>Temperature</h3>
                <p>Celsius, Fahrenheit, Kelvin, Rankine and Réaumur.</p>
                <div class="card-badge">5 Scales</div>
                <span class="card-arrow">→</span>
            </a>

            <a href="<?= base_url('length') ?>" class="converter-card glass-card" id="card-length">
                <div class="card-icon-wrap length-icon">📏</div>
                <h3>Length</h3>
                <p>m, km, ft, miles, inches, nautical miles, light years.</p>
                <div class="card-badge">13 Units</div>
                <span class="card-arrow">→</span>
            </a>

            <a href="<?= base_url('area') ?>" class="converter-card glass-card" id="card-area">
                <div class="card-icon-wrap area-icon">📐</div>
                <h3>Area</h3>
                <p>m², km², acres, hectares, square feet, square miles.</p>
                <div class="card-badge">10 Units</div>
                <span class="card-arrow">→</span>
            </a>

            <a href="<?= base_url('speed') ?>" class="converter-card glass-card" id="card-speed">
                <div class="card-icon-wrap speed-icon">🚀</div>
                <h3>Speed</h3>
                <p>km/h, mph, m/s, knots, Mach, speed of light.</p>
                <div class="card-badge">7 Units</div>
                <span class="card-arrow">→</span>
            </a>

            <a href="<?= base_url('data-storage') ?>" class="converter-card glass-card" id="card-data">
                <div class="card-icon-wrap data-icon">💾</div>
                <h3>Data Storage</h3>
                <p>Bits, bytes, KB, MB, GB, TB, PB and binary units.</p>
                <div class="card-badge">11 Units</div>
                <span class="card-arrow">→</span>
            </a>

            <a href="<?= base_url('timezone') ?>" class="converter-card glass-card" id="card-timezone">
                <div class="card-icon-wrap tz-icon">🌍</div>
                <h3>Time Zone</h3>
                <p>Convert times between 40+ world time zones instantly.</p>
                <div class="card-badge">40+ Zones</div>
                <span class="card-arrow">→</span>
            </a>

        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section" id="features">
    <div class="container">
        <div class="features-grid">
            <div class="feature-item" id="feat-daily">
                <div class="feature-icon">📡</div>
                <h3>Daily Rate Updates</h3>
                <p>Exchange rates fetched from the European Central Bank every 24 hours automatically.</p>
            </div>
            <div class="feature-item" id="feat-free">
                <div class="feature-icon">🆓</div>
                <h3>100% Free</h3>
                <p>No account required, no limits, no ads. Just fast, accurate conversions.</p>
            </div>
            <div class="feature-item" id="feat-precision">
                <div class="feature-icon">🎯</div>
                <h3>High Precision</h3>
                <p>Up to 6 decimal places of precision for all unit conversions.</p>
            </div>
            <div class="feature-item" id="feat-fast">
                <div class="feature-icon">⚡</div>
                <h3>Lightning Fast</h3>
                <p>Instant results powered by server-side caching. No third-party dependencies.</p>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('assets/js/home.js') ?>"></script>
