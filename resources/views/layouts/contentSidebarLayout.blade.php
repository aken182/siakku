@extends('layouts.commonMaster')
@section('pageStyle')
    @include('layouts.sections.styles.styles-app')
@endsection
@section('contentLayout')
    <div id="app">
        @include('layouts.sections.sidebar.sidebar')

        <div id="main" class='layout-navbar'>

            @include('layouts.sections.header.header')

            <div id="main-content">

                @yield('content')

                @include('layouts.sections.footer.footer')

            </div>
        </div>
    </div>
@endsection
