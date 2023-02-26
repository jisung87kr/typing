@extends('layouts.app')

@section('custom_styles')

@endsection

@section('content')
    @vite(['resources/js/typing.js'])
    <div class="container">
        <x-typing></x-typing>
    </div>
@endsection