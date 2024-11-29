<?php

namespace App\Http\Controllers;

use App\Models\Benchmark;
use App\Models\Gpu;
use Illuminate\Http\Request;

class JuegoBenchmarkController extends Controller
{
    public function index(Request $request)
    {
        $benchmarksQuery = Benchmark::with(['juego', 'configuracion', 'gpu'])
            ->orderByDesc('avg_fps');

        if ($request->has('gpu_id') && $request->gpu_id != null) {
            $benchmarksQuery->where('gpu_id', $request->gpu_id);
        }

        $benchmarks = $benchmarksQuery->get(); 

        $images = $this->getGameImages();
        $gpus = Gpu::all();

        $selectedBenchmark = null;
        $comparisonData = [];

        if ($request->has('benchmark_id')) {
            $selectedBenchmark = Benchmark::with('juego', 'gpu', 'processor', 'configuracion')
                ->findOrFail($request->benchmark_id);

            $bestConfig = $selectedBenchmark->configuracion;
            $resolucion = $bestConfig ? $bestConfig->resolucion : 'No disponible';
            $preset = $bestConfig ? $bestConfig->preset : 'No disponible';
            $rtx = $bestConfig ? $bestConfig->rtx : 'No disponible';

            $gameName = $selectedBenchmark->juego->nombre;

            $gpu_brand = $this->detectGpuBrand($selectedBenchmark->gpu->name);
            $cpu_brand = $this->detectCpuBrand($selectedBenchmark->processor->name);

            foreach ($benchmarks as $benchmark) {
                if ($benchmark->juego->id === $selectedBenchmark->juego->id) {
                    $config = $benchmark->configuracion;

                    $fps_improvement = $selectedBenchmark->avg_fps > 0
                        ? (($benchmark->avg_fps - $selectedBenchmark->avg_fps) / $selectedBenchmark->avg_fps) * 100
                        : 0;

                    $comparisonData[] = [
                        'benchmark' => $benchmark,
                        'config' => $config,
                        'fps_improvement' => $fps_improvement
                    ];
                }
            }

            usort($comparisonData, function($a, $b) {
                return $b['benchmark']->avg_fps <=> $a['benchmark']->avg_fps;
            });

            return view('benchmarks.index', compact('benchmarks', 'images', 'selectedBenchmark', 'gpu_brand', 'cpu_brand', 'resolucion', 'preset', 'rtx', 'bestConfig', 'comparisonData', 'gpus'));
        }

        return view('benchmarks.index', compact('benchmarks', 'images', 'gpus'));
    }

    public function show($id)
    {
        $benchmark = Benchmark::with(['juego', 'gpu', 'processor', 'configuracion'])->findOrFail($id);

        $gpu_brand = $this->detectGpuBrand($benchmark->gpu->name);
        $cpu_brand = $this->detectCpuBrand($benchmark->processor->name);

        $bestConfig = $benchmark->configuracion;

        return view('benchmarks.show', compact('benchmark', 'gpu_brand', 'cpu_brand', 'bestConfig'));
    }

    private function getGameImages()
    {
        return [
            1 => 'spiderman_miles_morales.png',
            2 => 'cyberpunk_2077.png',
            3 => 'red_dead_redemption_2.png',
        ];
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
