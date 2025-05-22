@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-5">Welcome to our Student Management System</h1>
        <p class="lead mt-3">Manage students, courses, and grades all in one place.</p>
        @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg mt-4">Go to Dashboard</a>
        @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-4">Login to get started</a>
        @endauth
    </div>
@endsection
