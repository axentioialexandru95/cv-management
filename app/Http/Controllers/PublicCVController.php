<?php

namespace App\Http\Controllers;

use App\Models\CV;
use Illuminate\View\View;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Symfony\Component\HttpFoundation\Response;

class PublicCVController extends Controller
{
    public function show(string $slug): View
    {
        $cv = CV::where('public_slug', $slug)->firstOrFail();

        if (! $cv->is_public) {
            abort(404);
        }

        $cv->incrementViews();

        return view('cv.public', [
            'cv' => $cv,
        ]);
    }

    public function viewPdf(string $slug): Response
    {
        $cv = CV::where('public_slug', $slug)->firstOrFail();

        if (! $cv->is_public) {
            abort(404);
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

    public function downloadPdf(string $slug): Response
    {
        $cv = CV::where('public_slug', $slug)->firstOrFail();

        if (! $cv->is_public) {
            abort(404);
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
