@extends('layouts.guest')

@section('content')
    <form class="card card-md" action="{{ route('login') }}" method="post" autocomplete="off">
        @csrf

        <div class="card-body">
{{--            <h2 class="card-title text-center mb-4">로그인 하세요</h2>--}}

            <div class="mb-3">
                <label class="form-label">이메일</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="이메일 입력" required autofocus tabindex="1">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    비밀번호
                    @if (Route::has('password.request'))
                    <span class="form-label-description">
                        <a href="{{ route('password.request') }}" tabindex="5">비밀번호를 잊으셨나요?</a>
                    </span>
                    @endif
                </label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" required tabindex="2">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" tabindex="3" name="remember" />
                    <span class="form-check-label">비밀번호 기억하기</span>
                </label>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100" tabindex="4">로그인</button>
            </div>
        </div>
    </form>

    @if (Route::has('register'))
    <div class="text-center text-muted mt-3">
        아직 계정이 없으신가요 ? <a href="{{ route('register') }}" tabindex="-1">회원가입</a>
    </div>
    @endif

@endsection
