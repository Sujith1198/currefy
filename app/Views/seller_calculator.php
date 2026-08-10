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
                        <input type="text" id="seller-platform" class="form-input" value="Custom / Direct website" list="seller-platform-options" autocomplete="off" placeholder="Search a platform">
                        <datalist id="seller-platform-options">
                            <option value="Custom / Direct website"></option>
                            <option value="Amazon India"></option>
                            <option value="Flipkart"></option>
                            <option value="Meesho"></option>
                            <option value="Myntra"></option>
                            <option value="AJIO"></option>
                            <option value="Nykaa"></option>
                            <option value="Amazon Global"></option>
                            <option value="eBay"></option>
                            <option value="Etsy"></option>
                            <option value="Walmart Marketplace"></option>
                            <option value="Shopify"></option>
                            <option value="WooCommerce"></option>
                            <option value="Facebook / Instagram Shop"></option>
                            <option value="TikTok Shop"></option>
                            <option value="Daraz"></option>
                            <option value="Shopee"></option>
                            <option value="Lazada"></option>
                            <option value="noon"></option>
                        </datalist>
                        <small class="seller-field-note" id="seller-platform-note">Enter your own platform charges.</small>
                    </div>
                    <div class="input-group seller-currency-field">
                        <label class="input-label" for="seller-currency">Currency</label>
                        <select id="seller-currency" class="form-select">
                            <option value="INR">INR - Indian Rupee</option>
                            <option value="USD">USD - US Dollar</option>
                            <option value="EUR">EUR - Euro</option>
                            <option value="GBP">GBP - British Pound</option>
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
