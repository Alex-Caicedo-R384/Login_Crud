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
    
        $groupedByCategory = $benchmarks->groupBy(function ($benchmark) {
            return $benchmark->juego->categoria;
        });
    
        $images = $this->getGameImages();
        $gpus = Gpu::all();
    
        $selectedBenchmark = null;
        $comparisonData = [];
        $bestGpu = null;
        $bestConfig = null;
        $bestFps = 0;
    
        if ($request->has('benchmark_id')) {
            $selectedBenchmark = Benchmark::with('juego', 'gpu', 'processor', 'configuracion')
                ->findOrFail($request->benchmark_id);
    
            $gameCategory = $selectedBenchmark->juego->categoria;
    
            if ($gameCategory == 'Competitivo') {
                $bestGpuAndConfig = $this->getBestGpuAndConfigCompetitivo($benchmarks);
            } elseif ($gameCategory == 'Triple A') {
                $bestGpuAndConfig = $this->getBestGpuAndConfigTripleA($benchmarks);
            } elseif ($gameCategory == 'Peleas') {
                $bestGpuAndConfig = $this->getBestGpuAndConfigPeleas($benchmarks);
            }
    
            $bestGpu = $bestGpuAndConfig['bestGpu'];
            $bestConfig = $bestGpuAndConfig['bestConfig'];
            $bestFps = $bestGpuAndConfig['bestFps'];
    
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
                'preset', 'rtx', 'bestConfig', 'bestGpu',
                'bestFps', 'comparisonData', 'gpus', 'groupedByCategory'
            ));
        }
    
        return view('benchmarks.index', compact('benchmarks', 'images', 'gpus', 'groupedByCategory', 'bestGpu', 'bestConfig', 'bestFps'));
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

    private function getBestGpuAndConfigCompetitivo($benchmarks)
    {
        $bestGpu = null;
        $bestConfig = null;
        $bestFps = 0;
        $bestConfigResolution = '1440p';

        $filteredBenchmarks = $benchmarks->filter(function ($benchmark) {
            return $benchmark->juego->categoria == 'Competitivo';
        });

        foreach ($filteredBenchmarks as $benchmark) {
            if ($benchmark->avg_fps >= 140 && $benchmark->avg_fps <= 600) {
                if ($benchmark->configuracion->resolucion == $bestConfigResolution) {
                    if ($benchmark->avg_fps > $bestFps) {
                        $bestFps = $benchmark->avg_fps;
                        $bestGpu = $benchmark->gpu;
                        $bestConfig = $benchmark->configuracion;
                    }
                }
            }
        }

        if (!$bestGpu) {
            return [
                'bestGpu' => null,
                'bestConfig' => null,
                'bestFps' => 0,
                'message' => "No se ha encontrado una configuración recomendada para la categoría Competitivo."
            ];
        }

        $message = "La mejor gráfica para esta categoría de juego es la {$bestGpu->name}, porque tiene {$bestFps} FPS en la resolución recomendada de {$bestConfigResolution}.";

        return [
            'bestGpu' => $bestGpu,
            'bestConfig' => $bestConfig,
            'bestFps' => $bestFps,
            'message' => $message
        ];
    }

    private function getBestGpuAndConfigTripleA($benchmarks)
    {
        $bestGpu = null;
        $bestConfig = null;
        $bestFps = 0;
        $bestConfigResolution = '1440p';
    
        $filteredBenchmarks = $benchmarks->filter(function ($benchmark) {
            if ($benchmark->juego->categoria == 'Triple A') {
                \Log::info('Benchmark categoría Triple A:', ['benchmark' => $benchmark]);
                return true;
            }
            return false;
        });
    
        if ($filteredBenchmarks->isEmpty()) {
            \Log::warning('No se encontraron benchmarks de la categoría Triple A.');
        }
    
        foreach ($filteredBenchmarks as $benchmark) {
            if ($benchmark->avg_fps >= 60) {
                if (($benchmark->configuracion->resolucion == '1440p') && 
                    ($benchmark->configuracion->rtx == 'Sí' || $benchmark->avg_fps >= 100)) {
                    if ($benchmark->avg_fps > $bestFps) {
                        $bestFps = $benchmark->avg_fps;
                        $bestGpu = $benchmark->gpu;
                        $bestConfig = $benchmark->configuracion;
                    }
                }
            }
        }
    
        if (!$bestGpu) {
            return [
                'bestGpu' => null,
                'bestConfig' => null,
                'bestFps' => 0,
                'message' => "No se ha encontrado una configuración recomendada para la categoría Triple A."
            ];
        }
    
        $message = "La mejor gráfica para juegos de alta gama es la {$bestGpu->name}, alcanzando {$bestFps} FPS en la resolución de {$bestConfigResolution}.";
    
        return [
            'bestGpu' => $bestGpu,
            'bestConfig' => $bestConfig,
            'bestFps' => $bestFps,
            'message' => $message
        ];
    }
    

    private function getBestGpuAndConfigPeleas($benchmarks)
    {
        $bestGpu = null;
        $bestConfig = null;
        $bestFps = 0;
        $bestConfigResolution = '1080p';

        $filteredBenchmarks = $benchmarks->filter(function ($benchmark) {
            return $benchmark->juego->categoria == 'Peleas';
        });

        foreach ($filteredBenchmarks as $benchmark) {
            if ($benchmark->avg_fps == 60) {
                if ($benchmark->configuracion->resolucion == $bestConfigResolution) {
                    if ($benchmark->avg_fps > $bestFps) {
                        $bestFps = $benchmark->avg_fps;
                        $bestGpu = $benchmark->gpu;
                        $bestConfig = $benchmark->configuracion;
                    }
                }
            }
        }

        if (!$bestGpu) {
            return [
                'bestGpu' => null,
                'bestConfig' => null,
                'bestFps' => 0,
                'message' => "No se ha encontrado una configuración recomendada para la categoría Peleas."
            ];
        }

        $message = "La mejor gráfica para juegos de peleas es la {$bestGpu->name}, ofreciendo {$bestFps} FPS en la resolución recomendada de {$bestConfigResolution}.";

        return [
            'bestGpu' => $bestGpu,
            'bestConfig' => $bestConfig,
            'bestFps' => $bestFps,
            'message' => $message
        ];
    }
    
}
