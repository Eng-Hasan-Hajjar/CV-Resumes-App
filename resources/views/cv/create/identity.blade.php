@extends('admin.base.base')
@section('title')
Fill Profile
@endsection
@section('content')
<cv-register-fill-identity></cv-register-fill-identity>
@endsection
@section('script')
<script src="{{ asset('/assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
@endsection