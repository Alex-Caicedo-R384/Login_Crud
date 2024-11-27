<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Benchmark;
use App\Models\Configuracion;
use App\Models\Gpu;
use App\Models\Processor;
use App\Models\Juego;


class BenchmarkController extends Controller
{
    public function index()
    {
        $benchmarks = Benchmark::with(['configuracion', 'gpu', 'processor', 'juego'])->get();
        return view('benchmark.index', compact('benchmarks'));
    }

    public function create()
    {
        $configuraciones = Configuracion::all();
        $gpus = Gpu::all();
        $processors = Processor::all();
        $juegos = Juego::all();

        return view('benchmark.create', compact('configuraciones', 'gpus', 'processors', 'juegos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'juego_id' => 'required|exists:juegos,id',
            'configuracion_id' => 'required|exists:configuracion,id',
            'gpu_id' => 'required|exists:gpus,id',
            'cpu_id' => 'required|exists:processors,id',
            'avg_fps' => 'required|numeric',
            'min_fps' => 'required|numeric',
            'cpu_usage' => 'required|numeric',
            'gpu_usage' => 'required|numeric',
        ]);

        Benchmark::create($request->all());

        return redirect()->route('benchmark.index');
    }

    public function edit($id)
    {
        $benchmark = Benchmark::findOrFail($id);

        $configuraciones = Configuracion::all();
        $gpus = Gpu::all();
        $processors = processor::all();
        $juegos = Juego::all();

        return view('benchmark.edit', compact('benchmark', 'configuraciones', 'gpus', 'processors', 'juegos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'juego_id' => 'required|exists:juegos,id',
            'configuracion_id' => 'required|exists:configuracion,id',
            'gpu_id' => 'required|exists:gpus,id',
            'cpu_id' => 'required|exists:processors,id',
            'avg_fps' => 'required|numeric',
            'min_fps' => 'required|numeric',
            'cpu_usage' => 'required|numeric',
            'gpu_usage' => 'required|numeric',
        ]);

        $benchmark = Benchmark::findOrFail($id);
        $benchmark->update($request->all());

        return redirect()->route('benchmark.index');
    }

    public function destroy($id)
    {
        $benchmark = Benchmark::findOrFail($id);
        $benchmark->delete();

        return redirect()->route('benchmark.index');
    }
}
