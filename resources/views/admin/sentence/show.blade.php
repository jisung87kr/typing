@extends('layouts.app')
@section('content')
    <div class="container my-3">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <colgroup>
                        <col width="20%">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>문장</th>
                        <td>{{ $sentence->sentence }}</td>
                    </tr>
                    <tr>
                        <th>번역</th>
                        <td>{{ $sentence->sentence_ko }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.sentences', $sentence) }}" class="btn btn-secondary">뒤로</a>
                <a href="{{ route('admin.sentences.edit', $sentence) }}" class="btn btn-primary">수정</a>
            </div>
        </div>
    </div>
@endsection