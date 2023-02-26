@extends('layouts.app')

@section('content')
    <div class="page-body">
        <div class="container-xl">

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    새로운 확인 링크가 귀하의 이메일 주소로 전송되었습니다.
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        이메일 주소를 확인
                    </div>
                </div>
                <div class="card-body">
                    <p>계속하기 전에 이메일에서 확인 링크를 확인하십시오.</p>

                    이메일을 받지 못한 경우

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf

                        <button type="submit" class="btn btn-primary">
                            다른 것을 요청하려면 여기를 클릭하십시오</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
