<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComputerController extends Controller
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

        $computers = collect($this->fetchDataFromApi($url.'/computers'));

        return view('computers.index', compact('computers'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url.'/computers/'.$id);
        $computer = $response['data'] ?? null;

        return view('computers.show', compact('computer'));
    }

    public function create()
    {
        return view('computers.create');
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        Http::post($url.'/computers', $request->all());

        return redirect()->route('computers.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url.'/computers/'.$id);
        $computer = $response['data'] ?? null;

        return view('computers.edit', compact('computer'));
    }

    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        Http::put($url.'/computers/'.$id, $request->all());

        return redirect()->route('computers.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete($url.'/computers/'.$id);

        return redirect()->route('computers.index');
    }
}
