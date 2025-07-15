<?php

declare(strict_types=1);

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Services\ExportAccountData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdministrationExportController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('administration.export.index');
    }

    public function create(Request $request): RedirectResponse
    {
        try {
            $outputPath = (new ExportAccountData(
                user: Auth::user(),
            ))->execute();

            return redirect()->route('administration.export.index')
                ->with('status', trans('Account data exported successfully'))
                ->with('download_path', $outputPath);

        } catch (\Exception $e) {
            return redirect()->route('administration.export.index')
                ->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    public function download(Request $request): StreamedResponse
    {
        $filePath = $request->input('file');
        
        if (!$filePath || !file_exists($filePath)) {
            abort(404, 'Export file not found');
        }

        $fileName = basename($filePath);

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/json',
        ]);
    }
} 