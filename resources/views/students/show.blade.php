@extends('layouts.layout')

@section('title', $student->name . ' Details')


@section('content')
    <div class="container">
        <h2 class="mb-4">Student Details</h2>

        <div class="mb-5 p-4 bg-white rounded shadow-sm">
            <h4 class="mb-3">{{ $student->name }}</h4>
            <p class="mb-2"><strong>Email:</strong> {{ $student->email }}</p>
            <p class="mb-2"><strong>Date of Birth:</strong> {{ $student->date_of_birth->format('d-m-Y') }}</p>
            <p class="mb-0"><strong>Student since:</strong> {{ $student->created_at->diffForHumans() }}</p>
        </div>

        <h3 class="mb-3">Courses & Grades</h3>

        @if ($student->courses->isEmpty())
            <p>This student is not enrolled in any courses.</p>
        @else
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Course Name</th>
                        <th>Partial Grade</th>
                        <th>Final Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->pivot->partial_grade ?? 'N/A' }}</td>
                            <td>{{ $course->pivot->final_grade ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('students.index') }}" class="btn btn-secondary mt-4">Back to Students</a>
    </div>
@endsection
