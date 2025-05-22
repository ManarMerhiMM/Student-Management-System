@extends('layouts.layout')

@section('title', 'Edit Course')

@section('content')
    <div class="container">
        <h2>Edit Course</h2>

        <form action="{{ route('courses.update', $course) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Course Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $course->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $course->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="instructor_name" class="form-label">Instructor Name</label>
                <input type="text" name="instructor_name" id="instructor_name" class="form-control"
                    value="{{ old('instructor_name', $course->instructor_name) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Course</button>
            <a href="{{ route('courses.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
@endsection
