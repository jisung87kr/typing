@extends('layouts.base')
@section('content')
    <h1 class="my-5">
        {{ $user->name }}
    </h1>
    <div class="row g-3">
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div>전체시간</div>
                    <h3 class="mt-2">@if($user->used_time){{ gmdate('H:i:s', $user->used_time) }}@else --:--:-- @endif</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div>총 문항</div>
                    <h3 class="mt-2">{{ number_format($user->sentence_cnt) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div>최고속도</div>
                    <h3 class="mt-2">{{ number_format($user->max_wpm) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div>평균속도</div>
                    <h3 class="mt-2">{{ number_format($user->avg_wpm) }}</h3>
                </div>
            </div>
        </div>
    </div>
    @if($user->name)
    <div>
        <h1 class="my-5">출석일</h1>
        <ul class="list-group mt-3">
            @foreach($user->logins as $login)
            <li class="list-group-item">{{ $login->created_at }}</li>
            @endforeach
        </ul>
    </div>
    @endif

@endsection