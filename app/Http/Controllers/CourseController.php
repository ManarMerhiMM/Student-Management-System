<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Display a listing of courses
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            // Filter courses by name containing the search term (case-insensitive)
            $query->where('name', 'like', '%' . $search . '%');
        }

        $courses = $query->orderBy('name', 'asc')->get();

        return view('courses.index', compact('courses'));
    }


    public function show(Request $request, Course $course)
    {
        $course->load('students');

        $enrolledIds = $course->students->pluck('id');

        $query = Student::whereNotIn('id', $enrolledIds);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $availableStudents = $query->orderBy('name', 'asc')->get();

        return view('courses.show', compact('course', 'availableStudents'));
    }


    // Show the form for creating a new course
    public function create()
    {
        return view('courses.create');
    }

    // Store a newly created course in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'description' => 'string',
            'instructor_name' => 'string',
        ]);

        Course::create($request->only('name', 'description', 'instructor_name'));

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    // Show the form for editing the specified course
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // Update the specified course in storage
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
            'description' => 'string',
            'instructor_name' => 'string',
        ]);

        $course->update($request->only('name', 'description', 'instructor_name'));

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    // Remove the specified course from storage
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function updateGrades(Request $request, Course $course)
    {
        $validated = $request->validate([
            'grades.*.partial_grade' => 'nullable|numeric|between:0,100',
            'grades.*.final_grade' => 'nullable|numeric|between:0,100',
        ], [
            'grades.*.partial_grade.between' => 'The partial grade must be between 0 and 100.',
            'grades.*.final_grade.between' => 'The final grade must be between 0 and 100.',
        ]);


        foreach ($validated['grades'] as $studentId => $grades) {
            $course->students()->updateExistingPivot($studentId, [
                'partial_grade' => $grades['partial_grade'] ?? null,
                'final_grade' => $grades['final_grade'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Grades updated successfully for all students.');
    }


    public function enrollStudent(Request $request, Course $course)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $course->students()->syncWithoutDetaching($request->student_id);

        return redirect()->back()->with('success', 'Student enrolled successfully.');
    }

    public function unenrollStudent(Course $course, Student $student)
    {
        // Detach the student from the course (remove enrollment)
        $course->students()->detach($student->id);

        return redirect()->route('courses.show', $course->id)->with('success', "Student {$student->name} has been unenrolled.");
    }
}
