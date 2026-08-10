<!-- Online Seller Calculator -->
<section class="converter-page seller-page" id="seller-calculator-page">
    <div class="container">
        <div class="page-header">
            <div class="page-icon-wrap currency-icon">🧾</div>
            <div>
                <h1 class="page-title">Online Seller Calculator</h1>
                <p class="page-subtitle">Know your real profit after marketplace, payment, and delivery costs</p>
            </div>
        </div>

        <div class="seller-calculator-layout">
            <div class="seller-input-card glass-card">
                <div class="seller-card-heading">
                    <div>
                        <h2>Product numbers</h2>
                        <p>Enter your costs and selling price</p>
                    </div>
                    <span class="seller-heading-mark">01</span>
                </div>

                <div class="seller-form-grid">
                    <div class="input-group seller-platform-field">
                        <label class="input-label" for="seller-platform">Selling platform</label>
                        <select id="seller-platform" class="form-select">
                            <option value="custom">Custom / Direct website</option>
                            <option value="amazon-in">Amazon India</option>
                            <option value="flipkart">Flipkart</option>
                            <option value="meesho">Meesho</option>
                            <option value="myntra">Myntra</option>
                            <option value="ajio">AJIO</option>
                            <option value="nykaa">Nykaa</option>
                            <option value="amazon-global">Amazon Global</option>
                            <option value="ebay">eBay</option>
                            <option value="etsy">Etsy</option>
                            <option value="walmart">Walmart Marketplace</option>
                            <option value="shopify">Shopify</option>
                            <option value="woocommerce">WooCommerce</option>
                            <option value="facebook">Facebook / Instagram Shop</option>
                            <option value="tiktok">TikTok Shop</option>
                            <option value="daraz">Daraz</option>
                            <option value="shopee">Shopee</option>
                            <option value="lazada">Lazada</option>
                            <option value="noon">noon</option>
                        </select>
                        <small class="seller-field-note" id="seller-platform-note">Enter your own platform charges.</small>
                    </div>
                    <div class="input-group seller-currency-field">
                        <label class="input-label" for="seller-currency">Currency</label>
                        <select id="seller-currency" class="form-select">
                            <?php foreach (($currencyNames ?? []) as $code => $name): ?>
                            <option value="<?= esc($code) ?>" <?= ($code === 'USD') ? 'selected' : '' ?>>
                                <?= esc($code) ?> - <?= esc($name) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="seller-price">Selling price</label>
                        <input type="number" id="seller-price" class="form-input seller-number-input" value="1499" min="0" step="0.01" inputmode="decimal">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="seller-product-cost">Product cost</label>
                        <input type="number" id="seller-product-cost" class="form-input seller-number-input" value="700" min="0" step="0.01" inputmode="decimal">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="seller-shipping">Shipping cost</label>
                        <input type="number" id="seller-shipping" class="form-input seller-number-input" value="80" min="0" step="0.01" inputmode="decimal">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="seller-platform-fee">Platform fee (%)</label>
                        <input type="number" id="seller-platform-fee" class="form-input seller-number-input" value="15" min="0" max="100" step="0.01" inputmode="decimal">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="seller-payment-fee">Payment fee (%)</label>
                        <input type="number" id="seller-payment-fee" class="form-input seller-number-input" value="2" min="0" max="100" step="0.01" inputmode="decimal">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="seller-fixed-fee">Fixed order fee</label>
                        <input type="number" id="seller-fixed-fee" class="form-input seller-number-input" value="0" min="0" step="0.01" inputmode="decimal">
                    </div>
                </div>

                <div class="seller-extra-heading">
                    <h3>Additional charges</h3>
                    <span>Optional per-order costs</span>
                </div>
                <div class="seller-form-grid seller-extra-grid">
                    <div class="input-group">
                        <label class="input-label" for="seller-packaging">Packaging cost</label>
                        <input type="number" id="seller-packaging" class="form-input seller-number-input" value="0" min="0" step="0.01" inputmode="decimal">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="seller-advertising">Advertising (%)</label>
                        <input type="number" id="seller-advertising" class="form-input seller-number-input" value="0" min="0" max="100" step="0.01" inputmode="decimal">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="seller-return">Returns reserve (%)</label>
                        <input type="number" id="seller-return" class="form-input seller-number-input" value="0" min="0" max="100" step="0.01" inputmode="decimal">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="seller-tax">Tax / withholding (%)</label>
                        <input type="number" id="seller-tax" class="form-input seller-number-input" value="0" min="0" max="100" step="0.01" inputmode="decimal">
                    </div>
                    <div class="input-group seller-currency-field">
                        <label class="input-label" for="seller-extra-cost">Other fixed costs</label>
                        <input type="number" id="seller-extra-cost" class="form-input seller-number-input" value="0" min="0" step="0.01" inputmode="decimal">
                    </div>
                </div>

                <p class="seller-form-note">Platform defaults are estimates. Check your seller agreement and update the fee fields for exact results.</p>
            </div>

            <div class="seller-result-card glass-card" aria-live="polite">
                <div class="seller-card-heading">
                    <div>
                        <h2>Your result</h2>
                        <p>Estimated earnings per order</p>
                    </div>
                    <span class="seller-heading-mark seller-heading-mark-accent">02</span>
                </div>

                <div class="seller-profit-panel" id="seller-profit-panel">
                    <span class="seller-result-label">Net profit</span>
                    <strong id="seller-net-profit">-</strong>
                    <span id="seller-profit-status" class="seller-profit-status">Enter your numbers</span>
                </div>

                <div class="seller-stats-grid">
                    <div class="seller-stat"><span>Total costs</span><strong id="seller-total-cost">-</strong></div>
                    <div class="seller-stat"><span>All fees</span><strong id="seller-fees">-</strong></div>
                    <div class="seller-stat"><span>Profit margin</span><strong id="seller-margin">-</strong></div>
                    <div class="seller-stat"><span>Break-even price</span><strong id="seller-break-even">-</strong></div>
                </div>

                <div class="seller-breakdown" id="seller-breakdown" aria-label="Detailed charge breakdown"></div>
                <div class="seller-summary" id="seller-summary">Your calculation will appear here.</div>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('assets/js/seller_calculator.js') ?>"></script>
