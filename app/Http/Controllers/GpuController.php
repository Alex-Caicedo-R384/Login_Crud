<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gpu;
use Illuminate\Http\Request;

class GpuController extends Controller
{
    public function index()
    {
        $gpus = Gpu::all();
        return view('gpus.index', compact('gpus'));
    }

    public function create()
    {
        return view('gpus.create');
    }

    
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'base' => 'required|string|in:RTX,RX,ARC',
            'suffix' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $forbiddenWords = ['RTX', 'RX', 'ARC'];
                    foreach ($forbiddenWords as $word) {
                        if (stripos($value, $word) !== false) {
                            $fail("No debes ingresar: RTX, RX o ARC.");
                        }
                    }
                },
            ],
        ]);

        // Concatenar tipo y modelo
        $fullName = "{$request->base} {$request->suffix}";

        // Crear el registro en la base de datos
        Gpu::create(['name' => $fullName]);

        // Redirigir al índice con mensaje de éxito
        return redirect()->route('gpus.index')->with('status', 'GPU agregada correctamente');
    }

    

    public function edit($id)
    {
        $gpu = Gpu::findOrFail($id);
        return view('gpus.edit', compact('gpu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $gpu = Gpu::findOrFail($id);
        $gpu->update([
            'name' => $request->name,
        ]);

        return redirect()->route('gpus.index')->with('status', 'GPU actualizada correctamente');
    }

    public function destroy($id)
    {
        $gpu = Gpu::findOrFail($id);
        $gpu->delete();

        return redirect()->route('gpus.index')->with('status', 'GPU eliminada correctamente');
    }
}
