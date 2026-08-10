(function () {
    'use strict';
    if (document.body.classList.contains('admin-page')) return;

    const storageKey = 'currefy_visitor_key';
    const trackUrl = document.querySelector('meta[name="analytics-url"]')?.content || '/analytics/track';
    const visitorKey = localStorage.getItem(storageKey) || (crypto.randomUUID ? crypto.randomUUID() : String(Date.now()) + Math.random());
    localStorage.setItem(storageKey, visitorKey);
    const visitToken = crypto.randomUUID ? crypto.randomUUID() : String(Date.now()) + Math.random();
    const startedAt = Date.now();
    let lastSent = 0;

    function track(action) {
        const duration = Math.round((Date.now() - startedAt) / 1000);
        const data = new URLSearchParams({
            action: action,
            visitor_key: visitorKey,
            visit_token: visitToken,
            page_path: window.location.pathname,
            page_title: document.title,
            duration_seconds: String(duration)
        });
        if (action === 'heartbeat' && duration - lastSent < 10) return;
        lastSent = duration;
        if (action === 'end' && navigator.sendBeacon) {
            navigator.sendBeacon(trackUrl, data);
        } else {
            fetch(trackUrl, {method: 'POST', body: data, keepalive: true, credentials: 'same-origin'}).catch(function () {});
        }
    }

    track('start');
    const interval = setInterval(function () { track('heartbeat'); }, 15000);
    document.addEventListener('visibilitychange', function () { if (document.visibilityState === 'hidden') track('heartbeat'); });
    window.addEventListener('pagehide', function () { clearInterval(interval); track('end'); });
})();
