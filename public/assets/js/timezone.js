(function() {
    const dtEl     = document.getElementById('tz-datetime');
    const fromEl   = document.getElementById('tz-from');
    const toEl     = document.getElementById('tz-to');
    const resultEl = document.getElementById('tz-result');
    const swapBtn  = document.getElementById('tz-swap-btn');
    const form     = document.getElementById('tz-form');
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const baseUrlMeta = document.querySelector('meta[name="base-url"]');
    const submitBtn = document.getElementById('tz-submit-btn');

    if (!dtEl || !fromEl || !toEl || !form) return;
    
    const baseUrl = baseUrlMeta ? baseUrlMeta.getAttribute('content') : '/';
    const rawEndpoint = form.getAttribute('data-endpoint');
    const endpoint = rawEndpoint && !/^https?:\/\//.test(rawEndpoint) ? baseUrl + rawEndpoint : rawEndpoint;

    const now = new Date();
    const pad = n => String(n).padStart(2, '0');
    if (!dtEl.value) {
        dtEl.value = now.getFullYear() + '-' + pad(now.getMonth()+1) + '-' + pad(now.getDate())
                   + 'T' + pad(now.getHours()) + ':' + pad(now.getMinutes());
    }

    function doConvert() {
        if (!dtEl.value) {
            resultEl.replaceChildren(createSpan('Select date & time above to convert', 'result-placeholder'));
            return;
        }

        resultEl.replaceChildren(createSpan('Converting...', 'result-loading'));

        const fd = new FormData();
        fd.append('datetime', dtEl.value);
        fd.append('from', fromEl.value);
        fd.append('to', toEl.value);
        
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
                const fromSpan = createSpan(data.from.formatted + ' (' + data.from.abbr + ')', 'tz-val-from');
                const eqSpan = createSpan(' equals ', 'tz-val-eq');
                const toSpan = createSpan(data.to.formatted + ' (' + data.to.abbr + ')', 'tz-val-to');
                
                const offSpan = document.createElement('div');
                offSpan.className = 'tz-offset-info';
                offSpan.textContent = 'Time difference: ' + data.difference;

                resultEl.appendChild(fromSpan);
                resultEl.appendChild(eqSpan);
                resultEl.appendChild(toSpan);
                resultEl.appendChild(offSpan);
                
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

    dtEl.addEventListener('change', doConvert);
    fromEl.addEventListener('change', doConvert);
    toEl.addEventListener('change', doConvert);
    if (submitBtn) submitBtn.addEventListener('click', doConvert);
    
    if (swapBtn) {
        swapBtn.addEventListener('click', function() {
            const tmp = fromEl.value; fromEl.value = toEl.value; toEl.value = tmp;
            doConvert();
        });
    }

    doConvert();
})();
