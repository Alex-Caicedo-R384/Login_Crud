<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    public function index()
    {
        $computers = Computer::all();
        return view('computers.index', compact('computers'));
    }

    public function create()
    {
        return view('computers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'procesador' => 'required|string|max:255',
            'modulos_ram' => 'required|integer',
            'capacidad_ram' => 'required|integer',
            'gpu' => 'required|string|max:255',
        ]);

        Computer::create($request->all());
        return redirect()->route('computers.index')->with('success', 'Computadora creada exitosamente.');
    }

    public function edit(Computer $computer)
    {
        return view('computers.edit', compact('computer'));
    }

    public function update(Request $request, Computer $computer)
    {
        $request->validate([
            'procesador' => 'required|string|max:255',
            'modulos_ram' => 'required|integer',
            'capacidad_ram' => 'required|integer',
            'gpu' => 'required|string|max:255',
        ]);

        $computer->update($request->all());
        return redirect()->route('computers.index')->with('success', 'Computadora actualizada exitosamente.');
    }

    public function destroy(Computer $computer)
    {
        $computer->delete();
        return redirect()->route('computers.index')->with('success', 'Computadora eliminada exitosamente.');
    }
}
