<ul class="submenu {{ $activeMenu }}">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            {{-- active menu method --}}
            @php
                $activeClass = null;
                $active = 'active';
                $currentRouteName = Route::currentRouteName();
                
                if ($currentRouteName === $submenu->slug) {
                    $activeClass = 'active';
                } elseif (isset($submenu->submenu)) {
                    if (gettype($submenu->slug) === 'array') {
                        foreach ($submenu->slug as $slug) {
                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                $activeClass = $active;
                            }
                        }
                    } else {
                        if (str_contains($currentRouteName, $submenu->slug) and strpos($currentRouteName, $submenu->slug) === 0) {
                            $activeClass = $active;
                        }
                    }
                }
            @endphp

            {{-- <ul class="submenu ">
                <li class="submenu-item ">
                    <a href="component-alert.html">Alert</a>
                </li>
            </ul> --}}

            <li class="submenu-item {{ $activeClass }}">
                <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                    @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
                    {{ isset($submenu->name) ? __($submenu->name) : '' }}
                </a>
            </li>
        @endforeach
    @endif
</ul>
