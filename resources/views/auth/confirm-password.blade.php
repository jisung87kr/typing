@extends('layouts.guest')
@section('content')
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        이것은 응용 프로그램의 보안 영역입니다. 계속하기 전에 비밀번호를 확인하십시오.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <button class="btn btn-primary">확인</button>
        </div>
    </form>
@endsection