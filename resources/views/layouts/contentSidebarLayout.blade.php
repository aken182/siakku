@extends('layouts.commonMaster')

@section('contentLayout')
    @include('layouts.sections.sidebar.sidebar')

    <div id="main" class='layout-navbar'>

        @include('layouts.sections.header.header')

        <div id="main-content">

            @yield('content')

            @include('layouts.sections.footer.footer')

        </div>
    </div>
@endsection
