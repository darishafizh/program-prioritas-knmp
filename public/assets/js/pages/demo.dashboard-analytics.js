!(function (i) {
  "use strict";

  function e() {
    (this.$body = i("body")), (this.charts = []);
  }

  // Safe Render Function
  function safeRender(selector, options) {
    const el = document.querySelector(selector);
    if (!el) {
      console.warn("ApexCharts skipped: Element not found →", selector);
      return;
    }
    try {
      new ApexCharts(el, options).render();
    } catch (err) {
      console.error("ApexCharts Error on", selector, err);
    }
  }

  e.prototype.initCharts = function () {
    window.Apex = {
      chart: { parentHeightOffset: 0, toolbar: { show: !1 } },
      grid: { padding: { left: 0, right: 0 } },
      colors: ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"]
    };

    var e = new Date(),
      t = (function (e, t) {
        for (
          var a = new Date(t, e, 1), o = [], r = 0;
          a.getMonth() === e && r < 15;

        ) {
          var s = new Date(a);
          o.push(
            s.getDate() +
            " " +
            s.toLocaleString("en-us", { month: "short" })
          ),
            a.setDate(a.getDate() + 1),
            (r += 1);
        }
        return o;
      })(e.getMonth() + 1, e.getFullYear()),
      a = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"],
      o = i("#sessions-overview").data("colors");

    o && (a = o.split(","));

    // 1. SESSIONS OVERVIEW
    safeRender("#sessions-overview", {
      chart: { height: 309, type: "area" },
      dataLabels: { enabled: !1 },
      stroke: { curve: "smooth", width: 4 },
      series: [
        {
          name: "Sessions",
          data: [
            10, 20, 5, 15, 10, 20, 15, 25, 20, 30, 25, 40, 30, 50, 35
          ]
        }
      ],
      zoom: { enabled: !1 },
      legend: { show: !1 },
      colors: a,
      xaxis: {
        type: "string",
        categories: t,
        tooltip: { enabled: !1 },
        axisBorder: { show: !1 }
      },
      yaxis: {
        labels: {
          formatter: function (e) {
            return e + "k";
          },
          offsetX: -15
        }
      },
      fill: {
        type: "gradient",
        gradient: {
          type: "vertical",
          shadeIntensity: 1,
          inverseColors: !1,
          opacityFrom: 0.45,
          opacityTo: 0.05,
          stops: [45, 100]
        }
      }
    });

    // 2. VIEWS MINUTES BAR
    var s = [];
    for (var n = 10; 1 <= n; n--) s.push(n + " min ago");

    a = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"];
    (o = i("#views-min").data("colors")) && (a = o.split(","));

    safeRender("#views-min", {
      chart: { height: 150, type: "bar", stacked: !0 },
      plotOptions: {
        bar: {
          horizontal: !1,
          endingShape: "rounded",
          columnWidth: "22%",
          dataLabels: { position: "top" }
        }
      },
      dataLabels: {
        enabled: !0,
        offsetY: -24,
        style: { fontSize: "12px", colors: ["#98a6ad"] }
      },
      series: [
        {
          name: "Views",
          data: (function (e) {
            for (var t = [], a = 0; a < e; a++)
              t.push(Math.floor(90 * Math.random()) + 10);
            return t;
          })(10)
        }
      ],
      zoom: { enabled: !1 },
      legend: { show: !1 },
      colors: a,
      xaxis: {
        categories: s,
        labels: { show: !1 },
        axisTicks: { show: !1 },
        axisBorder: { show: !1 }
      },
      yaxis: { labels: { show: !1 } }
    });

    // 3. SESSIONS BROWSER RADAR
    a = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"];
    (o = i("#sessions-browser").data("colors")) &&
      (a = o.split(","));

    safeRender("#sessions-browser", {
      chart: { height: 343, type: "radar" },
      series: [{ name: "Usage", data: [80, 50, 30, 40, 60, 20] }],
      labels: [
        "Chrome",
        "Firefox",
        "Safari",
        "Opera",
        "Edge",
        "Explorer"
      ],
      colors: a,
      dataLabels: { enabled: !0 }
    });

    // 4. COUNTRY CHART BAR
    a = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"];
    (o = i("#country-chart").data("colors")) &&
      (a = o.split(","));

    safeRender("#country-chart", {
      chart: { height: 320, type: "bar" },
      plotOptions: { bar: { horizontal: !0 } },
      colors: a,
      dataLabels: { enabled: !1 },
      series: [
        {
          name: "Sessions",
          data: [90, 75, 60, 50, 45, 36, 28, 20, 15, 12]
        }
      ],
      xaxis: {
        categories: [
          "India",
          "China",
          "United States",
          "Japan",
          "France",
          "Italy",
          "Netherlands",
          "United Kingdom",
          "Canada",
          "South Korea"
        ],
        axisBorder: { show: !1 }
      }
    });

    // 5. SESSIONS OS RADIAL BAR
    a = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"];
    (o = i("#sessions-os").data("colors")) &&
      (a = o.split(","));

    safeRender("#sessions-os", {
      chart: { height: 268, type: "radialBar" },
      plotOptions: {
        radialBar: {
          dataLabels: {
            name: { fontSize: "22px" },
            value: { fontSize: "16px" },
            total: {
              show: !0,
              label: "OS",
              formatter: function () {
                return 8541;
              }
            }
          }
        }
      },
      colors: a,
      series: [44, 55, 67, 83],
      labels: ["Windows", "Macintosh", "Linux", "Android"]
    });
  };

  e.prototype.initMaps = function () {
    if (i("#world-map-markers").length > 0) {
      i("#world-map-markers").vectorMap({
        map: "world_mill_en",
        normalizeFunction: "polynomial",
        hoverOpacity: 0.7,
        backgroundColor: "transparent",
        zoomOnScroll: !1
      });
    }
  };

  e.prototype.init = function () {
    i("#dash-daterange").daterangepicker({
      singleDatePicker: !0
    });

    this.initCharts();
    this.initMaps();
  };

  (i.AnalyticsDashboard = new e()),
    (i.AnalyticsDashboard.Constructor = e);
})(window.jQuery),
  (function () {
    "use strict";
    window.jQuery.AnalyticsDashboard.init();
  })();
