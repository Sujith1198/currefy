/* ============================================================
   Currefy.com — Main App JavaScript
   - Mobile nav toggle
   - Navbar scroll effect
   - Smooth scroll for anchor links
   Security: No innerHTML used. All DOM manipulation via safe methods.
   ============================================================ */

(function () {
    'use strict';

    /* ---- Mobile Navigation ---- */
    const toggle = document.getElementById('nav-toggle');
    const menu   = document.getElementById('nav-menu');

    if (toggle && menu) {
        toggle.addEventListener('click', function () {
            const open = menu.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open);
        });

        // Close menu on outside click
        document.addEventListener('click', function (e) {
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close on nav link click (mobile)
        menu.querySelectorAll('.nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                menu.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /* ---- Navbar scroll effect ---- */
    const navbar = document.getElementById('main-nav');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 20) {
                navbar.style.background = 'rgba(7,7,15,0.97)';
            } else {
                navbar.style.background = 'rgba(7,7,15,0.85)';
            }
        }, { passive: true });
    }

    /* ---- Smooth scroll for # links ---- */
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const id = anchor.getAttribute('href').slice(1);
            const target = document.getElementById(id);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    /* ---- Dropdown nav accessibility ---- */
    const dropdowns = document.querySelectorAll('.nav-dropdown');
    dropdowns.forEach(function (dd) {
        const btn = dd.querySelector('.nav-dropdown-toggle');
        const ddMenu = dd.querySelector('.nav-dropdown-menu');
        if (btn && ddMenu) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isOpen = ddMenu.style.display === 'block';
                ddMenu.style.display = isOpen ? '' : 'block';
                btn.setAttribute('aria-expanded', !isOpen);
            });
        }
    });

    /* ---- Format numbers nicely ---- */
    window.CurrefyFmt = function (num, decimals) {
        if (num === null || num === undefined || isNaN(num)) return '—';
        const d = decimals !== undefined ? decimals : 4;
        return new Intl.NumberFormat('en-US', {
            maximumFractionDigits: d,
            minimumFractionDigits: 0,
        }).format(num);
    };

    /* ---- Reveal on scroll (Intersection Observer) ---- */
    if ('IntersectionObserver' in window) {
        const revealObs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity  = '1';
                    entry.target.style.transform = 'translateY(0)';
                    revealObs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.feature-item, .ref-card').forEach(function (el) {
            el.style.opacity  = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            revealObs.observe(el);
        });
    }

})();
