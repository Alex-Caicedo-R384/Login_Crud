<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\Processor;
use App\Models\Gpu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    public function index()
    {
        $computers = Computer::with(['processor', 'gpu'])
                             ->where('user_id', auth()->user()->id)
                             ->get();    
    
        return view('computers.index', compact('computers'));
    }
    
    
    public function create()
    {
        $processors = Processor::all();
        $gpus = Gpu::all();
        return view('computers.create', compact('processors', 'gpus'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'processor_name' => 'required|exists:processors,name',
            'gpu_name' => 'required|exists:gpus,name',
        ]);
    
        $processor = Processor::where('name', $request->input('processor_name'))->first();
        $gpu = Gpu::where('name', $request->input('gpu_name'))->first();
    
        if (!$processor || !$gpu) {
            return back()->withErrors(['error' => 'Procesador o GPU no encontrados']);
        }
    
        Computer::create([
            'processor_id' => $processor->id,
            'processor_name' => $processor->name,
            'gpu_id' => $gpu->id,
            'gpu_name' => $gpu->name,
            'user_id' => auth()->user()->id,
        ]);
    
        return redirect()->route('computers.index')->with('success', 'Computadora creada con éxito.');
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