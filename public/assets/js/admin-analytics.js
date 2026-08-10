(function () {
    'use strict';

    if (typeof DataTable === 'undefined') return;

    new DataTable('#visitors-table', {
        pageLength: 25,
        order: [[4, 'desc']]
    });

    new DataTable('#pages-table', {
        pageLength: 25,
        order: [[1, 'desc']]
    });
})();
