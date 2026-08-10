(function() {
    const page = document.getElementById('seller-calculator-page');
    if (!page) return;

    const fields = {
        platform: document.getElementById('seller-platform'),
        currency: document.getElementById('seller-currency'),
        price: document.getElementById('seller-price'),
        productCost: document.getElementById('seller-product-cost'),
        shipping: document.getElementById('seller-shipping'),
        platformFee: document.getElementById('seller-platform-fee'),
        paymentFee: document.getElementById('seller-payment-fee'),
        fixedFee: document.getElementById('seller-fixed-fee'),
        packaging: document.getElementById('seller-packaging'),
        advertising: document.getElementById('seller-advertising'),
        returnReserve: document.getElementById('seller-return'),
        tax: document.getElementById('seller-tax'),
        extraCost: document.getElementById('seller-extra-cost')
    };
    const platformNote = document.getElementById('seller-platform-note');
    const outputs = {
        profit: document.getElementById('seller-net-profit'),
        status: document.getElementById('seller-profit-status'),
        totalCost: document.getElementById('seller-total-cost'),
        fees: document.getElementById('seller-fees'),
        margin: document.getElementById('seller-margin'),
        breakEven: document.getElementById('seller-break-even'),
        breakdown: document.getElementById('seller-breakdown'),
        summary: document.getElementById('seller-summary'),
        panel: document.getElementById('seller-profit-panel')
    };

    const platforms = {
        custom: { platform: 0, payment: 2, note: 'Enter your own platform charges.' },
        'amazon-in': { platform: 15, payment: 2, note: 'Typical estimate; category and fulfilment can change this.' },
        flipkart: { platform: 15, payment: 2, note: 'Typical estimate; category and shipping plan can change this.' },
        meesho: { platform: 0, payment: 2, note: 'Shipping and optional services may still apply.' },
        myntra: { platform: 25, payment: 2, note: 'Typical fashion marketplace estimate.' },
        ajio: { platform: 25, payment: 2, note: 'Typical estimate; check your AJIO seller contract.' },
        nykaa: { platform: 20, payment: 2, note: 'Typical estimate; category and contract can change this.' },
        'amazon-global': { platform: 15, payment: 3, note: 'Typical estimate; referral and international fees vary.' },
        ebay: { platform: 13.25, payment: 3, note: 'Typical estimate; final value fees vary by category and country.' },
        etsy: { platform: 6.5, payment: 3, note: 'Typical estimate; listing and ad fees may also apply.' },
        walmart: { platform: 15, payment: 3, note: 'Typical estimate; category referral fees vary.' },
        shopify: { platform: 0, payment: 2.9, note: 'Platform plan is not included; payment fee estimate shown.' },
        woocommerce: { platform: 0, payment: 2.9, note: 'Hosting, plugins, and payment gateway charges are not included.' },
        facebook: { platform: 5, payment: 2.9, note: 'Commerce and payment fees vary by market.' },
        tiktok: { platform: 6, payment: 2.9, note: 'Typical estimate; market and campaign fees vary.' },
        daraz: { platform: 15, payment: 2, note: 'Typical estimate; category commission varies.' },
        shopee: { platform: 10, payment: 2, note: 'Typical estimate; country and campaign fees vary.' },
        lazada: { platform: 10, payment: 2, note: 'Typical estimate; country and campaign fees vary.' },
        noon: { platform: 15, payment: 2, note: 'Typical estimate; category and fulfilment fees vary.' }
    };
    const platformNames = {
        custom: 'Custom / Direct website',
        'amazon-in': 'Amazon India',
        flipkart: 'Flipkart',
        meesho: 'Meesho',
        myntra: 'Myntra',
        ajio: 'AJIO',
        nykaa: 'Nykaa',
        'amazon-global': 'Amazon Global',
        ebay: 'eBay',
        etsy: 'Etsy',
        walmart: 'Walmart Marketplace',
        shopify: 'Shopify',
        woocommerce: 'WooCommerce',
        facebook: 'Facebook / Instagram Shop',
        tiktok: 'TikTok Shop',
        daraz: 'Daraz',
        shopee: 'Shopee',
        lazada: 'Lazada',
        noon: 'noon'
    };

    function numberValue(field) {
        const value = parseFloat(field.value);
        return Number.isFinite(value) && value >= 0 ? value : 0;
    }

    function formatMoney(value) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(value) + ' ' + fields.currency.value;
    }

    function applyPlatformDefaults(platformKey) {
        const preset = platforms[platformKey];
        fields.platformFee.value = preset.platform;
        fields.paymentFee.value = preset.payment;
        platformNote.textContent = preset.note;
        calculate();
    }

    function renderBreakdown(items) {
        outputs.breakdown.innerHTML = '<h3>Detailed calculation</h3>' + items.map(function(item) {
            return '<div class="seller-breakdown-row"><span>' + item.label + '</span><strong>' + formatMoney(item.value) + '</strong></div>';
        }).join('');
    }

    function calculate() {
        const price = numberValue(fields.price);
        const productCost = numberValue(fields.productCost);
        const shipping = numberValue(fields.shipping);
        const platformFee = numberValue(fields.platformFee);
        const paymentFee = numberValue(fields.paymentFee);
        const fixedFee = numberValue(fields.fixedFee);
        const packaging = numberValue(fields.packaging);
        const advertising = numberValue(fields.advertising);
        const returnReserve = numberValue(fields.returnReserve);
        const tax = numberValue(fields.tax);
        const extraCost = numberValue(fields.extraCost);
        const platformCharge = price * platformFee / 100;
        const paymentCharge = price * paymentFee / 100;
        const advertisingCharge = price * advertising / 100;
        const returnCharge = price * returnReserve / 100;
        const taxCharge = price * tax / 100;
        const totalCost = productCost + shipping + fixedFee + packaging + extraCost + platformCharge + paymentCharge + advertisingCharge + returnCharge + taxCharge;
        const profit = price - totalCost;
        const margin = price > 0 ? (profit / price) * 100 : 0;
        const feeTotal = platformCharge + paymentCharge + fixedFee + advertisingCharge + returnCharge + taxCharge;
        const variableRate = (platformFee + paymentFee + advertising + returnReserve + tax) / 100;
        const fixedCosts = productCost + shipping + packaging + extraCost + fixedFee;
        const breakEven = variableRate < 1 ? fixedCosts / (1 - variableRate) : 0;

        outputs.profit.textContent = formatMoney(profit);
        outputs.totalCost.textContent = formatMoney(totalCost);
        outputs.fees.textContent = formatMoney(feeTotal);
        outputs.margin.textContent = price > 0 ? margin.toFixed(1) + '%' : '-';
        outputs.breakEven.textContent = variableRate < 1 ? formatMoney(breakEven) : 'Not available';
        renderBreakdown([
            { label: 'Product cost', value: productCost },
            { label: 'Shipping', value: shipping },
            { label: 'Platform fee', value: platformCharge },
            { label: 'Payment fee', value: paymentCharge },
            { label: 'Fixed order fee', value: fixedFee },
            { label: 'Packaging', value: packaging },
            { label: 'Advertising', value: advertisingCharge },
            { label: 'Returns reserve', value: returnCharge },
            { label: 'Tax / withholding', value: taxCharge },
            { label: 'Other fixed costs', value: extraCost }
        ]);
        outputs.panel.classList.toggle('seller-loss', profit < 0);

        if (price <= 0) {
            outputs.status.textContent = 'Add a selling price';
            outputs.summary.textContent = 'Enter a selling price to see your estimated earnings.';
        } else if (profit < 0) {
            outputs.status.textContent = 'Loss on each order';
            outputs.summary.textContent = 'Your costs are higher than the selling price. Increase the price or reduce costs.';
        } else {
            outputs.status.textContent = 'Profit on each order';
            outputs.summary.textContent = 'After all listed costs, you keep ' + formatMoney(profit) + ' from each order.';
        }
    }

    Object.values(fields).forEach(function(field) {
        field.addEventListener('input', calculate);
        field.addEventListener('change', calculate);
    });

    fields.platform.addEventListener('change', function() {
        applyPlatformDefaults(fields.platform.value);
    });
    calculate();
})();
