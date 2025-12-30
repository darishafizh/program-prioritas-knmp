<!-- bundle -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- third party js -->
<script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/fixedColumns.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/fixedHeader.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/chart.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- third party js ends -->

<!-- demo app -->

<script src="{{ asset('assets/js/ui/component.fileupload.js') }}"></script>
<!-- end demo js -->

<!-- Safe Bootstrap component init -->
<script>
    document.addEventListener("DOMContentLoaded", function () {

        // Tooltip
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
            try {
                let instance = bootstrap.Tooltip.getInstance(el);
                if (instance) instance.dispose();
                new bootstrap.Tooltip(el, {
                    container: 'body',
                    trigger: 'hover'
                });
            } catch (e) {
                console.warn("Tooltip skipped:", el, e);
            }
        });

        // Popover
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function (el) {
            try {
                let instance = bootstrap.Popover.getInstance(el);
                if (instance) instance.dispose();
                new bootstrap.Popover(el, {
                    container: 'body',
                    trigger: 'focus'
                });
            } catch (e) {
                console.warn("Popover skipped:", el, e);
            }
        });

        // Offcanvas (jika ada)
        document.querySelectorAll('.offcanvas').forEach(function (el) {
            try {
                let instance = bootstrap.Offcanvas.getInstance(el);
                if (!instance) new bootstrap.Offcanvas(el);
            } catch (e) {
                console.warn("Offcanvas skipped:", el, e);
            }
        });

    });
</script>

<!-- Additional scripts -->
@stack('script')