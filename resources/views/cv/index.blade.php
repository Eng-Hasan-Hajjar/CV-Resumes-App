@extends('admin.base.base')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<daftar-cv></daftar-cv>
@endsection