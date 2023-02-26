@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-3 text-end">
            <a href="{{ route('admin.sentences.create') }}" class="btn btn-primary">등록</a>
        </div>
        <table class="table table-bordered my-3">
            <thead>
            <tr>
                <th>#</th>
                <th>문장</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sentences as $sentence)
            <tr>
                <td>{{ $sentence->id }}</td>
                <td>
                    <a href="{{ route('admin.sentences.show', $sentence) }}">{{ $sentence->sentence }}</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $sentences->links() }}
    </div>
@endsection