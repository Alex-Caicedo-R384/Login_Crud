<?php

namespace App\Http\Controllers;

use App\Models\Benchmark;
use Illuminate\Http\Request;

class JuegoBenchmarkController extends Controller
{
    public function index(Request $request)
    {
        $benchmarks = Benchmark::with(['juego', 'configuracion'])
            ->orderByDesc('avg_fps')
            ->get();
        
        $images = $this->getGameImages();
        $selectedBenchmark = null;
        
        if ($request->has('benchmark_id')) {
            $selectedBenchmark = Benchmark::with('juego', 'gpu', 'processor', 'configuracion')->findOrFail($request->benchmark_id);

            $bestConfig = $selectedBenchmark->configuracion;
            $resolucion = $bestConfig ? $bestConfig->resolucion : 'No disponible';
            $preset = $bestConfig ? $bestConfig->preset : 'No disponible';
            $rtx = $bestConfig ? $bestConfig->rtx : 'No disponible';

            $gameName = $selectedBenchmark->juego->nombre;
    
            $gpu_brand = $this->detectGpuBrand($selectedBenchmark->gpu->name);
            $cpu_brand = $this->detectCpuBrand($selectedBenchmark->processor->name);
    
            return view('benchmarks.index', compact('benchmarks', 'images', 'selectedBenchmark', 'gpu_brand', 'cpu_brand', 'resolucion', 'preset', 'rtx', 'bestConfig'));
        }
    
        return view('benchmarks.index', compact('benchmarks', 'images'));
    }
     

    private function getGameImages()
    {
        return [
            1 => 'spiderman_miles_morales.png',
            2 => 'cyberpunk_2077.png',
            3 => 'red_dead_redemption_2.png',
        ];
    }

    public function show($id)
    {
        $benchmark = Benchmark::with(['juego', 'gpu', 'processor', 'configuracion'])->findOrFail($id);

        $gpu_brand = $this->detectGpuBrand($benchmark->gpu->name);
        $cpu_brand = $this->detectCpuBrand($benchmark->processor->name);

        $bestConfig = $benchmark->configuracion;

        return view('benchmarks.show', compact('benchmark', 'gpu_brand', 'cpu_brand', 'bestConfig'));
    }

    private function detectGpuBrand($gpuName)
    {
        if (strpos($gpuName, 'RTX') !== false) {
            return 'Nvidia';
        } elseif (strpos($gpuName, 'RX') !== false) {
            return 'AMD';
        }
        return 'Otra';
    }

    private function detectCpuBrand($cpuName)
    {
        if (preg_match('/I[3-9]/', $cpuName)) {
            return 'Intel';
        } elseif (preg_match('/R[3-9]/', $cpuName)) {
            return 'AMD';
        }
        return 'Otra';
    }
}
