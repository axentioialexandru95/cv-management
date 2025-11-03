<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $cv->first_name }} {{ $cv->last_name }} - CV</title>
    @vite('resources/css/app.css')
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        .page-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            flex-shrink: 0;
        }

        .content {
            flex: 1;
            min-height: 0;
        }

        .pdf-iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        @media (max-width: 768px) {
            .header-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .header-buttons a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body class="bg-background">
    <div class="page-container">
        <!-- Header -->
        <div class="header border-b border-border bg-card/50">
            <div class="flex flex-col items-center justify-between gap-4 px-4 py-4 sm:flex-row sm:px-6">
                <div class="flex items-center gap-2">
                    <img src="/logo.png" alt="CV Maker" class="h-10 sm:h-12" />
                </div>
                <div class="header-buttons flex items-center gap-4">
                    <a href="/" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground transition-all hover:bg-primary/90">
                        Create Your Own CV
                    </a>
                </div>
            </div>
        </div>

        <!-- PDF Viewer -->
        <div class="content bg-gray-100 dark:bg-gray-900">
            <iframe
                src="{{ route('cv.public.view', ['slug' => $cv->public_slug]) }}"
                class="pdf-iframe"
                title="{{ $cv->first_name }} {{ $cv->last_name }} CV"
            ></iframe>
        </div>
    </div>
</body>
</html>
