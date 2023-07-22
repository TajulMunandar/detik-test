<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<!-- Datatables JS -->
<script type="text/javascript" src="{{ asset('assets/DataTables/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/DataTables/DataTables-1.13.1/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/DataTables/DataTables-1.13.1/js/dataTables.bootstrap5.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('assets/js/datatables.js') }}"></script>

{{-- scroll --}}
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
