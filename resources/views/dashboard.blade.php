@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="bi bi-people-fill display-4 text-primary mb-3"></i>
                    <h5 class="card-title">Manage Students</h5>
                    <p class="card-text">Add, update, or remove student information.</p>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-primary">Go to Students</a>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="bi bi-journal-bookmark-fill display-4 text-success mb-3"></i>
                    <h5 class="card-title">Manage Courses</h5>
                    <p class="card-text">View and manage course details.</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-success">Go to Courses</a>
                </div>
            </div>
        </div>
    </div>
@endsection
