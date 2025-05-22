@extends('layouts.layout')

@section('title', 'Manage Courses')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Courses</h2>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Course
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success" id="alertSuccess">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('courses.index') }}" class="mb-4 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by course name"
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="bi bi-search"></i> Search
            </button>
        </form>
        
        @if ($courses->isEmpty())
            <p>No courses found.</p>
        @else
            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Course Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->description }}</td>
                            <td>
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye"></i> View
                                </a>

                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('script')
    <script src="{{ asset('JS/courseIndex.js') }}"></script>
@endsection
