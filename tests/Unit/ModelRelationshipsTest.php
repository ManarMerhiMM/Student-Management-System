<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Course;
use App\Models\Grade;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_course_pivot_relationship()
    {
        $student = Student::factory()->create();
        $course  = Course::factory()->create();

        $student->courses()->attach($course->id, [
            'partial_grade' => 50,
            'final_grade'   => 75,
        ]);

        $this->assertTrue($student->courses->contains($course));

        $pivot = $student->courses->first()->pivot;
        $this->assertEquals(50, $pivot->partial_grade);
        $this->assertEquals(75, $pivot->final_grade);
    }

    public function test_grade_model_belongs_to_student_and_course()
    {
        $student = Student::factory()->create();
        $course  = Course::factory()->create();

        $grade = Grade::factory()->create([
            'student_id'    => $student->id,
            'course_id'     => $course->id,
            'partial_grade' => 60,
            'final_grade'   => 80,
        ]);

        $this->assertEquals($student->id, $grade->student->id);
        $this->assertEquals($course->id, $grade->course->id);
    }
}
