<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->first_name }} {{ $cv->last_name }} - Minimalist CV</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --accent-color: {{ $cv->accent_color ?? $cv->template_id->defaultColor() }};
        }

        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            .page-break {
                page-break-before: always;
            }
            .avoid-break {
                page-break-inside: avoid;
            }
            p, div {
                orphans: 3;
                widows: 3;
            }
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.5;
        }

        .accent-text {
            color: var(--accent-color);
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    <div class="mx-auto max-w-2xl px-8 py-10 text-sm">
        {{-- Header --}}
        <div class="mb-10">
            <h1 class="mb-1 text-3xl font-light tracking-tight accent-text">{{ $cv->first_name }} {{ $cv->last_name }}</h1>
            @if($cv->title)
                <p class="mb-6 text-base text-gray-700">{{ $cv->title }}</p>
            @endif

            {{-- Contact Information --}}
            <div class="space-y-0.5 text-sm text-gray-700">
                @if($cv->email)
                    <p>{{ $cv->email }}</p>
                @endif
                @if($cv->phone)
                    <p>{{ $cv->phone }}</p>
                @endif
                @if($cv->city || $cv->country)
                    <p>
                        @if($cv->city) {{ $cv->city }}, @endif
                        @if($cv->country) {{ $cv->country }} @endif
                    </p>
                @endif
                @if($cv->linkedin_url)
                    <p class="accent-text">{{ $cv->linkedin_url }}</p>
                @endif
                @if($cv->website_url)
                    <p class="accent-text">{{ $cv->website_url }}</p>
                @endif
            </div>
        </div>

        {{-- About Me --}}
        @if($cv->about_me)
            <div class="mb-10">
                <h2 class="mb-3 text-xs font-semibold uppercase tracking-widest accent-text">Profile</h2>
                <p class="whitespace-pre-line text-gray-700">{{ $cv->about_me }}</p>
            </div>
        @endif

        {{-- Work Experience --}}
        @if($cv->workExperiences->count() > 0)
            <div class="mb-10">
                <h2 class="mb-4 text-xs font-semibold uppercase tracking-widest accent-text">Experience</h2>
                <div class="space-y-6">
                    @foreach($cv->workExperiences as $experience)
                        <div class="avoid-break">
                            <div class="mb-1 flex items-baseline justify-between">
                                <h3 class="font-semibold text-gray-900">{{ $experience->job_title }}</h3>
                                <span class="text-xs text-gray-500">
                                    @if($experience->start_date)
                                        {{ $experience->start_date->format('Y') }}
                                    @endif
                                    @if($experience->end_date || $experience->is_current)
                                        –
                                        @if($experience->is_current)
                                            Now
                                        @else
                                            {{ $experience->end_date->format('Y') }}
                                        @endif
                                    @endif
                                </span>
                            </div>
                            <p class="mb-1 text-gray-700">{{ $experience->employer }}</p>
                            @if($experience->description)
                                <p class="whitespace-pre-line text-gray-700">{{ $experience->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Education --}}
        @if($cv->educationEntries->count() > 0)
            <div class="mb-10">
                <h2 class="mb-4 text-xs font-semibold uppercase tracking-widest accent-text">Education</h2>
                <div class="space-y-6">
                    @foreach($cv->educationEntries as $education)
                        <div class="avoid-break">
                            <div class="mb-1 flex items-baseline justify-between">
                                <h3 class="font-semibold text-gray-900">{{ $education->qualification }}</h3>
                                <span class="text-xs text-gray-500">
                                    @if($education->start_date)
                                        {{ $education->start_date->format('Y') }}
                                    @endif
                                    @if($education->end_date || $education->is_current)
                                        –
                                        @if($education->is_current)
                                            Now
                                        @else
                                            {{ $education->end_date->format('Y') }}
                                        @endif
                                    @endif
                                </span>
                            </div>
                            <p class="text-gray-700">
                                {{ $education->institution }}@if($education->field_of_study), {{ $education->field_of_study }}@endif
                            </p>
                            @if($education->grade)
                                <p class="text-sm text-gray-600">{{ $education->grade }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Skills --}}
        @if($cv->skills->count() > 0)
            <div class="mb-10">
                <h2 class="mb-3 text-xs font-semibold uppercase tracking-widest accent-text">Skills</h2>
                @php
                    $groupedSkills = $cv->skills->groupBy('category');
                @endphp
                <div class="space-y-2">
                    @foreach($groupedSkills as $category => $skills)
                        <div>
                            <span class="font-semibold text-gray-900">{{ Str::title($category)}}:</span>
                            <span class="text-gray-700">
                                @foreach($skills as $skill)
                                    {{ $skill->name }}@if(!$loop->last), @endif
                                @endforeach
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Projects --}}
        @if($cv->projects->count() > 0)
            <div class="mb-10">
                <h2 class="mb-4 text-xs font-semibold uppercase tracking-widest accent-text">Projects</h2>
                <div class="space-y-5">
                    @foreach($cv->projects as $project)
                        <div class="avoid-break">
                            <div class="mb-1 flex items-baseline justify-between">
                                <h3 class="font-semibold text-gray-900">{{ $project->title }}</h3>
                                @if($project->start_date || $project->is_ongoing || $project->end_date)
                                    <span class="text-xs text-gray-500">
                                        @if($project->start_date)
                                            {{ $project->start_date->format('Y') }}
                                        @endif
                                        @if($project->end_date || $project->is_ongoing)
                                            –
                                            @if($project->is_ongoing)
                                                Now
                                            @else
                                                {{ $project->end_date->format('Y') }}
                                            @endif
                                        @endif
                                    </span>
                                @endif
                            </div>
                            @if($project->description)
                                <p class="whitespace-pre-line text-gray-700">{{ $project->description }}</p>
                            @endif
                            @if($project->technologies && count($project->technologies) > 0)
                                <p class="mt-1 text-sm text-gray-600">{{ implode(', ', $project->technologies) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Languages --}}
        @if($cv->languages->count() > 0)
            <div class="mb-10">
                <h2 class="mb-3 text-xs font-semibold uppercase tracking-widest accent-text">Languages</h2>
                <div class="space-y-1">
                    @foreach($cv->languages as $language)
                        <div>
                            <span class="font-semibold text-gray-900">{{ $language->name }}:</span>
                            <span class="text-gray-700">
                                @if($language->pivot->is_native)
                                    Native
                                @else
                                    @if($language->pivot->listening)
                                        {{ $language->pivot->listening }}
                                    @endif
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Certifications (only if exists) --}}
        @if($cv->certifications->count() > 0)
            <div class="mb-10">
                <h2 class="mb-4 text-xs font-semibold uppercase tracking-widest accent-text">Certifications</h2>
                <div class="space-y-3">
                    @foreach($cv->certifications as $certification)
                        <div class="avoid-break">
                            <h3 class="font-semibold text-gray-900">{{ $certification->title }}</h3>
                            <p class="text-gray-700">{{ $certification->issuing_organization }}</p>
                            @if($certification->issue_date)
                                <p class="text-sm text-gray-600">{{ $certification->issue_date->format('Y') }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Publications (only if exists) --}}
        @if($cv->publications->count() > 0)
            <div class="mb-10">
                <h2 class="mb-4 text-xs font-semibold uppercase tracking-widest accent-text">Publications</h2>
                <div class="space-y-3">
                    @foreach($cv->publications as $publication)
                        <div class="avoid-break">
                            <p class="font-semibold text-gray-900">{{ $publication->title }}</p>
                            <p class="text-sm text-gray-700">{{ $publication->authors }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $publication->publication_venue }}
                                @if($publication->publication_date), {{ $publication->publication_date->format('Y') }}@endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Volunteer Experience (only if exists) --}}
        @if($cv->volunteerExperiences->count() > 0)
            <div class="mb-10">
                <h2 class="mb-4 text-xs font-semibold uppercase tracking-widest accent-text">Volunteer Work</h2>
                <div class="space-y-5">
                    @foreach($cv->volunteerExperiences as $volunteer)
                        <div class="avoid-break">
                            <div class="mb-1 flex items-baseline justify-between">
                                <h3 class="font-semibold text-gray-900">{{ $volunteer->role }}</h3>
                                <span class="text-xs text-gray-500">
                                    @if($volunteer->start_date)
                                        {{ $volunteer->start_date->format('Y') }}
                                    @endif
                                    @if($volunteer->end_date || $volunteer->is_current)
                                        –
                                        @if($volunteer->is_current)
                                            Now
                                        @else
                                            {{ $volunteer->end_date->format('Y') }}
                                        @endif
                                    @endif
                                </span>
                            </div>
                            <p class="text-gray-700">{{ $volunteer->organization }}</p>
                            @if($volunteer->description)
                                <p class="whitespace-pre-line text-gray-700">{{ $volunteer->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Additional Info (only if exists) --}}
        @if($cv->date_of_birth || $cv->nationality)
            <div class="mb-10">
                <h2 class="mb-3 text-xs font-semibold uppercase tracking-widest accent-text">Additional</h2>
                <div class="space-y-1 text-sm text-gray-700">
                    @if($cv->date_of_birth)
                        <p>{{ $cv->date_of_birth->format('Y') }}</p>
                    @endif
                    @if($cv->nationality)
                        <p>{{ $cv->nationality }}</p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Footer --}}
        <div class="mt-12 pt-6 text-center text-xs text-gray-400">
            <p>{{ $cv->first_name }} {{ $cv->last_name }} • {{ now()->year }}</p>
        </div>
    </div>
</body>
</html>
