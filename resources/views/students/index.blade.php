@extends('layouts.layout')

@section('title', 'Manage Students')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Students</h2>
            <a href="{{ route('students.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Student
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success" id="alertSuccess">{{ session('success') }}</div>
        @endif

        @if ($students->isEmpty())
            <p>No students found.</p>
        @else
            <form method="GET" action="{{ route('students.index') }}" class="mb-4 d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by name"
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i> Search
                </button>
            </form>

            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of Birth</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->date_of_birth->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye"></i> View
                                </a>

                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this student?');">
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
    <script src="{{ asset('JS/studentIndex.js') }}"></script>
@endsection
