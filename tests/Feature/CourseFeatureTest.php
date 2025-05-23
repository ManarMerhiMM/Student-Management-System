<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_courses_shows_list()
    {
        $user = User::factory()->create();
        Course::factory(2)->create();

        $this->actingAs($user)
            ->get(route('courses.index'))
            ->assertStatus(200)
            ->assertSee(Course::first()->name);
    }

    public function test_create_form_is_accessible()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->get(route('courses.create'))
            ->assertStatus(200)
            ->assertViewIs('courses.create');
    }

    public function test_authenticated_user_can_create_course()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('courses.store'), [
            'name'            => 'Algebra',
            'description'     => 'Intro course',
            'instructor_name' => 'Prof. John',
        ])->assertRedirect(route('courses.index'));

        $this->assertDatabaseHas('courses', ['name' => 'Algebra']);
    }

    public function test_edit_form_is_accessible()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->actingAs($user)
            ->get(route('courses.edit', $course->id))
            ->assertStatus(200)
            ->assertViewIs('courses.edit')
            ->assertSee($course->name);
    }

    public function test_authenticated_user_can_update_course()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create([
            'name'            => 'Old',
            'description'     => 'Old',
            'instructor_name' => 'Old',
        ]);

        $this->actingAs($user)
            ->put(route('courses.update', $course->id), [
                'name'            => 'New',
                'description'     => 'New',
                'instructor_name' => 'New',
            ])->assertRedirect(route('courses.index'));

        $this->assertDatabaseHas('courses', ['id' => $course->id, 'name' => 'New']);
    }

    public function test_authenticated_user_can_view_course()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->actingAs($user)
            ->get(route('courses.show', $course->id))
            ->assertStatus(200)
            ->assertViewIs('courses.show')
            ->assertSee($course->name);
    }

    public function test_authenticated_user_can_enroll_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        $course = Course::factory()->create();

        $this->actingAs($user)
            ->post(route('courses.enrollStudent', $course->id), [
                'student_id' => $student->id,
            ])->assertRedirect();

        $this->assertTrue($course->students()->where('student_id', $student->id)->exists());
    }

    public function test_authenticated_user_can_unenroll_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        $course = Course::factory()->create();
        $course->students()->attach($student->id);

        $this->actingAs($user)
            ->delete(route('courses.unenrollStudent', ['course' => $course->id, 'student' => $student->id]))
            ->assertRedirect();

        $this->assertFalse($course->students()->where('student_id', $student->id)->exists());
    }

    public function test_grades_can_be_updated_for_enrolled_students()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $student = Student::factory()->create();
        $course->students()->attach($student->id);

        $this->actingAs($user)
            ->post(route('courses.updateGradesBulk', $course->id), [
                'grades' => [
                    $student->id => [
                        'partial_grade' => 88,
                        'final_grade'   => 95,
                    ],
                ],
            ])->assertRedirect();

        $this->assertDatabaseHas('grades', [
            'student_id'    => $student->id,
            'course_id'     => $course->id,
            'partial_grade' => 88,
            'final_grade'   => 95,
        ]);
    }

    public function test_course_can_be_deleted()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->actingAs($user)
            ->delete(route('courses.destroy', $course->id))
            ->assertRedirect(route('courses.index'));

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
