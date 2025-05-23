<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_index_requires_authentication()
    {
        $this->get(route('students.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_student_index()
    {
        $user = User::factory()->create();
        Student::factory(3)->create();

        $this->actingAs($user)
            ->get(route('students.index'))
            ->assertStatus(200)
            ->assertSee(Student::first()->name);
    }

    public function test_create_form_is_accessible()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('students.create'))
            ->assertStatus(200)
            ->assertViewIs('students.create');
    }

    public function test_authenticated_user_can_perform_crud_on_student()
    {
        $this->actingAs(User::factory()->create());

        // Create
        $data = [
            'name'          => 'Alice',
            'email'         => 'alice@example.com',
            'date_of_birth' => '2000-01-01',
        ];
        $this->post(route('students.store'), $data)
            ->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', ['email' => 'alice@example.com']);

        $student = Student::first();

        // Show
        $this->get(route('students.show', $student->id))
            ->assertStatus(200)
            ->assertViewIs('students.show')
            ->assertSee('Alice');

        // Edit form
        $this->get(route('students.edit', $student->id))
            ->assertStatus(200)
            ->assertViewIs('students.edit')
            ->assertSee($student->name);

        // Update
        $this->put(route('students.update', $student->id), [
            'name' => 'Alice B',
            'email' => $student->email,               // keep existing email to pass validation
            'date_of_birth' => $student->date_of_birth, // keep existing DOB to pass validation
        ])->assertRedirect(route('students.index'));

        $this->assertEquals('Alice B', $student->fresh()->name);

        // Delete
        $this->delete(route('students.destroy', $student->id))
            ->assertRedirect(route('students.index'));
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_authenticated_user_can_export_student_pdf()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();

        $this->actingAs($user)
            ->get(route('students.exportPdf', $student->id))
            ->assertStatus(200)
            ->assertHeader('content-type', 'application/pdf');
    }
}
