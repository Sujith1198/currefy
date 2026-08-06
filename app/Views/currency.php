<!-- Currency Converter Page -->
<section class="converter-page" id="currency-page">
    <div class="container">

        <div class="page-header">
            <div class="page-icon-wrap currency-icon">💱</div>
            <div>
                <h1 class="page-title">Currency Converter</h1>
                <p class="page-subtitle">Live exchange rates from the European Central Bank · Updated daily</p>
            </div>
        </div>

        <!-- Rate Status Bar -->
        <?php if (!empty($lastUpdated)): ?>
        <div class="rate-status-bar" id="rate-status">
            <span class="rate-dot"></span>
            <span id="rate-status-text">Rates as of: <strong><?= esc($lastUpdated) ?></strong></span>
            <span class="rate-source">Source: ECB / Frankfurter.app</span>
        </div>
        <?php else: ?>
        <div class="rate-status-bar rate-loading" id="rate-status">
            <span class="rate-dot loading"></span>
            <span>Loading exchange rates...</span>
        </div>
        <?php endif; ?>

        <!-- Main Converter Card -->
        <div class="converter-card-main glass-card" id="currency-converter">
            <div class="converter-form">
                <!-- From -->
                <div class="currency-input-group" id="currency-from-group">
                    <label class="input-label" for="currency-amount">Amount</label>
                    <div class="currency-input-wrap">
                        <input
                            type="number"
                            id="currency-amount"
                            class="currency-amount-input form-input"
                            placeholder="0.00"
                            value="1"
                            min="0"
                            step="any"
                            autocomplete="off"
                        >
                        <select id="currency-from" class="currency-select form-select">
                            <?php foreach ($names as $code => $name): ?>
                            <?php if (isset($ratesData['rates'][$code])): ?>
                            <option value="<?= esc($code) ?>" <?= ($code === 'USD') ? 'selected' : '' ?>>
                                <?= esc($code) ?> — <?= esc($name) ?>
                            </option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Swap -->
                <div class="converter-swap" id="currency-swap-wrap">
                    <button class="swap-btn-large" id="currency-swap-btn" aria-label="Swap currencies">
                        <span class="swap-icon">⇄</span>
                    </button>
                </div>

                <!-- To -->
                <div class="currency-input-group" id="currency-to-group">
                    <label class="input-label" for="currency-result-display">Result</label>
                    <div class="currency-input-wrap">
                        <div id="currency-result-display" class="currency-result-input form-input result-field">
                            <span class="result-loading">—</span>
                        </div>
                        <select id="currency-to" class="currency-select form-select">
                            <?php foreach ($names as $code => $name): ?>
                            <?php if (isset($ratesData['rates'][$code])): ?>
                            <option value="<?= esc($code) ?>" <?= ($code === 'INR') ? 'selected' : '' ?>>
                                <?= esc($code) ?> — <?= esc($name) ?>
                            </option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-submit-container">
                    <button type="button" id="currency-submit-btn" class="btn btn-primary">Convert Currency</button>
                </div>
            </div>

            <!-- Rate Display -->
            <div class="rate-display" id="currency-rate-display">
                <div class="rate-info" id="rate-info-text">Select currencies and enter amount</div>
                <button class="copy-btn d-none" id="copy-result-btn" aria-label="Copy result">📋 Copy</button>
            </div>
        </div>

        <!-- Popular Conversions -->
        <div class="popular-section" id="popular-conversions">
            <h2 class="sub-title">Popular Conversions</h2>
            <div class="popular-grid" id="popular-grid">
                <?php
                $popular = [
                    ['USD','EUR'], ['USD','GBP'], ['USD','INR'], ['USD','JPY'],
                    ['EUR','USD'], ['EUR','GBP'], ['GBP','USD'], ['EUR','INR'],
                ];
                foreach ($popular as $pair):
                    $from = $pair[0]; $to = $pair[1];
                    if (isset($ratesData['rates'][$from], $ratesData['rates'][$to])):
                        $rate = round($ratesData['rates'][$to] / $ratesData['rates'][$from], 4);
                ?>
                <div class="popular-item glass-card-sm" id="pop-<?= esc($from) ?>-<?= esc($to) ?>">
                    <div class="pop-pair"><?= esc($from) ?> → <?= esc($to) ?></div>
                    <div class="pop-rate">1 <?= esc($from) ?> = <strong><?= esc($rate) ?></strong> <?= esc($to) ?></div>
                </div>
                <?php endif; endforeach; ?>
            </div>
        </div>

        <!-- All Rates Table -->
        <div class="rates-table-section" id="rates-table-section">
            <h2 class="sub-title">Today's Exchange Rates (Base: EUR)</h2>
            <div class="table-search-wrap">
                <input type="text" id="rate-search" class="form-input table-search" placeholder="🔍 Search currency...">
            </div>
            <div class="table-wrap">
                <table class="rates-table" id="rates-table">
                    <thead>
                        <tr>
                            <th>Currency</th>
                            <th>Name</th>
                            <th>Rate (1 EUR =)</th>
                            <th>1 USD =</th>
                        </tr>
                    </thead>
                    <tbody id="rates-tbody">
                        <?php
                        $usdRate = $ratesData['rates']['USD'] ?? 1;
                        foreach ($ratesData['rates'] as $code => $rate):
                            $name = $names[$code] ?? $code;
                            $usdEquiv = isset($ratesData['rates']['USD']) ? round($rate / $ratesData['rates']['USD'], 4) : '—';
                        ?>
                        <tr class="rate-row" data-currency="<?= esc(strtolower($code)) ?>" data-name="<?= esc(strtolower($name)) ?>">
                            <td><strong class="rate-code"><?= esc($code) ?></strong></td>
                            <td class="rate-name"><?= esc($name) ?></td>
                            <td class="rate-value"><?= esc(number_format($rate, 4)) ?></td>
                            <td class="rate-usd"><?= esc($usdEquiv) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<script src="<?= base_url('assets/js/currency.js') ?>"></script>
