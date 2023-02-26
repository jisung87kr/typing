<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">
                    @isset($menus)
                    @foreach($menus as $menu)
                        <li class="nav-item @if(request()->routeIs($menu['routeName'])) active @endif">
                            <a class="nav-link" href="{{ route($menu['routeName']) }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                {!! $menu['icon'] !!}
                            </span>
                                <span class="nav-link-title">{{ $menu['title'] }}</span>
                            </a>
                        </li>
                    @endforeach
                    @endisset
                </ul>
            </div>
        </div>
    </div>
</div>