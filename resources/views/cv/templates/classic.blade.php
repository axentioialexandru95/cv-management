<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->first_name }} {{ $cv->last_name }} - Classic CV</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --accent-color: {{ $cv->accent_color ?? $cv->template_id->defaultColor() }};
            --accent-color-dark: {{ \App\Helpers\ColorHelper::darken($cv->accent_color ?? $cv->template_id->defaultColor(), 15) }};
            --accent-color-light: {{ \App\Helpers\ColorHelper::lighten($cv->accent_color ?? $cv->template_id->defaultColor(), 40) }};
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

        /* Classic serif typography */
        h1, h2, h3 {
            font-family: Georgia, 'Times New Roman', serif;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .accent-border {
            border-color: var(--accent-color);
        }

        .accent-text {
            color: var(--accent-color);
        }

        .section-divider {
            border-bottom: 1px solid #d1d5db;
        }
    </style>
</head>
<body class="bg-white">
    <div class="mx-auto max-w-3xl bg-white px-12 py-10 text-sm text-gray-900">
        {{-- Header --}}
        <div class="mb-8 text-center">
            <h1 class="mb-3 text-4xl font-bold text-gray-900">{{ $cv->first_name }} {{ $cv->last_name }}</h1>
            @if($cv->title)
                <p class="mb-4 text-lg italic text-gray-700">{{ $cv->title }}</p>
            @endif

            {{-- Contact Information --}}
            <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-sm text-gray-700">
                @if($cv->email)
                    <span>{{ $cv->email }}</span>
                @endif
                @if($cv->phone)
                    <span>•</span>
                    <span>{{ $cv->phone }}</span>
                @endif
                @if($cv->city || $cv->country)
                    <span>•</span>
                    <span>
                        @if($cv->city) {{ $cv->city }}, @endif
                        @if($cv->country) {{ $cv->country }} @endif
                    </span>
                @endif
            </div>
            @if($cv->linkedin_url || $cv->website_url)
                <div class="mt-2 flex flex-wrap items-center justify-center gap-x-4 text-sm">
                    @if($cv->linkedin_url)
                        <span class="accent-text">{{ $cv->linkedin_url }}</span>
                    @endif
                    @if($cv->website_url)
                        <span class="accent-text">{{ $cv->website_url }}</span>
                    @endif
                </div>
            @endif
        </div>

        {{-- Profile Photo --}}
        @if($cv->profile_photo_path)
            <div class="mb-8 text-center">
                @php
                    $profilePhotoPath = Storage::path($cv->profile_photo_path);
                    $imageData = base64_encode(file_get_contents($profilePhotoPath));
                    $imageType = pathinfo($profilePhotoPath, PATHINFO_EXTENSION);
                    $imageSrc = "data:image/{$imageType};base64,{$imageData}";
                @endphp
                <img src="{{ $imageSrc }}" alt="Profile Photo" class="mx-auto h-32 w-32 rounded border border-gray-300 object-cover">
            </div>
        @endif

        {{-- About Me / Profile --}}
        @if($cv->about_me)
            <div class="section-divider mb-6 pb-6">
                <h2 class="mb-3 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Profile</h2>
                <p class="whitespace-pre-line text-center leading-relaxed text-gray-700">{{ $cv->about_me }}</p>
            </div>
        @endif

        {{-- Work Experience --}}
        @if($cv->workExperiences->count() > 0)
            <div class="section-divider mb-6 pb-6">
                <h2 class="mb-4 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Professional Experience</h2>
                <div class="space-y-5">
                    @foreach($cv->workExperiences as $experience)
                        <div class="avoid-break">
                            <div class="mb-2 text-center">
                                <h3 class="text-lg font-bold text-gray-900">{{ $experience->job_title }}</h3>
                                <p class="italic accent-text">{{ $experience->employer }}</p>
                                <p class="text-sm text-gray-600">
                                    @if($experience->city || $experience->country)
                                        @if($experience->city) {{ $experience->city }}, @endif
                                        {{ $experience->country }} —
                                    @endif
                                    @if($experience->start_date)
                                        {{ $experience->start_date->format('F Y') }} –
                                    @endif
                                    @if($experience->is_current)
                                        Present
                                    @elseif($experience->end_date)
                                        {{ $experience->end_date->format('F Y') }}
                                    @endif
                                </p>
                            </div>
                            @if($experience->description)
                                <p class="whitespace-pre-line text-justify leading-relaxed text-gray-700">{{ $experience->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Education --}}
        @if($cv->educationEntries->count() > 0)
            <div class="section-divider mb-6 pb-6">
                <h2 class="mb-4 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Education</h2>
                <div class="space-y-5">
                    @foreach($cv->educationEntries as $education)
                        <div class="avoid-break">
                            <div class="text-center">
                                <h3 class="text-lg font-bold text-gray-900">{{ $education->qualification }}</h3>
                                @if($education->field_of_study)
                                    <p class="text-gray-700">{{ $education->field_of_study }}</p>
                                @endif
                                <p class="italic accent-text">{{ $education->institution }}</p>
                                <p class="text-sm text-gray-600">
                                    @if($education->city || $education->country)
                                        @if($education->city) {{ $education->city }}, @endif
                                        {{ $education->country }} —
                                    @endif
                                    @if($education->start_date)
                                        {{ $education->start_date->format('F Y') }} –
                                    @endif
                                    @if($education->is_current)
                                        Present
                                    @elseif($education->end_date)
                                        {{ $education->end_date->format('F Y') }}
                                    @endif
                                </p>
                                @if($education->grade)
                                    <p class="mt-1 text-sm text-gray-700">
                                        <span class="font-semibold">Grade:</span> {{ $education->grade }}
                                    </p>
                                @endif
                            </div>
                            @if($education->description)
                                <p class="mt-2 text-justify leading-relaxed text-gray-700">{{ $education->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Skills --}}
        @if($cv->skills->count() > 0)
            <div class="section-divider mb-6 pb-6">
                <h2 class="mb-4 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Skills & Competencies</h2>
                @php
                    $groupedSkills = $cv->skills->groupBy('category');
                @endphp
                <div class="space-y-3">
                    @foreach($groupedSkills as $category => $skills)
                        <div>
                            <h3 class="mb-2 font-bold text-gray-900">{{ Str::title($category) }}</h3>
                            <p class="text-gray-700">
                                @foreach($skills as $index => $skill)
                                    {{ $skill->name }}@if($skill->proficiency_level) ({{ $skill->proficiency_level }})@endif@if(!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Languages --}}
        @if($cv->languages->count() > 0)
            <div class="section-divider mb-6 pb-6">
                <h2 class="mb-4 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Languages</h2>
                <div class="space-y-2">
                    @foreach($cv->languages as $language)
                        <div>
                            <span class="font-bold text-gray-900">{{ $language->name }}:</span>
                            @if($language->pivot->is_native)
                                <span class="text-gray-700">Native speaker</span>
                            @else
                                <span class="text-gray-700">
                                    @if($language->pivot->listening)
                                        {{ $language->pivot->listening }}
                                    @endif
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Certifications --}}
        @if($cv->certifications->count() > 0)
            <div class="section-divider mb-6 pb-6">
                <h2 class="mb-4 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Certifications</h2>
                <div class="space-y-3">
                    @foreach($cv->certifications as $certification)
                        <div class="avoid-break">
                            <h3 class="font-bold text-gray-900">{{ $certification->title }}</h3>
                            <p class="italic accent-text">{{ $certification->issuing_organization }}</p>
                            @if($certification->issue_date)
                                <p class="text-sm text-gray-600">
                                    Issued: {{ $certification->issue_date->format('F Y') }}
                                    @if($certification->expiry_date)
                                        • Expires: {{ $certification->expiry_date->format('F Y') }}
                                    @endif
                                </p>
                            @endif
                            @if($certification->description)
                                <p class="mt-1 text-gray-700">{{ $certification->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Projects --}}
        @if($cv->projects->count() > 0)
            <div class="section-divider mb-6 pb-6">
                <h2 class="mb-4 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Notable Projects</h2>
                <div class="space-y-4">
                    @foreach($cv->projects as $project)
                        <div class="avoid-break">
                            <h3 class="font-bold text-gray-900">{{ $project->title }}</h3>
                            @if($project->role)
                                <p class="italic text-gray-700">{{ $project->role }}</p>
                            @endif
                            @if($project->start_date || $project->is_ongoing || $project->end_date)
                                <p class="text-sm text-gray-600">
                                    @if($project->start_date)
                                        {{ $project->start_date->format('F Y') }} –
                                    @endif
                                    @if($project->is_ongoing)
                                        Present
                                    @elseif($project->end_date)
                                        {{ $project->end_date->format('F Y') }}
                                    @endif
                                </p>
                            @endif
                            @if($project->description)
                                <p class="mt-1 whitespace-pre-line text-justify leading-relaxed text-gray-700">{{ $project->description }}</p>
                            @endif
                            @if($project->technologies && count($project->technologies) > 0)
                                <p class="mt-1 text-sm text-gray-600">
                                    <span class="font-semibold">Technologies:</span> {{ implode(', ', $project->technologies) }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Publications --}}
        @if($cv->publications->count() > 0)
            <div class="section-divider mb-6 pb-6">
                <h2 class="mb-4 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Publications</h2>
                <div class="space-y-3">
                    @foreach($cv->publications as $publication)
                        <div class="avoid-break">
                            <p class="font-bold text-gray-900">{{ $publication->title }}</p>
                            <p class="text-sm text-gray-700">{{ $publication->authors }}</p>
                            <p class="italic accent-text">{{ $publication->publication_venue }}</p>
                            @if($publication->publication_date)
                                <p class="text-sm text-gray-600">{{ $publication->publication_date->format('Y') }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Volunteer Experience --}}
        @if($cv->volunteerExperiences->count() > 0)
            <div class="section-divider mb-6 pb-6">
                <h2 class="mb-4 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Volunteer Work</h2>
                <div class="space-y-4">
                    @foreach($cv->volunteerExperiences as $volunteer)
                        <div class="avoid-break">
                            <div class="text-center">
                                <h3 class="font-bold text-gray-900">{{ $volunteer->role }}</h3>
                                <p class="italic accent-text">{{ $volunteer->organization }}</p>
                                <p class="text-sm text-gray-600">
                                    @if($volunteer->city || $volunteer->country)
                                        @if($volunteer->city) {{ $volunteer->city }}, @endif
                                        {{ $volunteer->country }} —
                                    @endif
                                    @if($volunteer->start_date)
                                        {{ $volunteer->start_date->format('F Y') }} –
                                    @endif
                                    @if($volunteer->is_current)
                                        Present
                                    @elseif($volunteer->end_date)
                                        {{ $volunteer->end_date->format('F Y') }}
                                    @endif
                                </p>
                            </div>
                            @if($volunteer->description)
                                <p class="mt-2 whitespace-pre-line text-justify leading-relaxed text-gray-700">{{ $volunteer->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Personal Information --}}
        @if($cv->date_of_birth || $cv->nationality || ($cv->driving_licenses && count($cv->driving_licenses) > 0))
            <div class="mb-6">
                <h2 class="mb-4 text-center text-xl font-bold uppercase tracking-wide text-gray-800">Additional Information</h2>
                <div class="space-y-1 text-center text-gray-700">
                    @if($cv->date_of_birth)
                        <p>
                            <span class="font-semibold">Date of Birth:</span> {{ $cv->date_of_birth->format('d F Y') }}
                        </p>
                    @endif
                    @if($cv->nationality)
                        <p>
                            <span class="font-semibold">Nationality:</span> {{ $cv->nationality }}
                        </p>
                    @endif
                    @if($cv->driving_licenses && count($cv->driving_licenses) > 0)
                        <p>
                            <span class="font-semibold">Driving License:</span> {{ implode(', ', $cv->driving_licenses) }}
                        </p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Footer --}}
        <div class="mt-8 border-t border-gray-300 pt-4 text-center text-xs text-gray-500">
            <p>© {{ now()->year }} {{ $cv->first_name }} {{ $cv->last_name }}. Classic CV format.</p>
        </div>
    </div>
</body>
</html>
