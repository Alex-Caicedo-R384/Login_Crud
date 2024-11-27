<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;


class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuraciones = Configuracion::all();
        return view('configuracion.index', compact('configuraciones'));
    }

    public function create()
    {
        return view('configuracion.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'resolucion' => 'required|string|max:255',
            'preset' => 'required|string|max:255',
            'rtx' => 'required|string|max:255',
        ]);

        Configuracion::create($request->all());
        return redirect()->route('configuracion.index');
    }

    public function edit($id)
    {
        $configuracion = Configuracion::findOrFail($id);
        return view('configuracion.edit', compact('configuracion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'resolucion' => 'required|string|max:255',
            'preset' => 'required|string|max:255',
            'rtx' => 'required|string|max:255',
        ]);

        $configuracion = Configuracion::findOrFail($id);
        $configuracion->update($request->all());
        return redirect()->route('configuracion.index');
    }

    public function destroy($id)
    {
        $configuracion = Configuracion::findOrFail($id);
        $configuracion->delete();
        return redirect()->route('configuracion.index');
    }
}
