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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>
<script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
{{-- <script src="{{ asset('assets/js/pages/demo.dashboard-analytics.js') }}"></script> --}}
<!-- end demo js-->

@stack('script')
