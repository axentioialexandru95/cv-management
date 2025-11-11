<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->first_name }} {{ $cv->last_name }} - Modern CV</title>
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

        .accent-border {
            border-color: var(--accent-color);
        }

        .accent-text {
            color: var(--accent-color);
        }

        .accent-bg {
            background-color: var(--accent-color);
        }

        .accent-bg-light {
            background-color: var(--accent-color-light);
        }

        .sidebar-bg {
            background: linear-gradient(180deg, var(--accent-color-light) 0%, var(--accent-color-light) 100%);
        }
    </style>
</head>
<body class="bg-white font-sans">
    <div class="flex min-h-screen">
        {{-- Sidebar (30%) --}}
        <div class="sidebar-bg w-[30%] p-6 text-sm">
            {{-- Profile Photo --}}
            @if($cv->profile_photo_path && Storage::exists($cv->profile_photo_path))
                <div class="mb-6">
                    @php
                        $imageData = base64_encode(Storage::get($cv->profile_photo_path));
                        $imageType = pathinfo($cv->profile_photo_path, PATHINFO_EXTENSION);
                        $imageSrc = "data:image/{$imageType};base64,{$imageData}";
                    @endphp
                    <img src="{{ $imageSrc }}" alt="Profile Photo" class="mx-auto h-40 w-40 rounded-full border-4 border-white object-cover shadow-lg">
                </div>
            @endif

            {{-- Contact Information --}}
            <div class="mb-6">
                <h2 class="mb-3 text-xs font-bold uppercase tracking-wider accent-text">Contact</h2>
                <div class="space-y-2 text-gray-700">
                    @if($cv->email)
                        <div class="break-all">
                            <p class="text-xs font-semibold text-gray-600">Email</p>
                            <p>{{ $cv->email }}</p>
                        </div>
                    @endif
                    @if($cv->phone)
                        <div>
                            <p class="text-xs font-semibold text-gray-600">Phone</p>
                            <p>{{ $cv->phone }}</p>
                        </div>
                    @endif
                    @if($cv->address || $cv->city || $cv->postal_code || $cv->country)
                        <div>
                            <p class="text-xs font-semibold text-gray-600">Address</p>
                            <p>
                                @if($cv->address) {{ $cv->address }}<br> @endif
                                @if($cv->city) {{ $cv->city }} @endif
                                @if($cv->postal_code) {{ $cv->postal_code }}<br> @endif
                                @if($cv->country) {{ $cv->country }} @endif
                            </p>
                        </div>
                    @endif
                    @if($cv->linkedin_url)
                        <div class="break-all">
                            <p class="text-xs font-semibold text-gray-600">LinkedIn</p>
                            <p class="accent-text">{{ $cv->linkedin_url }}</p>
                        </div>
                    @endif
                    @if($cv->website_url)
                        <div class="break-all">
                            <p class="text-xs font-semibold text-gray-600">Website</p>
                            <p class="accent-text">{{ $cv->website_url }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Personal Info --}}
            @if($cv->date_of_birth || $cv->nationality)
                <div class="mb-6">
                    <h2 class="mb-3 text-xs font-bold uppercase tracking-wider accent-text">Personal</h2>
                    <div class="space-y-2 text-gray-700">
                        @if($cv->date_of_birth)
                            <div>
                                <p class="text-xs font-semibold text-gray-600">Date of Birth</p>
                                <p>{{ $cv->date_of_birth->format('d/m/Y') }}</p>
                            </div>
                        @endif
                        @if($cv->nationality)
                            <div>
                                <p class="text-xs font-semibold text-gray-600">Nationality</p>
                                <p>{{ $cv->nationality }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Skills --}}
            @if($cv->skills->count() > 0)
                <div class="mb-6">
                    <h2 class="mb-3 text-xs font-bold uppercase tracking-wider accent-text">Skills</h2>
                    @php
                        $groupedSkills = $cv->skills->groupBy('category');
                    @endphp
                    <div class="space-y-3">
                        @foreach($groupedSkills as $category => $skills)
                            <div>
                                <h3 class="mb-1 text-xs font-bold text-gray-700">{{ Str::title($category) }}</h3>
                                <div class="space-y-1">
                                    @foreach($skills as $skill)
                                        <div class="flex items-center justify-between text-xs">
                                            <span>{{ $skill->name }}</span>
                                            @if($skill->proficiency_level)
                                                <span class="text-gray-600">{{ $skill->proficiency_level }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Languages --}}
            @if($cv->languages->count() > 0)
                <div class="mb-6">
                    <h2 class="mb-3 text-xs font-bold uppercase tracking-wider accent-text">Languages</h2>
                    <div class="space-y-2">
                        @foreach($cv->languages as $language)
                            <div>
                                <p class="font-bold text-gray-900">{{ $language->name }}</p>
                                @if($language->pivot->is_native)
                                    <p class="text-xs text-gray-600">Native</p>
                                @else
                                    @if($language->pivot->listening)
                                        <p class="text-xs text-gray-600">{{ $language->pivot->listening }}</p>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Driving Licenses --}}
            @if($cv->driving_licenses && count($cv->driving_licenses) > 0)
                <div class="mb-6">
                    <h2 class="mb-3 text-xs font-bold uppercase tracking-wider accent-text">Driving License</h2>
                    <p class="text-gray-700">{{ implode(', ', $cv->driving_licenses) }}</p>
                </div>
            @endif
        </div>

        {{-- Main Content (70%) --}}
        <div class="w-[70%] bg-white p-8">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="mb-2 text-4xl font-bold text-gray-900">{{ $cv->first_name }} {{ $cv->last_name }}</h1>
                @if($cv->title)
                    <p class="text-xl font-medium accent-text">{{ $cv->title }}</p>
                @endif
            </div>

            {{-- About Me --}}
            @if($cv->about_me)
                <div class="mb-8 avoid-break">
                    <h2 class="mb-3 flex items-center gap-2 text-lg font-bold accent-text">
                        <span class="h-1 w-8 rounded accent-bg"></span>
                        Profile
                    </h2>
                    <p class="whitespace-pre-line leading-relaxed text-gray-700">{{ $cv->about_me }}</p>
                </div>
            @endif

            {{-- Work Experience --}}
            @if($cv->workExperiences->count() > 0)
                <div class="mb-8">
                    <h2 class="mb-4 flex items-center gap-2 text-lg font-bold accent-text">
                        <span class="h-1 w-8 rounded accent-bg"></span>
                        Work Experience
                    </h2>
                    <div class="space-y-5">
                        @foreach($cv->workExperiences as $experience)
                            <div class="avoid-break relative pl-6">
                                <div class="absolute left-0 top-1.5 h-3 w-3 rounded-full border-2 accent-border accent-bg-light"></div>
                                <div class="mb-1 flex items-start justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $experience->job_title }}</h3>
                                        <p class="font-semibold accent-text">{{ $experience->employer }}</p>
                                    </div>
                                    <div class="shrink-0 text-right text-sm text-gray-600">
                                        @if($experience->start_date)
                                            {{ $experience->start_date->format('m/Y') }} –
                                        @endif
                                        @if($experience->is_current)
                                            Present
                                        @elseif($experience->end_date)
                                            {{ $experience->end_date->format('m/Y') }}
                                        @endif
                                    </div>
                                </div>
                                @if($experience->city || $experience->country)
                                    <p class="mb-2 text-sm text-gray-600">
                                        @if($experience->city) {{ $experience->city }}, @endif
                                        {{ $experience->country }}
                                    </p>
                                @endif
                                @if($experience->description)
                                    <p class="whitespace-pre-line leading-relaxed text-gray-700">{{ $experience->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Education --}}
            @if($cv->educationEntries->count() > 0)
                <div class="mb-8">
                    <h2 class="mb-4 flex items-center gap-2 text-lg font-bold accent-text">
                        <span class="h-1 w-8 rounded accent-bg"></span>
                        Education
                    </h2>
                    <div class="space-y-5">
                        @foreach($cv->educationEntries as $education)
                            <div class="avoid-break relative pl-6">
                                <div class="absolute left-0 top-1.5 h-3 w-3 rounded-full border-2 accent-border accent-bg-light"></div>
                                <div class="mb-1 flex items-start justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $education->qualification }}</h3>
                                        @if($education->field_of_study)
                                            <p class="text-gray-700">{{ $education->field_of_study }}</p>
                                        @endif
                                        <p class="font-semibold accent-text">{{ $education->institution }}</p>
                                    </div>
                                    <div class="shrink-0 text-right text-sm text-gray-600">
                                        @if($education->start_date)
                                            {{ $education->start_date->format('m/Y') }} –
                                        @endif
                                        @if($education->is_current)
                                            Present
                                        @elseif($education->end_date)
                                            {{ $education->end_date->format('m/Y') }}
                                        @endif
                                    </div>
                                </div>
                                @if($education->city || $education->country)
                                    <p class="mb-1 text-sm text-gray-600">
                                        @if($education->city) {{ $education->city }}, @endif
                                        {{ $education->country }}
                                    </p>
                                @endif
                                @if($education->grade)
                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold">Grade:</span> {{ $education->grade }}
                                    </p>
                                @endif
                                @if($education->description)
                                    <p class="mt-1 whitespace-pre-line leading-relaxed text-gray-700">{{ $education->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Projects --}}
            @if($cv->projects->count() > 0)
                <div class="mb-8">
                    <h2 class="mb-4 flex items-center gap-2 text-lg font-bold accent-text">
                        <span class="h-1 w-8 rounded accent-bg"></span>
                        Projects
                    </h2>
                    <div class="space-y-4">
                        @foreach($cv->projects as $project)
                            <div class="avoid-break">
                                <div class="mb-1 flex items-start justify-between">
                                    <h3 class="font-bold text-gray-900">{{ $project->title }}</h3>
                                    @if($project->start_date || $project->is_ongoing || $project->end_date)
                                        <span class="shrink-0 text-sm text-gray-600">
                                            @if($project->start_date)
                                                {{ $project->start_date->format('m/Y') }} –
                                            @endif
                                            @if($project->is_ongoing)
                                                Present
                                            @elseif($project->end_date)
                                                {{ $project->end_date->format('m/Y') }}
                                            @endif
                                        </span>
                                    @endif
                                </div>
                                @if($project->role)
                                    <p class="text-sm font-semibold accent-text">{{ $project->role }}</p>
                                @endif
                                @if($project->description)
                                    <p class="mb-1 whitespace-pre-line leading-relaxed text-gray-700">{{ $project->description }}</p>
                                @endif
                                @if($project->technologies && count($project->technologies) > 0)
                                    <p class="text-sm text-gray-600">
                                        <span class="font-semibold">Tech:</span> {{ implode(', ', $project->technologies) }}
                                    </p>
                                @endif
                                @if($project->url)
                                    <p class="break-all text-sm accent-text">{{ $project->url }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Certifications --}}
            @if($cv->certifications->count() > 0)
                <div class="mb-8">
                    <h2 class="mb-4 flex items-center gap-2 text-lg font-bold accent-text">
                        <span class="h-1 w-8 rounded accent-bg"></span>
                        Certifications
                    </h2>
                    <div class="space-y-3">
                        @foreach($cv->certifications as $certification)
                            <div class="avoid-break">
                                <h3 class="font-bold text-gray-900">{{ $certification->title }}</h3>
                                <p class="font-semibold accent-text">{{ $certification->issuing_organization }}</p>
                                @if($certification->issue_date)
                                    <p class="text-sm text-gray-600">
                                        {{ $certification->issue_date->format('m/Y') }}
                                        @if($certification->expiry_date)
                                            - {{ $certification->expiry_date->format('m/Y') }}
                                        @endif
                                    </p>
                                @endif
                                @if($certification->credential_id)
                                    <p class="text-sm text-gray-600">ID: {{ $certification->credential_id }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Publications --}}
            @if($cv->publications->count() > 0)
                <div class="mb-8">
                    <h2 class="mb-4 flex items-center gap-2 text-lg font-bold accent-text">
                        <span class="h-1 w-8 rounded accent-bg"></span>
                        Publications
                    </h2>
                    <div class="space-y-3">
                        @foreach($cv->publications as $publication)
                            <div class="avoid-break">
                                <h3 class="font-bold text-gray-900">{{ $publication->title }}</h3>
                                <p class="text-sm text-gray-700">{{ $publication->authors }}</p>
                                <p class="font-semibold accent-text">{{ $publication->publication_venue }}</p>
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
                <div class="mb-8">
                    <h2 class="mb-4 flex items-center gap-2 text-lg font-bold accent-text">
                        <span class="h-1 w-8 rounded accent-bg"></span>
                        Volunteer Experience
                    </h2>
                    <div class="space-y-4">
                        @foreach($cv->volunteerExperiences as $volunteer)
                            <div class="avoid-break">
                                <div class="mb-1 flex items-start justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $volunteer->role }}</h3>
                                        <p class="font-semibold accent-text">{{ $volunteer->organization }}</p>
                                    </div>
                                    <div class="shrink-0 text-right text-sm text-gray-600">
                                        @if($volunteer->start_date)
                                            {{ $volunteer->start_date->format('m/Y') }} –
                                        @endif
                                        @if($volunteer->is_current)
                                            Present
                                        @elseif($volunteer->end_date)
                                            {{ $volunteer->end_date->format('m/Y') }}
                                        @endif
                                    </div>
                                </div>
                                @if($volunteer->city || $volunteer->country)
                                    <p class="mb-1 text-sm text-gray-600">
                                        @if($volunteer->city) {{ $volunteer->city }}, @endif
                                        {{ $volunteer->country }}
                                    </p>
                                @endif
                                @if($volunteer->description)
                                    <p class="whitespace-pre-line leading-relaxed text-gray-700">{{ $volunteer->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Footer --}}
            <div class="mt-8 border-t border-gray-300 pt-4 text-center text-xs text-gray-500">
                <p>© {{ now()->year }} {{ $cv->first_name }} {{ $cv->last_name }}. Modern CV format.</p>
            </div>
        </div>
    </div>
</body>
</html>
