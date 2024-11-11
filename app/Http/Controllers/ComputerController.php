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
        $procesadores = Processor::all();
        $gpus = Gpu::all();

        return view('computers.create', compact('procesadores', 'gpus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'procesador' => 'required',
            'gpu' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $computer = Computer::create($validated);

        return redirect()->route('computers.index')->with('success', 'Computadora creada exitosamente');
    }

    public function edit(Computer $computer)
    {
        $procesadores = Processor::all();
        $gpus = Gpu::all();

        if ($computer->user_id !== auth()->user()->id) {
            return redirect()->route('computers.index');
        }

        return view('computers.edit', compact('computer', 'procesadores', 'gpus'));
    }

    public function update(Request $request, Computer $computer)
    {
        if ($computer->user_id !== auth()->user()->id) {
            return redirect()->route('computers.index');
        }

        $validated = $request->validate([
            'procesador' => 'required',
            'gpu' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $computer->update($validated);

        return redirect()->route('computers.index')->with('success', 'Computadora actualizada exitosamente');
    }

    public function destroy(Computer $computer)
    {
        if ($computer->user_id !== auth()->user()->id) {
            return redirect()->route('computers.index');
        }

        $computer->delete();

        return redirect()->route('computers.index')->with('success', 'Computadora eliminada exitosamente');
    }
}