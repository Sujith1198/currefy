(function() {
    const amountEl = document.querySelector('.unit-amount');
    const fromEl   = document.querySelector('.unit-from');
    const toEl     = document.querySelector('.unit-to');
    const resultEl = document.querySelector('.unit-result-display');
    const form     = document.querySelector('.unit-converter-form');
    const formulaEl= document.querySelector('.conversion-formula');
    const swapBtn  = document.querySelector('.unit-swap');
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const baseUrlMeta = document.querySelector('meta[name="base-url"]');
    
    if (!form || !amountEl || !fromEl || !toEl) return;

    const baseUrl = baseUrlMeta ? baseUrlMeta.getAttribute('content') : '/';
    const rawEndpoint = form.getAttribute('data-endpoint');
    const endpoint = rawEndpoint && !/^https?:\/\//.test(rawEndpoint) ? baseUrl + rawEndpoint : rawEndpoint;

    function formatNumber(num) {
        if (Math.abs(num) < 0.0001 && num !== 0) {
            return num.toExponential(4);
        }
        return new Intl.NumberFormat('en-US', { maximumFractionDigits: 6 }).format(num);
    }

    function doConvert() {
        const amount = parseFloat(amountEl.value);
        const from   = fromEl.value;
        const to     = toEl.value;

        if (isNaN(amount)) {
            resultEl.replaceChildren(createSpan('Enter amount to convert', 'result-placeholder'));
            if (formulaEl) formulaEl.textContent = '';
            return;
        }

        resultEl.replaceChildren(createSpan('Converting...', 'result-loading'));

        const fd = new FormData();
        fd.append('amount', amount);
        fd.append('from', from);
        fd.append('to', to);
        
        if (csrfMeta) {
            fd.append('csrf_token', csrfMeta.getAttribute('content'));
        }

        fetch(endpoint, {
            method: 'POST',
            body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            resultEl.replaceChildren();
            if (data.success) {
                const fromName   = data.from.name + ' (' + data.from.symbol + ')';
                const toName     = data.to.name + ' (' + data.to.symbol + ')';
                const formatted  = formatNumber(data.result);

                const amtSpan = createSpan(
                    formatNumber(amount) + ' ' + data.from.symbol, 'result-from-val'
                );
                const eqSpan = createSpan(' = ', 'result-eq');
                const resSpan = createSpan(
                    formatted + ' ' + data.to.symbol, 'result-to-val'
                );

                resultEl.appendChild(amtSpan);
                resultEl.appendChild(eqSpan);
                resultEl.appendChild(resSpan);

                if (formulaEl) {
                    const factor = amount !== 0 ? data.result / amount : 0;
                    formulaEl.textContent = '1 ' + data.from.symbol + ' = ' + formatNumber(factor) + ' ' + data.to.symbol;
                }
                
                if (data.csrfHash && csrfMeta) {
                    csrfMeta.setAttribute('content', data.csrfHash);
                }
            } else {
                resultEl.appendChild(createSpan('Error: ' + (data.error || 'Conversion failed'), 'result-error'));
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
    
    const submitBtn = form.querySelector('.unit-submit-btn');
    if (submitBtn) {
        submitBtn.addEventListener('click', doConvert);
    }

    if (swapBtn) {
        swapBtn.addEventListener('click', function() {
            const tmp = fromEl.value; fromEl.value = toEl.value; toEl.value = tmp;
            doConvert();
        });
    }

    doConvert();
})();
