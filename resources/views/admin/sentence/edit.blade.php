@extends('layouts.app')
@section('content')
    <div class="container my-3">
        <form action="{{ route('admin.sentences.update', $sentence) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.sentence.form')
        </form>
    </div>
@endsection