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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        Processor::create([
            'name' => $request->name,
        ]);

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
