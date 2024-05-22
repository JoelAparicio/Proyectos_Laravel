<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\CompressPdf;
use Illuminate\Support\Str;

class PdfController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function uploadPdf(Request $request)
    {
        $request->validate(['file' => 'required|mimes:pdf|max:2048']);

        $taskId = (string) Str::uuid();
        $path = $request->file('file')->storeAs('uploads', "$taskId.pdf", 'public');

        CompressPdf::dispatch($path, $taskId);

        return response()->json(['task_id' => $taskId]);
    }

    public function checkStatus($taskId)
    {
        $outputPath = "uploads/{$taskId}_compressed.pdf";
        if (Storage::disk('public')->exists($outputPath)) {
            return response()->json(['status' => 'completed', 'download_url' => url("/download/{$taskId}")]);
        }

        return response()->json(['status' => 'processing']);
    }

    public function downloadPage($taskId)
    {
        $downloadUrl = url("/download/{$taskId}");
        return view('download', compact('downloadUrl'));
    }

    public function downloadPdf($taskId)
    {
        $outputPath = "uploads/{$taskId}_compressed.pdf";
        if (Storage::disk('public')->exists($outputPath)) {
            return Storage::disk('public')->download($outputPath);
        }

        return abort(404);
    }
}
