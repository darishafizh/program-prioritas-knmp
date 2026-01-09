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

    var map = L.map("map-knmp").setView([-2.5, 118], 5);
    window.mapInstance = map;

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19
    }).addTo(map);

    // Red icon
    var redIcon = new L.Icon({
        iconUrl: "https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-red.png",
        shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
    });

    // Add markers
    desaKNMP.forEach(function (item) {
        if (item.latitude !== null && item.longitude !== null) {
            var detailUrl = detailUrlPattern.replace(':id', item.id);
            var popupContent = `
                <div class="p-1">
                    <h6 class="mb-2 text-primary fw-bold" style="font-size: 14px;">${item.nama ?? "Lokasi KNMP " + item.id}</h6>
                    <div class="mb-2 small text-muted">
                        <div class="mb-1"><i class="mdi mdi-map-marker-radius me-1 text-danger"></i> 
                            ${item.village ? item.village.name : '-'}, ${item.district ? item.district.name : '-'}
                        </div>
                        <div><i class="mdi mdi-city me-1 text-secondary"></i>
                            ${item.regency ? item.regency.name : '-'}, ${item.province ? item.province.name : '-'}
                        </div>
                    </div>
                    <a href="${detailUrl}" class="btn btn-xs btn-primary w-100 rounded-pill">
                        <i class="mdi mdi-eye me-1"></i> Lihat Data Survey
                    </a>
                </div>
            `;

            L.marker([item.latitude, item.longitude], { icon: redIcon })
                .addTo(map)
                .bindPopup(popupContent, { minWidth: 200 });
        }
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
