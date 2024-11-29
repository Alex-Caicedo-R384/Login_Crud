<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juego;


class JuegoController extends Controller
{
    protected $categorias = [
        'Competitivo',
        'Triple A',
        'Peleas'
    ];

    public function index()
    {
        $juegos = Juego::all();
        return view('juegos.index', compact('juegos'));
    }

    public function create()
    {
        $categorias = $this->categorias;
        return view('juegos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string',
        ]);

        Juego::create($request->all());
        return redirect()->route('juegos.index');
    }

    public function edit($id)
    {
        $juego = Juego::findOrFail($id);
        $categorias = $this->categorias;
        return view('juegos.edit', compact('juego', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string',
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
