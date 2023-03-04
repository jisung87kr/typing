@extends('layouts.guest')
@section('content')
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        가입해주셔서 감사합니다! 시작하기 전에 이메일로 보내드린 링크를 클릭하여 이메일 주소를 확인해 주시겠습니까? 이메일을 받지 못하셨다면 기꺼이 다른 이메일을 보내드리겠습니다.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            등록 시 제공한 이메일 주소로 새로운 확인 링크가 전송되었습니다.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button class="btn btn-primary mb-3">
                    확인 이메일을 다시 보내기
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="btn btn-secondary">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
@endsection