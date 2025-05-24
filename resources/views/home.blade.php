@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-5">Welcome to our Student Management System</h1>
        <p class="lead mt-3">Manage students, courses, and grades all in one place.</p>
        <a class="btn btn-primary btn-lg mt-4" href="{{ asset('documents/User Manual.docx') }}" download><i class="bi bi-download me-1"></i> User Manual</a>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg mt-4">Go to Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-4">Login to get started</a>
        @endauth
    </div>
@endsection
