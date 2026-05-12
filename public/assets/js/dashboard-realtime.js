/**
 * Dashboard Real-Time Updates (AJAX Polling)
 * Polls the server every 15 seconds for fresh dashboard data
 * and updates the DOM without page refresh.
 */

(function () {
    'use strict';

    var POLL_INTERVAL = 15000; // 15 seconds
    var pollTimer = null;
    var isPolling = false;

    // Map of API response keys to DOM element IDs
    var kpiMapping = {
        'totalKnmp': 'kpi-totalKnmp',
        'ketersediaanInfrastruktur': 'kpi-ketersediaanInfrastruktur',
        'pendapatanRtNelayan': 'kpi-pendapatanRtNelayan',
        'indeksKesesuaianKebutuhan': 'kpi-indeksKesesuaianKebutuhan',
        'indeksKesejahteraan': 'kpi-indeksKesejahteraan',
        'tingkatKelembagaan': 'kpi-tingkatKelembagaan',
    };

    /**
     * Show the real-time indicator
     */
    function showIndicator(text, isLoading) {
        var indicator = document.getElementById('realtime-indicator');
        var spinner = document.getElementById('realtime-spinner');
        var check = document.getElementById('realtime-check');
        var textEl = document.getElementById('realtime-text');

        if (!indicator) return;

        indicator.style.display = 'block';
        textEl.textContent = text;

        if (isLoading) {
            spinner.style.display = '';
            check.style.display = 'none';
        } else {
            spinner.style.display = 'none';
            check.style.display = '';
        }
    }

    /**
     * Hide the real-time indicator after a delay
     */
    function hideIndicator(delay) {
        setTimeout(function () {
            var indicator = document.getElementById('realtime-indicator');
            if (indicator) {
                indicator.style.display = 'none';
            }
        }, delay || 2000);
    }

    /**
     * Animate a value change with a brief highlight effect
     */
    function animateUpdate(element) {
        element.style.transition = 'color 0.3s ease, transform 0.3s ease';
        element.style.color = '#10B981';
        element.style.transform = 'scale(1.05)';

        setTimeout(function () {
            element.style.color = '';
            element.style.transform = '';
        }, 800);
    }

    /**
     * Update a single KPI card value
     */
    function updateKpi(elementId, newValue) {
        var el = document.getElementById(elementId);
        if (!el) return;

        var currentValue = el.textContent.trim();
        if (currentValue !== String(newValue).trim()) {
            el.textContent = newValue;
            animateUpdate(el);
        }
    }

    /**
     * Update the progress national table
     */
    function updateProgresTable(data) {
        var tbody = document.getElementById('progres-nasional-tbody');
        if (!tbody || !data.progresNasionalData) return;

        var rows = data.progresNasionalData;
        var html = '';

        for (var i = 0; i < rows.length; i++) {
            var item = rows[i];
            var colorClass = 'bg-danger';
            if (item.progres >= 100) colorClass = 'bg-success';
            else if (item.progres >= 75) colorClass = 'bg-primary';
            else if (item.progres >= 50) colorClass = 'bg-warning';

            var deltaHtml = '<span class="text-muted"><i class="mdi mdi-minus"></i> 0.00%</span>';
            if (item.delta > 0) {
                deltaHtml = '<span class="text-success"><i class="mdi mdi-arrow-up"></i> +' + parseFloat(item.delta).toFixed(2) + '%</span>';
            } else if (item.delta < 0) {
                deltaHtml = '<span class="text-danger"><i class="mdi mdi-arrow-down"></i> ' + parseFloat(item.delta).toFixed(2) + '%</span>';
            }

            var ketHtml = '<span class="text-muted">-</span>';
            if (item.keterangan) {
                var kets = item.keterangan.split(',');
                ketHtml = '<div>';
                for (var k = 0; k < kets.length; k++) {
                    ketHtml += '<span class="badge bg-soft-info text-info me-1">' + kets[k].trim() + '</span>';
                }
                ketHtml += '</div>';
            }

            html += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td class="fw-semibold">' + escapeHtml(item.nama) + '</td>' +
                '<td><span class="text-muted fst-italic">' + (item.nama_jasa_konstruksi || '-') + '</span></td>' +
                '<td>' +
                    '<div class="d-flex justify-content-between align-items-center mb-1">' +
                        '<span class="fw-bold ' + (item.progres >= 100 ? 'text-success' : 'text-dark') + '" style="font-size: 0.85rem;">' +
                            parseFloat(item.progres).toFixed(2).replace('.', ',') + '%' +
                        '</span>' +
                    '</div>' +
                    '<div class="progress" style="height: 6px; background-color: #f1f3fa; border-radius: 3px;">' +
                        '<div class="progress-bar ' + colorClass + '" role="progressbar" ' +
                            'style="width: ' + item.progres + '%; border-radius: 3px;" ' +
                            'aria-valuenow="' + item.progres + '" aria-valuemin="0" aria-valuemax="100"></div>' +
                    '</div>' +
                '</td>' +
                '<td class="text-end fw-bold">' + deltaHtml + '</td>' +
                '<td class="d-flex align-items-center justify-content-between">' +
                    ketHtml +
                    '<button type="button" class="btn btn-sm btn-outline-primary ms-2 btn-edit-keterangan" ' +
                        'data-id="' + item.id + '" ' +
                        'data-knmp="' + escapeHtml(item.nama) + '" ' +
                        'data-keterangan="' + (item.keterangan || '') + '">' +
                        '<i class="mdi mdi-pencil"></i>' +
                    '</button>' +
                '</td>' +
                '</tr>';
        }

        tbody.innerHTML = html;

        // Update progress summary badges
        var countEl = document.getElementById('kpi-progresCount');
        if (countEl) {
            countEl.innerHTML = '<i class="mdi mdi-map-marker me-1"></i> ' + data.progresNasionalCount + ' Lokasi';
        }
        var selesaiEl = document.getElementById('kpi-progresSelesai');
        if (selesaiEl) {
            selesaiEl.innerHTML = '<i class="mdi mdi-check-circle me-1"></i> ' + data.progresNasionalSelesai + ' Selesai (100%)';
        }

        // Update average
        var avgEl = document.getElementById('kpi-progresNasionalAvg');
        if (avgEl) {
            var newAvgText = data.progresNasionalAvg + '%';
            if (avgEl.textContent.trim() !== newAvgText) {
                avgEl.textContent = newAvgText;
                animateUpdate(avgEl);
            }
        }
    }

    /**
     * Escape HTML to prevent XSS
     */
    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    /**
     * Build the API URL with current filters
     */
    function buildApiUrl() {
        var url = window.dashboardApiUrl || '/dashboard/api/data';
        var params = [];

        if (window.dashboardPeriod && window.dashboardPeriod !== 'all') {
            params.push('period=' + encodeURIComponent(window.dashboardPeriod));
        }
        if (window.dashboardProgresDate) {
            params.push('progres_date=' + encodeURIComponent(window.dashboardProgresDate));
        }

        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        return url;
    }

    /**
     * Fetch fresh data and update the dashboard
     */
    function pollDashboard() {
        if (isPolling) return;
        isPolling = true;

        showIndicator('Memperbarui data...', true);

        fetch(buildApiUrl(), {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
            .then(function (response) {
                if (!response.ok) throw new Error('HTTP ' + response.status);
                return response.json();
            })
            .then(function (data) {
                // Update KPI cards
                Object.keys(kpiMapping).forEach(function (key) {
                    if (data[key] !== undefined) {
                        updateKpi(kpiMapping[key], data[key]);
                    }
                });

                // Update progress table
                updateProgresTable(data);

                showIndicator('Data diperbarui · ' + (data.timestamp || ''), false);
                hideIndicator(3000);
            })
            .catch(function (error) {
                console.warn('[Dashboard Realtime] Polling error:', error.message);
                showIndicator('Gagal memperbarui', false);
                hideIndicator(3000);
            })
            .finally(function () {
                isPolling = false;
            });
    }

    /**
     * Start the polling interval
     */
    function startPolling() {
        if (pollTimer) return;

        // First poll after initial delay
        pollTimer = setInterval(pollDashboard, POLL_INTERVAL);

        console.log('[Dashboard Realtime] Polling started (every ' + (POLL_INTERVAL / 1000) + 's)');
    }

    /**
     * Stop polling (e.g. when tab is hidden)
     */
    function stopPolling() {
        if (pollTimer) {
            clearInterval(pollTimer);
            pollTimer = null;
            console.log('[Dashboard Realtime] Polling paused');
        }
    }

    // Visibility API: pause polling when tab is hidden
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            stopPolling();
        } else {
            // Immediately poll when tab becomes visible, then resume interval
            pollDashboard();
            startPolling();
        }
    });

    // Start polling when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startPolling);
    } else {
        startPolling();
    }

})();
