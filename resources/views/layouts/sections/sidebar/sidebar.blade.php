<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="/"><img src="{{ asset('assets/admin') }}/images/logo/logo-kpri.png" alt="Logo"
                            srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        @include('layouts.sections.menu.verticalMenu')

        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
