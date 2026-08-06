<!-- Timezone Converter Page -->
<section class="converter-page" id="timezone-page">
    <div class="container">
        <div class="page-header">
            <div class="page-icon-wrap tz-icon">🌍</div>
            <div>
                <h1 class="page-title">Time Zone Converter</h1>
                <p class="page-subtitle">Convert times between 40+ world time zones instantly</p>
            </div>
        </div>

        <div class="converter-card-main glass-card" id="tz-converter">
            <form id="tz-form" data-endpoint="<?= base_url('timezone/convert') ?>" novalidate>
                <div class="unit-row tz-row">
                    <div class="input-group flex-1">
                        <label class="input-label" for="tz-datetime">Date & Time</label>
                        <input type="datetime-local" id="tz-datetime" class="form-input" name="datetime" required>
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="tz-from">From Timezone</label>
                        <select id="tz-from" class="form-select" name="from">
                            <?php foreach ($timezones as $tz => $label): ?>
                            <option value="<?= esc($tz) ?>" <?= ($tz === 'Asia/Kolkata') ? 'selected' : '' ?>>
                                <?= esc($label) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="swap-btn-container">
                        <button type="button" class="swap-btn" id="tz-swap-btn" aria-label="Swap timezones">⇄</button>
                    </div>
                    <div class="input-group flex-1">
                        <label class="input-label" for="tz-to">To Timezone</label>
                        <select id="tz-to" class="form-select" name="to">
                            <?php foreach ($timezones as $tz => $label): ?>
                            <option value="<?= esc($tz) ?>" <?= ($tz === 'America/New_York') ? 'selected' : '' ?>>
                                <?= esc($label) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-submit-container">
                    <button type="button" id="tz-submit-btn" class="btn btn-primary">Convert Time</button>
                </div>

                <div class="unit-result-display tz-result-display" id="tz-result">
                    <span class="result-placeholder">Select date & time above to convert</span>
                </div>
            </form>
        </div>

        <!-- World Clock -->
        <div class="reference-section">
            <h2 class="sub-title">World Clock (Current Times)</h2>
            <div class="world-clock-grid" id="world-clock">
                <?php
                $clocks = [
                    'New York'  => 'America/New_York',
                    'London'    => 'Europe/London',
                    'Dubai'     => 'Asia/Dubai',
                    'India'     => 'Asia/Kolkata',
                    'Singapore' => 'Asia/Singapore',
                    'Tokyo'     => 'Asia/Tokyo',
                    'Sydney'    => 'Australia/Sydney',
                    'Los Angeles' => 'America/Los_Angeles',
                ];
                foreach ($clocks as $city => $tz):
                    $dt = new DateTime('now', new DateTimeZone($tz));
                ?>
                <div class="clock-card glass-card-sm" id="clock-<?= esc(strtolower(str_replace(' ', '-', $city))) ?>">
                    <div class="clock-city"><?= esc($city) ?></div>
                    <div class="clock-time"><?= esc($dt->format('H:i')) ?></div>
                    <div class="clock-date"><?= esc($dt->format('D, d M')) ?></div>
                    <div class="clock-tz"><?= esc($dt->format('T')) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('assets/js/timezone.js') ?>"></script>
