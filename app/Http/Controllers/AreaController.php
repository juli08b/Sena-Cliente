<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
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

        $areas = collect($this->fetchDataFromApi($url.'/areas'));

        return view('areas.index', compact('areas'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/areas/'.$id);
        $area = $response['data'] ?? null;

        return view('areas.show', compact('area'));
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        Http::post($url.'/areas', $request->all());

        return redirect()->route('areas.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url.'/areas/'.$id);
        $area = $response['data'] ?? null;

        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        Http::put($url.'/areas/'.$id, $request->all());

        return redirect()->route('areas.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete($url.'/areas/'.$id);

        return redirect()->route('areas.index');
    }
}
