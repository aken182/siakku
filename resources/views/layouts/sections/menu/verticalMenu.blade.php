<div class="sidebar-menu">
    <ul class="menu">
        @foreach ($menuData[0]->menu as $menu)
            @can($menu->permission)
                {{-- menu headers --}}
                @if (isset($menu->menuHeader))
                    <li class="sidebar-title">{{ $menu->menuHeader }}</li>
                @else
                    {{-- active menu method --}}
                    @php
                        $activeClass = null;
                        $currentRouteName = Route::currentRouteName();

                        if ($currentRouteName === $menu->slug) {
                            $activeClass = 'active';
                        } elseif (isset($menu->submenu)) {
                            if (gettype($menu->slug) === 'array') {
                                foreach ($menu->slug as $slug) {
                                    if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                        $activeClass = 'active';
                                    }
                                }
                            } else {
                                if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                    $activeClass = 'active';
                                }
                            }
                        }
                    @endphp

                    {{-- main menu --}}
                    <li class="sidebar-item {{ $activeClass }} {{ isset($menu->submenu) ? 'has-sub' : '' }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class='sidebar-link'>
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <span>{{ isset($menu->name) ? __($menu->name) : '' }}</span>
                        </a>

                        {{-- submenu --}}
                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu', [
                                'menu' => $menu->submenu,
                                'activeMenu' => $activeClass,
                            ])
                        @endisset
                    </li>
                @endif
            @endcan
        @endforeach
    </ul>
</div>
