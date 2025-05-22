<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('search') && $request->search !== null) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $students = $query->orderBy('id', 'asc')->get();

        return view('students.index', compact('students'));
    }

    public function show(Student $student)
    {
        // Load courses with grades for this student
        $student->load('courses');

        return view('students.show', compact('student'));
    }



    public function create()
    {
        // Show the form to create a student
        return view('students.create');
    }

    public function store(Request $request)
    {
        // Validate and store the student
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'date_of_birth' => 'required|date',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        // Show the form to edit a student
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        // Validate and update the student
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'date_of_birth' => 'required|date',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        // Delete the student
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
