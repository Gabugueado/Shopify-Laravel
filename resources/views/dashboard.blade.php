@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-white">Welcome, {{ auth()->user()->name ?? 'Invitado' }}</h1>
@endsection