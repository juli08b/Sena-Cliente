<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseController extends Controller
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

        $courses = collect($this->fetchDataFromApi($url.'/courses?included=area,trainingCenter'));

        return view('courses.index', compact('courses'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/courses/'.$id);
        $course = $response['data'] ?? null;

        return view('courses.show', compact('course'));
    }

    public function create()
    {
        $url = env('URL_SERVER_API');

        // Traes los datos de las tablas relacionadas que actúan como llaves foráneas
        $areas = $this->fetchDataFromApi($url.'/areas');
        $trainingCenters = $this->fetchDataFromApi($url.'/training-centers');

        return view('courses.create', compact('areas', 'trainingCenters'));
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        Http::post($url.'/courses', $request->all());

        return redirect()->route('courses.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/courses/'.$id);
        $course = $response['data'] ?? null;

        // Llaves foráneas disponibles para los selects
        $areas = $this->fetchDataFromApi($url.'/areas');
        $trainingCenters = $this->fetchDataFromApi($url.'/training-centers');

        return view('courses.edit', compact('course', 'areas', 'trainingCenters'));
    }

    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        Http::put($url.'/courses/'.$id, $request->all());

        return redirect()->route('courses.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete($url.'/courses/'.$id);

        return redirect()->route('courses.index');
    }
}
