(function() {
    const amountEl   = document.getElementById('currency-amount');
    const fromEl     = document.getElementById('currency-from');
    const toEl       = document.getElementById('currency-to');
    const resultEl   = document.getElementById('currency-result-display');
    const rateInfoEl = document.getElementById('rate-info-text');
    const swapBtn    = document.getElementById('currency-swap-btn');
    const copyBtn    = document.getElementById('copy-result-btn');
    const searchEl   = document.getElementById('rate-search');
    const tbody      = document.getElementById('rates-tbody');
    const submitBtn  = document.getElementById('currency-submit-btn');
    const csrfMeta   = document.querySelector('meta[name="csrf-token"]');
    const baseUrlMeta = document.querySelector('meta[name="base-url"]');
    
    // Safety check - only run on currency page
    if (!amountEl || !fromEl || !toEl) return;
    
    const baseUrl = baseUrlMeta ? baseUrlMeta.getAttribute('content') : '/';

    let currentResult = '';

    function doConvert() {
        const amount = parseFloat(amountEl.value);
        const from   = fromEl.value;
        const to     = toEl.value;

        if (isNaN(amount) || amount <= 0) {
            resultEl.replaceChildren(createSpan('—', 'result-loading'));
            rateInfoEl.textContent = 'Enter an amount above';
            copyBtn.classList.add('d-none');
            return;
        }

        resultEl.replaceChildren(createSpan('Converting...', 'result-loading'));
        copyBtn.classList.add('d-none');

        const fd = new FormData();
        fd.append('amount', amount);
        fd.append('from', from);
        fd.append('to', to);
        
        if (csrfMeta) {
            fd.append('csrf_token', csrfMeta.getAttribute('content'));
        }

        fetch(baseUrl + 'currency/convert', {
            method: 'POST',
            body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            resultEl.replaceChildren();
            if (data.success) {
                const formatted = new Intl.NumberFormat('en-US', { maximumFractionDigits: 4 }).format(data.result);
                currentResult = formatted + ' ' + to;
                resultEl.appendChild(createSpan(currentResult, 'result-value-text'));
                rateInfoEl.textContent = '1 ' + from + ' = ' + data.rate + ' ' + to + '  ·  Rate date: ' + data.date;
                copyBtn.classList.remove('d-none');
                
                // Update rates table highlight safely using classList
                document.querySelectorAll('.rates-table tbody tr').forEach(tr => {
                    tr.classList.remove('highlight-row');
                    if (tr.children[0].textContent === to) {
                        tr.classList.add('highlight-row');
                    }
                });
                
                if (data.csrfHash && csrfMeta) {
                    csrfMeta.setAttribute('content', data.csrfHash);
                }
            } else {
                resultEl.appendChild(createSpan('Error: ' + data.error, 'result-error'));
                rateInfoEl.textContent = '';
            }
        })
        .catch(() => {
            resultEl.replaceChildren(createSpan('Network error', 'result-error'));
        });
    }

    function createSpan(text, cls) {
        const s = document.createElement('span');
        s.className = cls;
        s.textContent = text;
        return s;
    }

    amountEl.addEventListener('input', doConvert);
    fromEl.addEventListener('change', doConvert);
    toEl.addEventListener('change', doConvert);
    if (submitBtn) submitBtn.addEventListener('click', doConvert);

    swapBtn.addEventListener('click', function() {
        const tmp = fromEl.value; fromEl.value = toEl.value; toEl.value = tmp;
        doConvert();
    });

    copyBtn.addEventListener('click', function() {
        if (navigator.clipboard && currentResult) {
            navigator.clipboard.writeText(currentResult).then(() => {
                const orig = copyBtn.textContent;
                copyBtn.textContent = '✅ Copied!';
                setTimeout(() => { copyBtn.textContent = orig; }, 1500);
            });
        }
    });

    // Search rates table safely
    searchEl.addEventListener('input', function() {
        const q = searchEl.value.toLowerCase().trim();
        const rows = tbody.querySelectorAll('.rate-row');
        rows.forEach(function(row) {
            const currency = row.getAttribute('data-currency') || '';
            const name     = row.getAttribute('data-name') || '';
            if (currency.includes(q) || name.includes(q)) {
                row.classList.remove('d-none');
            } else {
                row.classList.add('d-none');
            }
        });
    });

    // Initial convert
    doConvert();
})();
