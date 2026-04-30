/**
 * Dashboard JavaScript
 * Extracted from inline scripts in dashboard/index.blade.php
 */

/**
 * Initialize dashboard when DOM is ready
 * This function expects the following global variables to be set:
 * - window.dashboardData.capaianPerKnmp
 * - window.dashboardData.labelKnmp
 * - window.dashboardData.distribusiAsetData
 * - window.dashboardData.distribusiAsetLabels
 * - window.dashboardData.penyerapanTenagaKerja
 * - window.dashboardData.penyerapanLabels
 * - window.dashboardData.tingkatKesejahteraanData
 * - window.dashboardData.tingkatKesejahteraanLabels
 * - window.dashboardData.desaKnmp
 * - window.dashboardData.detailUrlPattern
 */

// Store chart instances globally for access
var dashboardCharts = {
    capaian: null,
    distribusi: null,
    penyerapan: null,
    kesejahteraan: null
};

document.addEventListener('DOMContentLoaded', function () {
    // Ensure dashboard data is available
    if (typeof window.dashboardData === 'undefined') {
        console.error('Dashboard data not found');
        return;
    }

    var data = window.dashboardData;

    // Data from controller with fallback
    var capaianPerKnmpData = data.capaianPerKnmp || [];
    var labelKnmpData = data.labelKnmp || [];
    var distribusiAsetDataArr = data.distribusiAsetData || [];
    var distribusiAsetLabelsArr = data.distribusiAsetLabels || [];
    var penyerapanTenagaKerjaData = data.penyerapanTenagaKerja || [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var penyerapanLabelsData = data.penyerapanLabels || ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    var tingkatKesejahteraanDataArr = data.tingkatKesejahteraanData || [0, 0, 0, 0];
    var tingkatKesejahteraanLabelsArr = data.tingkatKesejahteraanLabels || ['Sangat Sejahtera', 'Sejahtera', 'Cukup Sejahtera', 'Kurang Sejahtera'];

    // Fallback if data is empty
    if (capaianPerKnmpData.length === 0) {
        capaianPerKnmpData = [44, 55, 57, 56, 61, 58, 63, 60, 66];
        labelKnmpData = ['KNMP 1', 'KNMP 2', 'KNMP 3', 'KNMP 4', 'KNMP 5', 'KNMP 6', 'KNMP 7', 'KNMP 8', 'KNMP 9'];
    }
    if (distribusiAsetDataArr.length === 0) {
        distribusiAsetDataArr = [44, 55, 41, 17, 15];
        distribusiAsetLabelsArr = ['Perahu', 'Alat Tangkap', 'Gedung', 'Kendaraan', 'Lainnya'];
    }

    // Helper to reset charts
    function resetApexChart(chart) {
        if (chart) {
            // For checking if it's a donut/pie with active selection
            // We can toggleDataPointSelection to turn off if we track state, 
            // but simple way for Donut is to force a redraw or trigger selection of -1
            // However, resetting selection in ApexCharts is tricky.
            // Best approach for "Click anywhere to reset":
            // 1. Zoom/Pan reset (for XY charts)
            // 2. Clear selection (for slice charts)
            
            // Try disabling selection state via updateOptions or firing an event
            // Actually, for Donut, if we click outside, the chart usually handles it if configured.
            // But we will strictly enforce it here.
            
            // Simulating click on currently active slice to validly deselect is hard without tracking.
            // So we use a hack: update series to same data (triggers animation and reset)
            // Or better: chart.updateOptions({ chart: { selection: { enabled: false } } }) then true? No.
            
            // Standard reset:
            chart.clearAnnotations(); // Just in case
        }
    }

    // ===================================
    // Chart 1: Capaian Indikator (ApexCharts Bar)
    // ===================================
    var capaianIndikatorOptions = {
        chart: {
            height: 309,
            type: 'bar',
            toolbar: { show: false },
            events: {
                // Feature: Click background to reset
                click: function(event, chartContext, config) {
                    if (config.globals.selectedDataPoints.length > 0 && 
                        (!config.seriesIndex || config.seriesIndex === -1)) {
                        chartContext.clearAnnotations();
                    }
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                borderRadius: 4
            }
        },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        series: [{
            name: 'Capaian',
            data: capaianPerKnmpData
        }],
        xaxis: {
            categories: labelKnmpData,
            labels: {
                style: { colors: '#6c757d' },
                rotate: -45,
                rotateAlways: true
            }
        },
        yaxis: {
            title: { text: 'Persentase (%)', style: { color: '#6c757d' } },
            labels: { style: { colors: '#6c757d' } },
            max: 100
        },
        fill: { opacity: 1 },
        tooltip: {
            y: { formatter: function (val) { return val + "%"; } }
        },
        colors: ['#0acf97'],
        grid: { borderColor: '#f1f3fa' },
        states: {
            active: {
                filter: { type: 'darken', value: 0.9 }
            },
            hover: {
                filter: { type: 'lighten', value: 0.1 }
            }
        }
    };

    var sessionsOverviewEl = document.querySelector("#sessions-overview");
    if (sessionsOverviewEl) {
        dashboardCharts.capaian = new ApexCharts(sessionsOverviewEl, capaianIndikatorOptions);
        dashboardCharts.capaian.render();
    }

    // ===================================
    // Chart 2: Distribusi Kategori Aset (Donut Chart)
    // ===================================
    var distribusiAsetOptions = {
        chart: {
            height: 350,
            type: 'donut',
            events: {
                dataPointSelection: function(event, chartContext, config) {
                    // Start of data point selection
                }
            }
        },
        series: distribusiAsetDataArr,
        labels: distribusiAsetLabelsArr,
        colors: ['#727cf5', '#0acf97', '#fa5c7c', '#ffbc00', '#39afd1'],
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            labels: { colors: '#6c757d' }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: 'bottom' }
            }
        }],
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Aset',
                            color: '#6c757d',
                            formatter: function (w) {
                                // Default total
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        },
                        value: {
                            show: true,
                            fontSize: '24px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 600,
                            color: '#374151',
                            offsetY: 10,
                            formatter: function (val) {
                                return val;
                            }
                        }
                    }
                },
                expandOnClick: true
            }
        }
    };

    var countryChartEl = document.querySelector("#country-chart");
    if (countryChartEl) {
        dashboardCharts.distribusi = new ApexCharts(countryChartEl, distribusiAsetOptions);
        dashboardCharts.distribusi.render();
        
        // Custom reset listener for Donut chart to handle "click anywhere"
        // ApexCharts doesn't universally trigger 'click' on background for Donuts easily to plain reset
        // allowing us to differentiate between slice click and bg click perfectly in all versions.
        // So we add a container listener.
        countryChartEl.addEventListener('click', function(e) {
            // If the click target is the svg background or base class, we try to reset
            if(e.target.classList.contains('apexcharts-canvas') || e.target.closest('.apexcharts-inner') === null) {
                // This is a rough heuristic.
                // Better approach: User asked for "Click Dimanapun" (Click Anywhere).
                // We rely on document body click listener below.
            }
        });
    }

    // ===================================
    // Chart 3: Penyerapan Tenaga Kerja (Chart.js Line)
    // ===================================
    var taskAreaChartEl = document.getElementById('task-area-chart');
    if (taskAreaChartEl) {
        var ctx = taskAreaChartEl.getContext('2d');

        dashboardCharts.penyerapan = new Chart(ctx, {
            type: 'line',
            data: {
                labels: penyerapanLabelsData,
                datasets: [{
                    label: 'Tenaga Kerja Terserap',
                    data: penyerapanTenagaKerjaData,
                    backgroundColor: 'rgba(114, 124, 245, 0.3)',
                    borderColor: '#727cf5',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#727cf5',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#727cf5'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f3fa' },
                        ticks: { color: '#6c757d' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6c757d' }
                    }
                },
                onClick: (e) => {
                    // Chart.js handles clicks, but if we want to "reset" something, we can do it here.
                    // Currently Chart.js doesn't have a persistent "selected" state for Line charts like ApexCharts Donut.
                    // But if it did (like active elements), we could clear them.
                }
            }
        });
    }

    // ===================================
    // Chart 4: Tingkat Kesejahteraan (Donut Chart)
    // ===================================
    var tingkatKesejahteraanOptions = {
        chart: {
            height: 350,
            type: 'donut'
        },
        series: tingkatKesejahteraanDataArr,
        labels: tingkatKesejahteraanLabelsArr,
        colors: ['#0acf97', '#727cf5', '#ffbc00', '#fa5c7c'],
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            labels: { colors: '#6c757d' }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            color: '#6c757d',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + '%';
                            }
                        }
                    }
                },
                expandOnClick: true
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: 'bottom' }
            }
        }]
    };

    var sessionsBrowserEl = document.querySelector("#sessions-browser");
    if (sessionsBrowserEl) {
        dashboardCharts.kesejahteraan = new ApexCharts(sessionsBrowserEl, tingkatKesejahteraanOptions);
        dashboardCharts.kesejahteraan.render();
    }

    /**
     * GLOBAL EVENT LISTENER FOR RESETTING CHARTS
     * Ref: User Request "ketika klik pada grafik dan klik dimanapun/esc maka data akan balik seperti semula"
     */

    // 1. Handle ESC Key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            resetAllCharts();
        }
    });

    // 2. Handle Click Outside or Empty Space
    // We listen to clicks on the document.
    document.addEventListener('click', function(event) {
        // Build list of chart containers
        var chartContainers = [
            document.querySelector("#sessions-overview"),
            document.querySelector("#country-chart"),
            document.querySelector("#sessions-browser"),
            document.getElementById("task-area-chart") // Chart.js canvas
        ];

        var clickedOnDataPoint = false;
        var clickedInsideChart = false;
        
        // Check where the click happened
        chartContainers.forEach(function(container) {
            if (container && container.contains(event.target)) {
                clickedInsideChart = true;
                
                // Identify if user clicked on a specific data point (slice, bar, point)
                // ApexCharts: Data points are usually 'path' (slices) or 'rect' (bars/columns) inside 'apexcharts-series'
                // We can check class names or parent hierarchy.
                var target = event.target;
                
                // ApexCharts specific checks
                if (target.classList.contains('apexcharts-pie-area') || 
                    target.classList.contains('apexcharts-bar-area') ||
                    target.getAttribute('j') !== null) { // 'j' attribute often used by ApexCharts for series index
                    clickedOnDataPoint = true;
                }
                
                // Chart.js specific (Canvas) - hard to detect click on specific point purely via DOM event target (it's always canvas)
                // But Chart.js usually handles its own interaction. 
                // We assume clicking canvas IS interacting, but if we want to support "click canvas empty space", 
                // we would need the chart instance `getElementsAtEventForMode`. 
                // For now, let's treat canvas click as a potential data interaction, unless we want to force reset.
            }
        });

        // If clicked outside ANY chart, OR clicked inside a chart but NOT on a data point (background)
        // trigger reset.
        if (!clickedInsideChart || (clickedInsideChart && !clickedOnDataPoint)) {
             resetAllCharts();
        }
    });

    function resetAllCharts() {
        // ApexCharts Reset (Donut/Pie reset selection)
        // There is no direct "deselect all" method for Donuts that is well documented for all states.
        // However, we can trick it by refreshing options or triggering dataPointMouseEnter with -1? No.
        // The most reliable way to reset the "Total" label in the center is to simulate hover out or simple refresh.
        // But refreshing is expensive. 
        // We will try updating series with same data. This is seamless in ApexCharts.
        
        if (dashboardCharts.distribusi) {
            dashboardCharts.distribusi.updateSeries(distribusiAsetDataArr); 
        }
        if (dashboardCharts.kesejahteraan) {
            dashboardCharts.kesejahteraan.updateSeries(tingkatKesejahteraanDataArr);
        }
        // Capaian Indicator usually doesn't hold state, but if we want to be sure:
        if (dashboardCharts.capaian) {
            // dashboardCharts.capaian.updateSeries([{ data: capaianPerKnmpData }]); // Optional, might flash
        }
    }
});

