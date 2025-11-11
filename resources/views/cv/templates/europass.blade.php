<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cv->first_name }} {{ $cv->last_name }} - Europass CV</title>
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
    </style>
</head>
<body class="bg-white">
    <div class="mx-auto max-w-full bg-white text-sm text-gray-900 p-20">
        {{-- Header Section --}}
        <div class="mb-8 border-b-4 accent-border pb-6">
            <div class="flex items-start justify-between gap-8">
                <div class="flex-1">
                    <h1 class="mb-2 text-3xl font-bold accent-text">{{ $cv->first_name }} {{ $cv->last_name }}</h1>
                    @if($cv->title)
                        <p class="mb-4 text-lg font-semibold text-gray-700">{{ $cv->title }}</p>
                    @endif

                    <div class="space-y-1 text-gray-700">
                        @if($cv->address || $cv->city || $cv->postal_code || $cv->country)
                            <p class="flex items-start gap-2">
                                <span class="font-semibold">Address:</span>
                                <span>
                                    @if($cv->address) {{ $cv->address }}, @endif
                                    @if($cv->city) {{ $cv->city }} @endif
                                    @if($cv->postal_code) {{ $cv->postal_code }} @endif
                                    @if($cv->country) {{ $cv->country }} @endif
                                </span>
                            </p>
                        @endif
                        @if($cv->phone)
                            <p class="flex items-start gap-2">
                                <span class="font-semibold">Phone:</span>
                                <span>{{ $cv->phone }}</span>
                            </p>
                        @endif
                        @if($cv->email)
                            <p class="flex items-start gap-2">
                                <span class="font-semibold">Email:</span>
                                <span>{{ $cv->email }}</span>
                            </p>
                        @endif
                        @if($cv->linkedin_url)
                            <p class="flex items-start gap-2">
                                <span class="font-semibold">LinkedIn:</span>
                                <span class="break-all">{{ $cv->linkedin_url }}</span>
                            </p>
                        @endif
                        @if($cv->website_url)
                            <p class="flex items-start gap-2">
                                <span class="font-semibold">Website:</span>
                                <span class="break-all">{{ $cv->website_url }}</span>
                            </p>
                        @endif
                    </div>
                </div>

                @if($cv->profile_photo_path && Storage::exists($cv->profile_photo_path))
                    <div class="shrink-0">
                        @php
                            $imageData = base64_encode(Storage::get($cv->profile_photo_path));
                            $imageType = pathinfo($cv->profile_photo_path, PATHINFO_EXTENSION);
                            $imageSrc = "data:image/{$imageType};base64,{$imageData}";
                        @endphp
                        <img src="{{ $imageSrc }}" alt="Profile Photo" class="h-32 w-32 rounded-lg border-2 border-gray-300 object-cover">
                    </div>
                @endif
            </div>
        </div>

        {{-- Personal Information --}}
        <div class="mb-6">
            <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Personal Information</h2>
            <div class="grid grid-cols-2 gap-x-8 gap-y-2">
                @if($cv->date_of_birth)
                    <div>
                        <span class="font-semibold">Date of birth:</span>
                        {{ $cv->date_of_birth->format('d/m/Y') }}
                    </div>
                @endif
                @if($cv->nationality)
                    <div>
                        <span class="font-semibold">Nationality:</span>
                        {{ $cv->nationality }}
                    </div>
                @endif
                @if($cv->driving_licenses && count($cv->driving_licenses) > 0)
                    <div class="col-span-2">
                        <span class="font-semibold">Driving license:</span>
                        {{ implode(', ', $cv->driving_licenses) }}
                    </div>
                @endif
            </div>
        </div>

        {{-- About Me --}}
        @if($cv->about_me)
            <div class="mb-6">
                <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Profile</h2>
                <p class="whitespace-pre-line text-justify leading-relaxed text-gray-700">{{ $cv->about_me }}</p>
            </div>
        @endif

        {{-- Work Experience --}}
        @if($cv->workExperiences->count() > 0)
            <div class="mb-6">
                <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Work Experience</h2>
                <div class="space-y-4">
                    @foreach($cv->workExperiences as $experience)
                        <div class="avoid-break flex gap-4">
                            <div class="w-32 shrink-0 text-right text-sm font-semibold text-gray-600">
                                @if($experience->start_date)
                                    {{ $experience->start_date->format('m/Y') }} –
                                @endif
                                @if($experience->is_current)
                                    Present
                                @elseif($experience->end_date)
                                    {{ $experience->end_date->format('m/Y') }}
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">{{ $experience->job_title }}</h3>
                                <p class="mb-1 font-semibold accent-text">{{ $experience->employer }}</p>
                                @if($experience->city || $experience->country)
                                    <p class="mb-2 text-xs text-gray-600">
                                        @if($experience->city) {{ $experience->city }}, @endif
                                        {{ $experience->country }}
                                    </p>
                                @endif
                                @if($experience->description)
                                    <p class="whitespace-pre-line text-justify leading-relaxed text-gray-700">{{ $experience->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Education --}}
        @if($cv->educationEntries->count() > 0)
            <div class="mb-6">
                <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Education and Training</h2>
                <div class="space-y-4">
                    @foreach($cv->educationEntries as $education)
                        <div class="avoid-break flex gap-4">
                            <div class="w-32 shrink-0 text-right text-sm font-semibold text-gray-600">
                                @if($education->start_date)
                                    {{ $education->start_date->format('m/Y') }} –
                                @endif
                                @if($education->is_current)
                                    Present
                                @elseif($education->end_date)
                                    {{ $education->end_date->format('m/Y') }}
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">{{ $education->qualification }}</h3>
                                @if($education->field_of_study)
                                    <p class="text-gray-700">{{ $education->field_of_study }}</p>
                                @endif
                                <p class="mb-1 font-semibold accent-text">{{ $education->institution }}</p>
                                @if($education->city || $education->country)
                                    <p class="mb-2 text-xs text-gray-600">
                                        @if($education->city) {{ $education->city }}, @endif
                                        {{ $education->country }}
                                    </p>
                                @endif
                                @if($education->grade)
                                    <p class="mb-1 text-sm text-gray-700">
                                        <span class="font-semibold">Grade:</span> {{ $education->grade }}
                                    </p>
                                @endif
                                @if($education->eqf_level)
                                    <p class="mb-1 text-xs text-gray-600">EQF Level {{ $education->eqf_level }}</p>
                                @endif
                                @if($education->description)
                                    <p class="mt-2 whitespace-pre-line text-justify leading-relaxed text-gray-700">{{ $education->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Languages --}}
        @if($cv->languages->count() > 0)
            <div class="mb-6">
                <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Language Skills</h2>
                <div class="space-y-3">
                    @foreach($cv->languages as $language)
                        <div>
                            <h3 class="mb-1 font-bold text-gray-900">{{ $language->name }}</h3>
                            @if($language->pivot->is_native)
                                <p class="text-sm text-gray-700">Native language</p>
                            @else
                                <div class="grid grid-cols-5 gap-2 text-xs">
                                    @if($language->pivot->listening)
                                        <div>
                                            <span class="font-semibold">Listening:</span> {{ $language->pivot->listening }}
                                        </div>
                                    @endif
                                    @if($language->pivot->reading)
                                        <div>
                                            <span class="font-semibold">Reading:</span> {{ $language->pivot->reading }}
                                        </div>
                                    @endif
                                    @if($language->pivot->spoken_interaction)
                                        <div>
                                            <span class="font-semibold">Interaction:</span> {{ $language->pivot->spoken_interaction }}
                                        </div>
                                    @endif
                                    @if($language->pivot->spoken_production)
                                        <div>
                                            <span class="font-semibold">Production:</span> {{ $language->pivot->spoken_production }}
                                        </div>
                                    @endif
                                    @if($language->pivot->writing)
                                        <div>
                                            <span class="font-semibold">Writing:</span> {{ $language->pivot->writing }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @if($language->pivot->certificates)
                                <p class="mt-1 text-xs text-gray-600">
                                    <span class="font-semibold">Certificates:</span> {{ $language->pivot->certificates }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                    <p class="mt-3 text-xs text-gray-500">Levels: A1/A2: Basic user - B1/B2: Independent user - C1/C2: Proficient user</p>
                </div>
            </div>
        @endif

        {{-- Skills --}}
        @if($cv->skills->count() > 0)
            <div class="mb-6">
                <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Skills</h2>
                @php
                    $groupedSkills = $cv->skills->groupBy('category');
                @endphp
                <div class="space-y-3">
                    @foreach($groupedSkills as $category => $skills)
                        <div>
                            <h3 class="mb-1 font-bold text-gray-900">{{ Str::title($category) }}</h3>
                            <div class="flex flex-wrap gap-x-4 gap-y-1">
                                @foreach($skills as $skill)
                                    <div class="text-gray-700">
                                        <span class="font-semibold">{{ $skill->name }}</span>
                                        @if($skill->proficiency_level)
                                            <span class="text-xs text-gray-600">({{ $skill->proficiency_level }})</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Certifications --}}
        @if($cv->certifications->count() > 0)
            <div class="mb-6">
                <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Certifications</h2>
                <div class="space-y-3">
                    @foreach($cv->certifications as $certification)
                        <div class="avoid-break">
                            <h3 class="font-bold text-gray-900">{{ $certification->title }}</h3>
                            <p class="text-sm font-semibold accent-text">{{ $certification->issuing_organization }}</p>
                            @if($certification->issue_date)
                                <p class="text-xs text-gray-600">
                                    Issued: {{ $certification->issue_date->format('m/Y') }}
                                    @if($certification->expiry_date)
                                        - Expires: {{ $certification->expiry_date->format('m/Y') }}
                                    @endif
                                </p>
                            @endif
                            @if($certification->credential_id)
                                <p class="text-xs text-gray-600">Credential ID: {{ $certification->credential_id }}</p>
                            @endif
                            @if($certification->credential_url)
                                <p class="break-all text-xs accent-text">{{ $certification->credential_url }}</p>
                            @endif
                            @if($certification->description)
                                <p class="mt-1 text-sm text-gray-700">{{ $certification->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Projects --}}
        @if($cv->projects->count() > 0)
            <div class="mb-6">
                <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Projects</h2>
                <div class="space-y-4">
                    @foreach($cv->projects as $project)
                        <div class="avoid-break">
                            <div class="mb-1 flex items-start justify-between">
                                <h3 class="font-bold text-gray-900">{{ $project->title }}</h3>
                                @if($project->start_date || $project->is_ongoing || $project->end_date)
                                    <span class="shrink-0 text-xs text-gray-600">
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
                                <p class="mb-2 whitespace-pre-line text-justify leading-relaxed text-gray-700">{{ $project->description }}</p>
                            @endif
                            @if($project->technologies && count($project->technologies) > 0)
                                <p class="text-xs text-gray-600">
                                    <span class="font-semibold">Technologies:</span> {{ implode(', ', $project->technologies) }}
                                </p>
                            @endif
                            @if($project->url)
                                <p class="break-all text-xs accent-text">{{ $project->url }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Publications --}}
        @if($cv->publications->count() > 0)
            <div class="mb-6">
                <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Publications</h2>
                <div class="space-y-3">
                    @foreach($cv->publications as $publication)
                        <div class="avoid-break">
                            <h3 class="font-bold text-gray-900">{{ $publication->title }}</h3>
                            <p class="text-sm text-gray-700">{{ $publication->authors }}</p>
                            <p class="text-sm font-semibold accent-text">{{ $publication->publication_venue }}</p>
                            @if($publication->publication_type || $publication->publication_date)
                                <p class="text-xs text-gray-600">
                                    @if($publication->publication_type)
                                        {{ $publication->publication_type }}
                                    @endif
                                    @if($publication->publication_type && $publication->publication_date)
                                        -
                                    @endif
                                    @if($publication->publication_date)
                                        {{ $publication->publication_date->format('Y') }}
                                    @endif
                                </p>
                            @endif
                            @if($publication->doi)
                                <p class="text-xs text-gray-600">DOI: {{ $publication->doi }}</p>
                            @endif
                            @if($publication->url)
                                <p class="break-all text-xs accent-text">{{ $publication->url }}</p>
                            @endif
                            @if($publication->description)
                                <p class="mt-1 text-sm text-gray-700">{{ $publication->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Volunteer Experience --}}
        @if($cv->volunteerExperiences->count() > 0)
            <div class="mb-6">
                <h2 class="mb-3 border-b-2 accent-border pb-1 text-xl font-bold accent-text">Volunteer Experience</h2>
                <div class="space-y-4">
                    @foreach($cv->volunteerExperiences as $volunteer)
                        <div class="avoid-break flex gap-4">
                            <div class="w-32 shrink-0 text-right text-sm font-semibold text-gray-600">
                                @if($volunteer->start_date)
                                    {{ $volunteer->start_date->format('m/Y') }} –
                                @endif
                                @if($volunteer->is_current)
                                    Present
                                @elseif($volunteer->end_date)
                                    {{ $volunteer->end_date->format('m/Y') }}
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">{{ $volunteer->role }}</h3>
                                <p class="mb-1 font-semibold accent-text">{{ $volunteer->organization }}</p>
                                @if($volunteer->city || $volunteer->country)
                                    <p class="mb-2 text-xs text-gray-600">
                                        @if($volunteer->city) {{ $volunteer->city }}, @endif
                                        {{ $volunteer->country }}
                                    </p>
                                @endif
                                @if($volunteer->description)
                                    <p class="whitespace-pre-line text-justify leading-relaxed text-gray-700">{{ $volunteer->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Footer --}}
        <div class="mt-8 border-t border-gray-300 pt-4 text-center text-xs text-gray-500">
            <p>© {{ now()->year }} {{ $cv->first_name }} {{ $cv->last_name }}. Europass CV format.</p>
        </div>
    </div>
</body>
</html>
