@extends('layouts.layout')

@section('title', $course->name . ' Details')

@section('content')
    <div class="container">
        <h2 class="mb-4">Course Details</h2>

        <div class="mb-5">
            <h4 class="mb-3">{{ $course->name }}</h4>
            <p><strong>Instructor:</strong> {{ $course->instructor_name }}</p>
            <p><strong>Description:</strong> {{ $course->description }}</p>
            <p><strong>Added:</strong> {{ $course->created_at->diffForHumans() }}</p>
        </div>

        <h3 class="mb-3">Enrolled Students & Grades</h3>

        @if ($course->students->isEmpty())
            <p>No students are enrolled in this course.</p>
        @else
            <form action="{{ route('courses.updateGradesBulk', $course->id) }}" method="POST" id="bulkGradesForm">
                @csrf
                <table class="table table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Partial Grade</th>
                            <th>Final Grade</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    <input type="number" name="grades[{{ $student->id }}][partial_grade]"
                                        value="{{ old('grades.' . $student->id . '.partial_grade', $student->pivot->partial_grade) }}"
                                        class="form-control @error('grades.' . $student->id . '.partial_grade') is-invalid @enderror"
                                        step="any">
                                    @error('grades.' . $student->id . '.partial_grade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="grades[{{ $student->id }}][final_grade]"
                                        value="{{ old('grades.' . $student->id . '.final_grade', $student->pivot->final_grade) }}"
                                        class="form-control @error('grades.' . $student->id . '.final_grade') is-invalid @enderror"
                                        step="any">
                                    @error('grades.' . $student->id . '.final_grade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-danger d-block mx-auto"
                                        onclick="unenrollStudent({{ $course->id }}, {{ $student->id }}, '{{ addslashes($student->name) }}')">
                                        <i class="bi bi-person-x"></i> Unenroll
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary mt-5 d-block mx-auto">Save All Grades</button>
            </form>

            <form id="unenrollForm" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        @endif

        <hr class="my-5">

        <h3 class="mb-3">Available Students to Enroll</h3>

        {{-- Search Form --}}
        <form method="GET" action="{{ route('courses.show', $course->id) }}" class="d-flex mb-4 gap-2">
            <input type="text" name="search" class="form-control w-50" placeholder="Search students by name"
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="bi bi-search"></i> Search
            </button>
        </form>

        @if ($availableStudents->isEmpty())
            <p>No available students to enroll.</p>
        @else
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($availableStudents as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <form action="{{ route('courses.enrollStudent', $course->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-person-plus"></i> Enroll
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('courses.index') }}" class="btn btn-secondary mt-4 mb-4">Back to Courses</a>
    </div>
@endsection

@section('script')
    <script src="{{ asset('JS/courseShow.js') }}"></script>
@endsection
