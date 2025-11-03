<?php

namespace App\Http\Controllers;

use App\Models\CV;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Symfony\Component\HttpFoundation\Response;

class CVController extends Controller
{
    public function show(CV $cv): Response
    {
        // Ensure user can only view their own CVs
        if ($cv->user_id !== auth()->id()) {
            abort(403);
        }

        $cv->load([
            'workExperiences',
            'educationEntries',
            'languages',
            'skills',
            'certifications',
            'projects',
            'publications',
            'volunteerExperiences',
        ]);

        $viewPath = $cv->template_id->viewPath();

        return Pdf::view($viewPath, ['cv' => $cv])
            ->format('a4')
            ->margins(15, 15, 15, 15)
            ->withBrowsershot($this->configureBrowsershot(...))
            ->inline()
            ->toResponse(request());
    }

    public function downloadPdf(CV $cv): Response
    {
        // Ensure user can only download their own CVs
        if ($cv->user_id !== auth()->id()) {
            abort(403);
        }

        $cv->load([
            'workExperiences',
            'educationEntries',
            'languages',
            'skills',
            'certifications',
            'projects',
            'publications',
            'volunteerExperiences',
        ]);

        $fileName = str($cv->first_name.'_'.$cv->last_name.'_CV.pdf')
            ->slug()
            ->append('.pdf');

        $viewPath = $cv->template_id->viewPath();

        return Pdf::view($viewPath, ['cv' => $cv])
            ->format('a4')
            ->margins(15, 15, 15, 15)
            ->withBrowsershot($this->configureBrowsershot(...))
            ->name($fileName)
            ->download()
            ->toResponse(request());
    }

    private function configureBrowsershot(Browsershot $browsershot): void
    {
        // Create a temporary symlink to avoid spaces in path
        $tempDir = sys_get_temp_dir().'/cv-maker-node';
        $nodeBin = $tempDir.'/node';
        $npmBin = $tempDir.'/npm';

        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $herdNodePath = getenv('HOME').'/Library/Application Support/Herd/config/nvm/versions/node/v22.14.0/bin';

        if (! file_exists($nodeBin)) {
            symlink($herdNodePath.'/node', $nodeBin);
        }
        if (! file_exists($npmBin)) {
            symlink($herdNodePath.'/npm', $npmBin);
        }

        $browsershot->setNodeBinary($nodeBin)
            ->setNpmBinary($npmBin);
    }
}
