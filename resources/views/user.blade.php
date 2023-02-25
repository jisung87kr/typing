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
                    <h3 class="mt-2">{{ gmdate('H:i:s', $user->used_time) }}</h3>
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
    <div>
        <h1 class="my-5">출석일</h1>
        <ul class="list-group mt-3">
            <li class="list-group-item">2023-01-01 00:00:00</li>
            <li class="list-group-item">2023-01-01 00:00:00</li>
            <li class="list-group-item">2023-01-01 00:00:00</li>
            <li class="list-group-item">2023-01-01 00:00:00</li>
            <li class="list-group-item">2023-01-01 00:00:00</li>
            <li class="list-group-item">2023-01-01 00:00:00</li>
            <li class="list-group-item">2023-01-01 00:00:00</li>
        </ul>
    </div>

@endsection