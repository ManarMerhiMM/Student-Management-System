@extends('layouts.layout')

@section('title', 'Edit Student')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Student</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('students.update', $student) }}" method="POST" class="card p-4 shadow-sm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control"
                    value="{{ old('date_of_birth', \Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d')) }}"
                    required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update Student
                </button>
            </div>
        </form>
    </div>
@endsection
