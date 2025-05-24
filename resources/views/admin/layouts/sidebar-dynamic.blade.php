<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('compiled/svg/hearts.svg') }}" alt="Logo" style="height: 3rem;">
                    </a>
                </div>
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                    <!-- theme icons omitted for brevity -->
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label"></label>
                    </div>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu" id="sidebar-menu-container">
            <ul class="menu">
                @foreach ($sidebarMenus as $group => $menus)
                    @php
                        // Filter group hanya jika masih punya menu valid
                        $validMenus = $menus->filter(function ($menu) {
                            return $menu->route_name !== '#' || ($menu->children && $menu->children->isNotEmpty());
                        });
                    @endphp

                    @if ($validMenus->isNotEmpty())
                        @if (!empty($group))
                            <li class="sidebar-title">{{ $group }}</li>
                        @endif

                        @foreach ($validMenus as $menu)
                            @php
                                $children = $menu->children ?? collect();
                                $isActive =
                                    request()->routeIs($menu->route_name . '*') ||
                                    $children
                                        ->pluck('route_name')
                                        ->filter()
                                        ->contains(function ($route) {
                                            return request()->routeIs($route . '*');
                                        });
                            @endphp

                            <li
                                class="sidebar-item {{ $children->isNotEmpty() ? 'has-sub' : '' }} {{ $isActive ? 'active' : '' }}">
                                <a href="{{ $menu->route_name !== '#' ? route($menu->route_name) : '#' }}"
                                    class="sidebar-link">
                                    @if (!empty($menu->icon))
                                        <i class="{{ $menu->icon }}"></i>
                                    @endif
                                    <span>{{ $menu->title }}</span>
                                </a>

                                @if ($children->isNotEmpty())
                                    <ul class="submenu">
                                        @foreach ($children as $child)
                                            @if ($child->route_name !== '#')
                                                <li
                                                    class="submenu-item {{ request()->routeIs($child->route_name . '*') ? 'active' : '' }}">
                                                    <a href="{{ route($child->route_name) }}" class="submenu-link">
                                                        {{ $child->title }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
