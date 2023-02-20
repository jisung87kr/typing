<style>
    .sidebar{
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        z-index: 100;
        padding: 48px 0 0;
        box-shadow: inset -1px 0 0 rgb(0 0 0 / 10%);
    }

    .sidebar a{
        color: #333;
    }

    .nav-item{
        font-size: 18px;
    }
</style>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            @if(!Auth::user())
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('login') }}">
                        <i class="bi bi-person me-1"></i>
                        로그인
                    </a>
                </li>
            @else
                <li class="nav-item" x-data="">
                    <a class="nav-link active" aria-current="page" href="{{ route('logout') }}" @click.prevent="document.getElementById('logout').submit()">
                        <form action="{{ route('logout') }}" method="POST" id="logout">
                            @csrf
                            @method('POST')
                        </form>
                        <i class="bi bi-person-slash me-1"></i>
                        로그아웃
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <i class="bi bi-house me-1"></i>
                    홈
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                    <i class="bi bi-gem me-1"></i>
                    랭킹
                </a>
            </li>
        </ul>
    </div>
</nav>