(function () {
    'use strict';

    const amountEl = document.getElementById('qc-amount');
    const fromEl   = document.getElementById('qc-from');
    const toEl     = document.getElementById('qc-to');
    const resultEl = document.getElementById('qc-result');
    const swapBtn  = document.getElementById('qc-swap');

    if (!amountEl || !fromEl || !toEl || !resultEl || !swapBtn) return;

    const baseUrlMeta = document.querySelector('meta[name="base-url"]');
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const baseUrl = baseUrlMeta ? baseUrlMeta.getAttribute('content') : '/';

    function createSpan(text, cls) {
        const s = document.createElement('span');
        s.className = cls;
        s.textContent = text;
        return s;
    }

    function doConvert() {
        const amount = parseFloat(amountEl.value);
        const from   = fromEl.value;
        const to     = toEl.value;

        if (isNaN(amount) || amount <= 0) {
            resultEl.replaceChildren(createSpan('Enter a valid amount', 'result-placeholder'));
            return;
        }

        const fd = new FormData();
        fd.append('amount', amount);
        fd.append('from', from);
        fd.append('to', to);

        if (csrfMeta) {
            fd.append('csrf_token', csrfMeta.getAttribute('content'));
        }

        fetch(baseUrl + 'api/currency', {
            method: 'POST',
            body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            resultEl.replaceChildren();
            if (data.success) {
                const formatted = new Intl.NumberFormat('en-US', { maximumFractionDigits: 4 }).format(data.result);
                const rateFormatted = new Intl.NumberFormat('en-US', { maximumFractionDigits: 6 }).format(data.rate);

                const amtSpan = createSpan(amount + ' ' + from + ' = ', 'result-amount');
                const valSpan = createSpan(formatted + ' ' + to, 'result-value');
                const rateSpan = createSpan('1 ' + from + ' = ' + rateFormatted + ' ' + to, 'result-rate');

                resultEl.appendChild(amtSpan);
                resultEl.appendChild(valSpan);
                resultEl.appendChild(rateSpan);
            } else {
                resultEl.appendChild(createSpan(data.error || 'Conversion failed', 'result-error'));
            }
        })
        .catch(() => {
            resultEl.replaceChildren(createSpan('Network error. Please try again.', 'result-error'));
        });
    }

    amountEl.addEventListener('input', doConvert);
    fromEl.addEventListener('change', doConvert);
    toEl.addEventListener('change', doConvert);

    swapBtn.addEventListener('click', function () {
        const tmp = fromEl.value;
        fromEl.value = toEl.value;
        toEl.value = tmp;
        doConvert();
    });

    doConvert();
})();
