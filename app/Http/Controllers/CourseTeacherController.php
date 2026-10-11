<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseTeacherController extends Controller
{
    // Método privado para manejar llamadas HTTP repetitivas
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        return $response->json();
    }

    public function index()
    {
        $url = env('URL_SERVER_API');

        $courseTeachers = collect($this->fetchDataFromApi($url.'/course-teachers?included=course,teacher'));

        return view('course-teachers.index', compact('courseTeachers'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/course-teachers/'.$id);
        $courseTeacher = $response['data'] ?? null;

        return view('course-teachers.show', compact('courseTeacher'));
    }

    public function create()
    {
        $url = env('URL_SERVER_API');

        // Traes los datos de las tablas relacionadas que actúan como llaves foráneas
        $courses = $this->fetchDataFromApi($url.'/courses');
        $teachers = $this->fetchDataFromApi($url.'/teachers');

        return view('course-teachers.create', compact('courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        Http::post($url.'/course-teachers', $request->all());

        return redirect()->route('course-teachers.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/course-teachers/'.$id);
        $courseTeacher = $response['data'] ?? null;

        // Llaves foráneas disponibles para los selects
        $courses = $this->fetchDataFromApi($url.'/courses');
        $teachers = $this->fetchDataFromApi($url.'/teachers');

        return view('course-teachers.edit', compact('courseTeacher', 'courses', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        Http::put($url.'/course-teachers/'.$id, $request->all());

        return redirect()->route('course-teachers.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete($url.'/course-teachers/'.$id);

        return redirect()->route('course-teachers.index');
    }
}
