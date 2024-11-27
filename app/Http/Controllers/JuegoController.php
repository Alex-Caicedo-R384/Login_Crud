<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juego;


class JuegoController extends Controller
{
    public function index()
    {
        $juegos = Juego::all();
        return view('juegos.index', compact('juegos'));
    }

    public function create()
    {
        return view('juegos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Juego::create($request->all());
        return redirect()->route('juegos.index');
    }

    public function show($id)
    {
        $juego = Juego::findOrFail($id);
        return view('juegos.show', compact('juego'));
    }

    public function edit($id)
    {
        $juego = Juego::findOrFail($id);
        return view('juegos.edit', compact('juego'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $juego = Juego::findOrFail($id);
        $juego->update($request->all());
        return redirect()->route('juegos.index');
    }

    public function destroy($id)
    {
        $juego = Juego::findOrFail($id);
        $juego->delete();
        return redirect()->route('juegos.index');
    }
}
