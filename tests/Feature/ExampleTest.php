<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * La raíz redirige al panel y los tres módulos responden OK.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')->assertRedirect(route('areas.index'));

        $this->get(route('areas.index'))->assertOk();
        $this->get(route('computers.index'))->assertOk();
        $this->get(route('training-centers.index'))->assertOk();
        $this->get(route('teachers.index'))->assertOk();
        $this->get(route('courses.index'))->assertOk();
        $this->get(route('apprentices.index'))->assertOk();
        $this->get(route('course-teachers.index'))->assertOk();
    }

    /**
     * El detalle responde aunque el ID no exista en la API.
     */
    public function test_show_pages_respond_for_missing_records(): void
    {
        $this->get(route('areas.show', ['id' => 999999]))->assertOk();
        $this->get(route('computers.show', ['id' => 999999]))->assertOk();
        $this->get(route('training-centers.show', ['id' => 999999]))->assertOk();
        $this->get(route('teachers.show', ['id' => 999999]))->assertOk();
        $this->get(route('courses.show', ['id' => 999999]))->assertOk();
        $this->get(route('apprentices.show', ['id' => 999999]))->assertOk();
        $this->get(route('course-teachers.show', ['id' => 999999]))->assertOk();
    }
}
