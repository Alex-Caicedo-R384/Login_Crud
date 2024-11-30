<?php

namespace App\Http\Controllers;

use App\Models\AjusteRecomendado;
use App\Models\Juego;
use Illuminate\Http\Request;

class AjusteRecomendadoController extends Controller
{
    public function index()
    {
        $ajustes = AjusteRecomendado::all();
        return view('ajustes.index', compact('ajustes'));
    }

    public function create()
    {
        $categorias = Juego::select('categoria')->distinct()->get();
        return view('ajustes.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (AjusteRecomendado::where('categoria', $value)->exists()) {
                        $fail("Ya existe un ajuste recomendado para la categoría {$value}.");
                    }
                },
            ],
            'min_fps' => 'nullable|integer',
            'max_fps' => 'nullable|integer',
            'recommended_resolution' => 'required|string|max:255',
        ]);

        AjusteRecomendado::create([
            'categoria' => $request->categoria,
            'min_fps' => $request->min_fps,
            'max_fps' => $request->max_fps,
            'recommended_resolution' => $request->recommended_resolution,
            'user_id' => auth()->id(), // Asigna el usuario autenticado
        ]);

        return redirect()->route('ajustes.index')->with('success', 'Ajuste creado correctamente.');
    }

    public function edit(AjusteRecomendado $ajuste)
    {
        $categorias = Juego::select('categoria')->distinct()->get();
        return view('ajustes.edit', compact('ajuste', 'categorias'));
    }

    public function update(Request $request, AjusteRecomendado $ajuste)
    {
        $request->validate([
            'categoria' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($ajuste) {
                    if (AjusteRecomendado::where('categoria', $value)
                        ->where('id', '!=', $ajuste->id)
                        ->exists()) {
                        $fail("Ya existe otro ajuste recomendado para la categoría {$value}.");
                    }
                },
            ],
            'min_fps' => 'nullable|integer',
            'max_fps' => 'nullable|integer',
            'recommended_resolution' => 'required|string|max:255',
        ]);

        $ajuste->update($request->all());

        return redirect()->route('ajustes.index')->with('success', 'Ajuste actualizado correctamente.');
    }

    public function destroy(AjusteRecomendado $ajuste)
    {
        $ajuste->delete();

        return redirect()->route('ajustes.index')->with('success', 'Ajuste eliminado correctamente.');
    }
}
