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
        // Detect Node.js path based on environment
        $nodePath = $this->getNodePath();
        $npmPath = $this->getNpmPath();
        $chromePath = $this->getChromePath();

        if ($nodePath) {
            $browsershot->setNodeBinary($nodePath);
        }

        if ($npmPath) {
            $browsershot->setNpmBinary($npmPath);
        }

        if ($chromePath) {
            $browsershot->setChromePath($chromePath);
        }
    }

    private function getNodePath(): ?string
    {
        // Laravel Cloud / Production - use system Node.js
        if (app()->environment('production')) {
            // Try common Linux paths
            $paths = [
                '/usr/bin/node',
                '/usr/local/bin/node',
                config('browsershot.node_binary'),
            ];

            foreach ($paths as $path) {
                if ($path && file_exists($path)) {
                    return $path;
                }
            }

            // Try to find node in PATH
            $which = shell_exec('which node');
            if ($which) {
                return trim($which);
            }

            return null;
        }

        // Local development (Herd) - use symlink to avoid spaces in path
        $tempDir = sys_get_temp_dir().'/cv-maker-node';
        $nodeBin = $tempDir.'/node';

        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $herdNodePath = getenv('HOME').'/Library/Application Support/Herd/config/nvm/versions/node/v22.14.0/bin';

        if (! file_exists($nodeBin) && file_exists($herdNodePath.'/node')) {
            symlink($herdNodePath.'/node', $nodeBin);
        }

        return file_exists($nodeBin) ? $nodeBin : null;
    }

    private function getNpmPath(): ?string
    {
        // Laravel Cloud / Production
        if (app()->environment('production')) {
            $paths = [
                '/usr/bin/npm',
                '/usr/local/bin/npm',
                config('browsershot.npm_binary'),
            ];

            foreach ($paths as $path) {
                if ($path && file_exists($path)) {
                    return $path;
                }
            }

            $which = shell_exec('which npm');
            if ($which) {
                return trim($which);
            }

            return null;
        }

        // Local development (Herd)
        $tempDir = sys_get_temp_dir().'/cv-maker-node';
        $npmBin = $tempDir.'/npm';

        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $herdNodePath = getenv('HOME').'/Library/Application Support/Herd/config/nvm/versions/node/v22.14.0/bin';

        if (! file_exists($npmBin) && file_exists($herdNodePath.'/npm')) {
            symlink($herdNodePath.'/npm', $npmBin);
        }

        return file_exists($npmBin) ? $npmBin : null;
    }

    private function getChromePath(): ?string
    {
        // Laravel Cloud / Production
        if (app()->environment('production')) {
            // Check environment variable first
            $envPath = config('browsershot.chrome_binary');
            if ($envPath && file_exists($envPath)) {
                return $envPath;
            }

            // Try common Linux Chrome/Chromium paths
            $paths = [
                '/usr/bin/chromium',
                '/usr/bin/chromium-browser',
                '/usr/bin/google-chrome',
                '/usr/bin/google-chrome-stable',
                getenv('PUPPETEER_EXECUTABLE_PATH'),
            ];

            foreach ($paths as $path) {
                if ($path && file_exists($path)) {
                    return $path;
                }
            }

            // Try to find chrome in PATH
            $which = shell_exec('which chromium chromium-browser google-chrome google-chrome-stable 2>/dev/null | head -n1');
            if ($which) {
                return trim($which);
            }

            return null;
        }

        // Local development (Herd) - Puppeteer's bundled Chrome
        // If Puppeteer is installed locally, it will use its bundled Chrome
        return null;
    }
}
