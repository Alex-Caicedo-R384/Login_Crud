<?php

namespace App\Http\Controllers;

use App\Models\Benchmark;
use App\Models\Gpu;
use App\Models\AjusteRecomendado;
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

        // Agrupamos los benchmarks por categoría
        $groupedByCategory = $benchmarks->groupBy(function ($benchmark) {
            return $benchmark->juego->categoria;
        });

        $images = $this->getGameImages();
        $gpus = Gpu::all();

        $selectedBenchmark = null;
        $comparisonData = [];
        $bestConfigsByCategory = $this->calculateBestConfigsByCategory($groupedByCategory);

        if ($request->has('benchmark_id')) {
            $selectedBenchmark = Benchmark::with('juego', 'gpu', 'processor', 'configuracion')
                ->findOrFail($request->benchmark_id);

            $gameCategory = $selectedBenchmark->juego->categoria;

            $bestGpuAndConfig = $bestConfigsByCategory[$gameCategory] ?? null;

            $bestConfig = $selectedBenchmark->configuracion;
            $resolucion = $bestConfig ? $bestConfig->resolucion : 'No disponible';
            $preset = $bestConfig ? $bestConfig->preset : 'No disponible';
            $rtx = $bestConfig ? $bestConfig->rtx : 'No disponible';

            $gpu_brand = $this->detectGpuBrand($selectedBenchmark->gpu->name);
            $cpu_brand = $this->detectCpuBrand($selectedBenchmark->processor->name);

            $comparisonData = $this->generateComparisonData($benchmarks, $selectedBenchmark);

            return view('benchmarks.index', compact(
                'benchmarks', 'images', 'selectedBenchmark',
                'gpu_brand', 'cpu_brand', 'resolucion',
                'preset', 'rtx', 'bestConfig', 'bestConfigsByCategory',
                'gpus', 'groupedByCategory', 'comparisonData'
            ));
        }

        return view('benchmarks.index', compact(
            'benchmarks', 'images', 'gpus', 'groupedByCategory', 'bestConfigsByCategory'
        ));
    }

    private function getGameImages()
    {
        return [
            1 => 'spiderman_miles_morales.png',
            2 => 'cyberpunk_2077.png',
            3 => 'league_of_legends.png',
            4 => 'r_6_s.png',
            5 => 'mk1.png',
            6 => 'dbz.png',
            7 => 'red dead.png',
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

    private function generateComparisonData($benchmarks, $selectedBenchmark)
    {
        $comparisonData = [];

        foreach ($benchmarks as $benchmark) {
            if ($benchmark->juego->id === $selectedBenchmark->juego->id) {
                $config = $benchmark->configuracion;

                $fps_improvement = $selectedBenchmark->avg_fps > 0
                    ? (($benchmark->avg_fps - $selectedBenchmark->avg_fps) / $selectedBenchmark->avg_fps) * 100
                    : 0;

                $cpu_usage_diff = $selectedBenchmark->cpu_usage > 0
                    ? (($benchmark->cpu_usage - $selectedBenchmark->cpu_usage) / $selectedBenchmark->cpu_usage) * 100
                    : 0;

                $gpu_usage_diff = $selectedBenchmark->gpu_usage > 0
                    ? (($benchmark->gpu_usage - $selectedBenchmark->gpu_usage) / $selectedBenchmark->gpu_usage) * 100
                    : 0;

                $comparisonData[] = [
                    'benchmark' => $benchmark,
                    'config' => $config,
                    'fps_improvement' => $fps_improvement,
                    'cpu_usage_diff' => $cpu_usage_diff,
                    'gpu_usage_diff' => $gpu_usage_diff
                ];
            }
        }

        usort($comparisonData, function ($a, $b) {
            return $b['benchmark']->avg_fps <=> $a['benchmark']->avg_fps;
        });

        return $comparisonData;
    }

    private function calculateBestConfigsByCategory($groupedByCategory)
    {
        $bestConfigs = [];

        foreach ($groupedByCategory as $category => $benchmarksInCategory) {
            $ajuste = AjusteRecomendado::where('categoria', $category)->first();

            if (!$ajuste) {
                continue;
            }

            $filteredBenchmarks = $benchmarksInCategory->filter(function ($benchmark) use ($ajuste) {
                return (
                    $benchmark->configuracion->resolucion === $ajuste->recommended_resolution &&
                    $benchmark->avg_fps >= $ajuste->min_fps &&
                    ($ajuste->max_fps === null || $benchmark->avg_fps <= $ajuste->max_fps)
                );
            });

            if ($filteredBenchmarks->isEmpty()) {
                $bestConfigs[$category] = [
                    'bestGpu' => null,
                    'bestConfig' => null,
                    'bestFps' => 0,
                    'message' => "No se encontraron benchmarks que cumplan con los ajustes recomendados para {$category}.",
                ];
                continue;
            }

            $bestBenchmark = $filteredBenchmarks->sortByDesc('avg_fps')->first();

            $bestConfigs[$category] = [
                'bestGpu' => $bestBenchmark->gpu,
                'bestConfig' => $bestBenchmark->configuracion,
                'bestFps' => $bestBenchmark->avg_fps,
                'message' => "Los FPS promedio cumplen con los estándares esperados para la categoría {$category}. "
                    . "Los estándares esperados son entre {$ajuste->min_fps} y "
                    . ($ajuste->max_fps ?? 'un límite superior indefinido') . " FPS.",
            ];            
        }
        return $bestConfigs;
    }

}
