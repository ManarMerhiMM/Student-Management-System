@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="row justify-content-center">

        @if (Auth::user()->is_admin)
            <div class="col-md-3">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <i class="bi bi-people-fill display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Manage Students</h5>
                        <p class="card-text">View and manage student details.</p>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-primary">Go to Students</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <i class="bi bi-journal-bookmark-fill display-4 text-success mb-3"></i>
                        <h5 class="card-title">Manage Courses</h5>
                        <p class="card-text">View and manage course details.</p>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-success">Go to Courses</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <i class="bi bi-person-circle display-4 text-warning mb-3"></i>
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">View and manage student details.</p>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-warning">Go to Users</a>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-5">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <i class="bi bi-people-fill display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Manage Students</h5>
                        <p class="card-text">View and manage student details.</p>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-primary">Go to Students</a>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card text-center shadow-sm mb-4">
                    <div class="card-body">
                        <i class="bi bi-journal-bookmark-fill display-4 text-success mb-3"></i>
                        <h5 class="card-title">Manage Courses</h5>
                        <p class="card-text">View and manage course details.</p>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-success">Go to Courses</a>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
