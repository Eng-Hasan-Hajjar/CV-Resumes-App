@extends('admin.base.base')

@section('style')
<link rel="stylesheet" href="{{ asset('/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <profile-detail-component :profile-id="{{ request()->segment(3) }}"></profile-detail-component>
@endsection

@section('script')
<script src="{{ asset('/assets/adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Toastr -->
<!--<script src="{{ asset('/assets/adminlte/plugins/toastr/toastr.min.js') }}"></script>-->
@endsection