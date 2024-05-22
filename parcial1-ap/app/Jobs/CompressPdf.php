<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class CompressPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;
    protected $taskId;

    public function __construct($path, $taskId)
    {
        $this->path = $path;
        $this->taskId = $taskId;
    }

    public function handle()
    {
        Log::info("Job started for task: {$this->taskId}");

        $inputPath = Storage::disk('public')->path($this->path);
        $outputPath = Storage::disk('public')->path("uploads/{$this->taskId}_compressed.pdf");

        Log::info("Input path: {$inputPath}");
        Log::info("Output path: {$outputPath}");

        // Crear una nueva instancia de FPDI
        $pdf = new FPDI();

        // Añadir el PDF original a FPDI
        try {
            $pageCount = $pdf->setSourceFile($inputPath);
            Log::info("Number of pages: {$pageCount}");

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $tplId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($tplId);

                Log::info("Processing page: {$pageNo}, size: " . json_encode($size));

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($tplId);
            }

            // Guardar el PDF comprimido
            $pdf->Output($outputPath, 'F');
            Log::info("Compression completed for task: {$this->taskId}");
        } catch (\Exception $e) {
            Log::error("Error processing job: " . $e->getMessage());
        }
    }
}

