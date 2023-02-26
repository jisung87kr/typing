@extends('layouts.app')
@section('content')
    <div class="container my-3">
        <form action="{{ route('admin.sentences.store') }}" method="POST">
            @csrf
            @include('admin.sentence.form')
        </form>
    </div>
@endsection