/**
 * Initialize Leaflet Map for KNMP locations
 */
function initDashboardMap() {
    if (typeof window.dashboardData === 'undefined' || typeof L === 'undefined') {
        return;
    }

    var data = window.dashboardData;
    var desaKNMP = data.desaKnmp || [];
    var detailUrlPattern = data.detailUrlPattern || '';

    // Prevent duplicate map instance
    if (window.mapInstance) {
        window.mapInstance.remove();
    }

    var mapContainer = document.getElementById("map-knmp");
    if (!mapContainer) return;

    var map = L.map("map-knmp", {
        zoomControl: false
    }).setView([-2.5, 118], 5);
    window.mapInstance = map;

    // Zoom control at bottom-right
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    // Modern CartoDB Voyager tile (clean, label-friendly)
    var cartoLight = L.tileLayer("https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png", {
        maxZoom: 19,
        attribution: '&copy; <a href="https://carto.com/">CARTO</a> &copy; <a href="https://www.openstreetmap.org/">OSM</a>'
    });

    // Google Satellite tile
    var googleSat = L.tileLayer("https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}", {
        maxZoom: 20,
        attribution: '&copy; Google Satellite'
    });

    // Default layer
    cartoLight.addTo(map);

    // Layer control
    L.control.layers({
        "Peta": cartoLight,
        "Satelit": googleSat
    }, null, { position: 'topright', collapsed: true }).addTo(map);

    // Custom marker icon (red dot circle)
    function createMarkerIcon(color) {
        return L.divIcon({
            className: 'knmp-marker',
            html: '<div style="width:14px;height:14px;border-radius:50%;background:' + color + ';border:2.5px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,0.3);"></div>',
            iconSize: [14, 14],
            iconAnchor: [7, 7]
        });
    }

    var defaultIcon = createMarkerIcon('#dc2626');
    var activeIcon = createMarkerIcon('#2563eb');
    var activeMarker = null;

    // Info card DOM
    var infoCard = document.getElementById('map-info-card');
    var infoName = document.getElementById('map-info-name');
    var infoLocation = document.getElementById('map-info-location');
    var infoProgres = document.getElementById('map-info-progres');
    var infoStats = document.getElementById('map-info-stats');
    var infoKomoditas = document.getElementById('map-info-komoditas');
    var infoLink = document.getElementById('map-info-link');

    // Helpers
    function formatRupiah(num) {
        if (!num || num == 0) return '-';
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }
    function formatNum(num) {
        if (!num && num !== 0) return '-';
        return Number(num).toLocaleString('id-ID');
    }

    function showInfoCard(item) {
        var profile = item.profile_knmp || {};
        var progres = item.progres_knmp || {};
        var progresNasional = item.latest_progres_nasional || null;
        var respondenCount = item.informasi_responden_count || 0;
        var detailUrl = detailUrlPattern.replace(':id', item.id);

        // Name & Location
        infoName.textContent = item.nama || 'KNMP #' + item.id;
        var locParts = [];
        if (item.village) locParts.push(item.village.name);
        if (item.district) locParts.push(item.district.name);
        if (item.regency) locParts.push(item.regency.name);
        infoLocation.textContent = locParts.join(', ') || '-';

        // Progres
        if (progresNasional) {
            var pVal = Number(progresNasional.progres);
            var pColor = '#ef4444';
            if (pVal >= 100) pColor = '#22c55e';
            else if (pVal >= 75) pColor = '#3b82f6';
            else if (pVal >= 50) pColor = '#f59e0b';
            infoProgres.innerHTML = '' +
                '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">' +
                    '<span style="font-size:0.65rem;font-weight:600;color:#334155;">Progres Pembangunan</span>' +
                    '<span style="font-size:0.7rem;font-weight:700;color:' + pColor + ';">' + pVal.toFixed(1) + '%</span>' +
                '</div>' +
                '<div style="background:#e2e8f0;border-radius:3px;height:5px;overflow:hidden;">' +
                    '<div style="background:' + pColor + ';height:100%;width:' + Math.min(pVal, 100) + '%;border-radius:3px;transition:width 0.3s;"></div>' +
                '</div>';
            infoProgres.style.display = '';
        } else {
            infoProgres.style.display = 'none';
        }

        // Stats grid
        infoStats.innerHTML = '' +
            '<div style="background:#fefce8;border-radius:6px;padding:5px 7px;">' +
                '<div style="font-size:0.6rem;color:#a16207;">Nelayan</div>' +
                '<div style="font-size:0.75rem;font-weight:700;color:#854d0e;">' + formatNum(profile.jml_nelayan) + '</div>' +
            '</div>' +
            '<div style="background:#f0fdf4;border-radius:6px;padding:5px 7px;">' +
                '<div style="font-size:0.6rem;color:#15803d;">Tenaga Kerja</div>' +
                '<div style="font-size:0.75rem;font-weight:700;color:#166534;">' + formatNum(progres.tk_total) + '</div>' +
            '</div>' +
            '<div style="background:#faf5ff;border-radius:6px;padding:5px 7px;">' +
                '<div style="font-size:0.6rem;color:#7e22ce;">Pendapatan</div>' +
                '<div style="font-size:0.68rem;font-weight:700;color:#6b21a8;">' + formatRupiah(profile.pendapatan_rata_rata_nelayan) + '</div>' +
            '</div>' +
            '<div style="background:#eff6ff;border-radius:6px;padding:5px 7px;">' +
                '<div style="font-size:0.6rem;color:#1d4ed8;">Responden</div>' +
                '<div style="font-size:0.75rem;font-weight:700;color:#1e40af;">' + formatNum(respondenCount) + '</div>' +
            '</div>';

        // Komoditas
        var komHtml = '';
        if (profile.komoditas_utama_1) {
            komHtml += '<span style="background:#dbeafe;color:#1e40af;border-radius:10px;padding:2px 8px;font-size:0.6rem;font-weight:500;margin-right:4px;">' + profile.komoditas_utama_1 + '</span>';
        }
        if (profile.komoditas_utama_2) {
            komHtml += '<span style="background:#e0e7ff;color:#4338ca;border-radius:10px;padding:2px 8px;font-size:0.6rem;font-weight:500;">' + profile.komoditas_utama_2 + '</span>';
        }
        infoKomoditas.innerHTML = komHtml;
        infoKomoditas.style.display = komHtml ? '' : 'none';

        // Link
        infoLink.href = detailUrl;

        // Show
        infoCard.style.display = 'block';
    }

    // Add markers
    desaKNMP.forEach(function (item) {
        if (item.latitude !== null && item.longitude !== null) {
            var marker = L.marker([item.latitude, item.longitude], { icon: defaultIcon });
            marker.addTo(map);

            marker.on('click', function () {
                // Reset previous active marker
                if (activeMarker) {
                    activeMarker.setIcon(defaultIcon);
                }
                activeMarker = marker;
                marker.setIcon(activeIcon);
                showInfoCard(item);
            });
        }
    });

    // Click on map background → hide info card
    map.on('click', function (e) {
        if (activeMarker) {
            activeMarker.setIcon(defaultIcon);
            activeMarker = null;
        }
        if (infoCard) infoCard.style.display = 'none';
    });

    // Fix map render
    setTimeout(() => map.invalidateSize(), 300);
}

// Call map initialization when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initDashboardMap();
});

/**
 * Display current date in Indonesian format
 */
(function () {
    var dateDisplayEl = document.getElementById('current-date-display');
    if (dateDisplayEl) {
        var now = new Date();
        var options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        dateDisplayEl.textContent = now.toLocaleDateString('id-ID', options);
    }
})();
