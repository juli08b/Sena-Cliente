<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApprenticeController extends Controller
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

        $apprentices = collect($this->fetchDataFromApi($url.'/apprentices?included=course,computer'));

        return view('apprentices.index', compact('apprentices'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/apprentices/'.$id);
        $apprentice = $response['data'] ?? null;

        return view('apprentices.show', compact('apprentice'));
    }

    public function create()
    {
        $url = env('URL_SERVER_API');

        // Traes los datos de las tablas relacionadas que actúan como llaves foráneas
        $courses = $this->fetchDataFromApi($url.'/courses');
        $computers = $this->fetchDataFromApi($url.'/computers');

        return view('apprentices.create', compact('courses', 'computers'));
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        Http::post($url.'/apprentices', $request->all());

        return redirect()->route('apprentices.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/apprentices/'.$id);
        $apprentice = $response['data'] ?? null;

        // Llaves foráneas disponibles para los selects
        $courses = $this->fetchDataFromApi($url.'/courses');
        $computers = $this->fetchDataFromApi($url.'/computers');

        return view('apprentices.edit', compact('apprentice', 'courses', 'computers'));
    }

    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        Http::put($url.'/apprentices/'.$id, $request->all());

        return redirect()->route('apprentices.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete($url.'/apprentices/'.$id);

        return redirect()->route('apprentices.index');
    }
}
