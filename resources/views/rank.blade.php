@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="my-5">랭킹</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>아이디</th>
                <th>최고 스피드</th>
                <th>평균 스피드</th>
                <th>총 문항수</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->max_wpm }} WPM</td>
                    <td>{{ number_format($user->avg_wpm) }} WPM</td>
                    <td>{{ number_format($user->sentence_cnt) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection