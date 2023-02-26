@extends('layouts.guest')
@section('content')
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        비밀번호를 잊어 버렸습니까? 괜찮아요. 이메일 주소를 알려주시면 새 비밀번호를 선택할 수 있는 비밀번호 재설정 링크를 이메일로 보내드립니다.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="btn btn-primary">이메일 비밀번호 재설정 링크</button>
        </div>
    </form>
@endsection
