@extends('layouts.layout')

@section('title', 'Add New Course')

@section('content')
    <div class="container">
        <h2 class="mb-4">Add New Course</h2>

        <form action="{{ route('courses.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Course Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="instructor_name" class="form-label">Instructor Name</label>
                <input type="text" name="instructor_name" id="instructor_name"
                    class="form-control @error('instructor_name') is-invalid @enderror"
                    value="{{ old('instructor_name') }}">
                @error('instructor_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Course Description</label>
                <textarea name="description" id="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror" >{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Course
            </button>

            <a href="{{ route('courses.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
@endsection
