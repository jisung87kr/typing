<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>{{ config('app.name', '타이핑 연습') }}</title>

    @vite('resources/sass/app.scss')

    <!-- Custom styles for this Page-->
    @yield('custom_styles')

</head>
<body class="theme-light">
    <div class="page">
        <div class="sticky-top">
			<header class="navbar navbar-expand-md navbar-light sticky-top d-print-none">
				<div class="container-xl">
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
						<span class="navbar-toggler-icon"></span>
					</button>
					<h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
						<a href=".">
							타이핑 연습
						</a>
					</h1>
					<div class="navbar-nav flex-row order-md-last">

						@auth
						<div class="nav-item dropdown">
							<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
								<span class="avatar avatar-sm" style="background-image: url(https://eu.ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }})"></span>
								<div class="d-none d-xl-block ps-2">
									{{ auth()->user()->name ?? null }}
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
								<a href="{{ route('profile.show') }}" class="dropdown-item">프로필</a>
								<div class="dropdown-divider"></div>
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									<a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
										로그아웃
									</a>
								</form>
							</div>
						</div>
						@endauth
						@if(!Auth::user())
							<div class="nav-item @if(request()->routeIs('user')) active @endif">
								<a class="nav-link" href="{{ route('login') }}" >
									<span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										   <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
										   <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
										</svg>
									</span>
									<span class="nav-link-title">로그인</span>
								</a>
							</div>
						@endif

					</div>
				</div>
			</header>

         	 @include('layouts.navigation')

			</div>
			<div class="page-wrapper">

				@yield('content')

				<footer class="footer footer-transparent d-print-none">
					<div class="container-xl">
						<div class="row text-center align-items-center flex-row-reverse">
							<div class="col-12">@ujsstudio.com</div>
						</div>
					</div>
				</footer>
        	</div>
      	</div>
    </div>

    <!-- Core plugin JavaScript-->
    @vite('resources/js/app.js')

    <!-- Page level custom scripts -->
    @yield('custom_scripts')

</body>
</html>
