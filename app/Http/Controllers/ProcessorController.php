<?php

namespace App\Http\Controllers;

use App\Models\Processor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProcessorController extends Controller
{
    public function index()
    {
        $processors = Processor::all();
        return view('processors.index', compact('processors'));
    }

    public function create()
    {
        return view('processors.create');
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'base' => 'required|string|in:R3,R5,R7,R9,I3,I5,I7,I9',
            'suffix' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $forbiddenWords = ['R3', 'R5', 'R7', 'R9', 'I3', 'I5', 'I7', 'I9'];
                    foreach ($forbiddenWords as $word) {
                        if (stripos($value, $word) !== false) {
                            $fail("El uso de la categoría ya está en la lista de abajo, no la ingreses con lo demas");
                        }
                    }
                },
            ],
        ]);
    
        $fullName = "{$request->base} {$request->suffix}";
    
        Processor::create(['name' => $fullName]);
    
        return redirect()->route('processors.index')->with('status', 'Procesador agregado correctamente');
    }
    

    public function edit($id)
    {
        $processor = Processor::findOrFail($id);
        return view('processors.edit', compact('processor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $processor = Processor::findOrFail($id);
        $processor->update([
            'name' => $request->name,
        ]);

        return redirect()->route('processors.index')->with('status', 'Procesador actualizado correctamente');
    }

    public function destroy($id)
    {
        $processor = Processor::findOrFail($id);
        $processor->delete();

        return redirect()->route('processors.index')->with('status', 'Procesador eliminado correctamente');
    }
}
