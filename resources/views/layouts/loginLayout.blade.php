@extends('layouts.commonMaster')
@section('pageStyle')
    @include('layouts.sections.styles.styles-auth')
@endsection
@section('contentLayout')
    <!-- Content -->
    @yield('content')
    <!--/ Content -->
@endsection
