<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TeacherController extends Controller
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

        $teachers = collect($this->fetchDataFromApi($url.'/teachers?included=area,trainingCenter'));

        return view('teachers.index', compact('teachers'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/teachers/'.$id);
        $teacher = $response['data'] ?? null;

        return view('teachers.show', compact('teacher'));
    }

    public function create()
    {
        $url = env('URL_SERVER_API');

        // Traes los datos de las tablas relacionadas que actúan como llaves foráneas
        $areas = $this->fetchDataFromApi($url.'/areas');
        $trainingCenters = $this->fetchDataFromApi($url.'/training-centers');

        return view('teachers.create', compact('areas', 'trainingCenters'));
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        Http::post($url.'/teachers', $request->all());

        return redirect()->route('teachers.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/teachers/'.$id);
        $teacher = $response['data'] ?? null;

        // Llaves foráneas disponibles para los selects
        $areas = $this->fetchDataFromApi($url.'/areas');
        $trainingCenters = $this->fetchDataFromApi($url.'/training-centers');

        return view('teachers.edit', compact('teacher', 'areas', 'trainingCenters'));
    }

    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        Http::put($url.'/teachers/'.$id, $request->all());

        return redirect()->route('teachers.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete($url.'/teachers/'.$id);

        return redirect()->route('teachers.index');
    }
}
