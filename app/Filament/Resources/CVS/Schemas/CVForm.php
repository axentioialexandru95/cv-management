<?php

namespace App\Filament\Resources\CVS\Schemas;

use App\Enums\CVTemplate;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class CVForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Hidden::make('user_id')
                    ->default(fn () => Auth::id()),

                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('CV Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('e.g., Senior Software Engineer CV'),

                        Select::make('template_id')
                            ->label('Template')
                            ->options(CVTemplate::options())
                            ->required()
                            ->default(CVTemplate::EUROPASS->value)
                            ->reactive()
                            ->helperText('Choose the visual style for your CV')
                            ->native(false)
                            ->columnSpan(2),

                        ColorPicker::make('accent_color')
                            ->label('Accent Color')
                            ->default(fn ($get) => CVTemplate::tryFrom($get('template_id') ?? 'europass')?->defaultColor() ?? '#2563eb')
                            ->helperText('Choose the primary color for headings, borders, and accents')
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->columnSpan(2)
                            ->helperText('Inactive CVs will not be visible for export.'),

                        Toggle::make('is_public')
                            ->label('Public')
                            ->default(false)
                            ->columnSpan(1)
                            ->reactive()
                            ->helperText('Allow anyone with the link to view this CV.'),

                        TextInput::make('public_url')
                            ->label('Public URL')
                            ->disabled()
                            ->columnSpanFull()
                            ->dehydrated(false)
                            ->formatStateUsing(fn ($get, $record) => $get('is_public') && $record?->public_slug
                                ? $record->public_url
                                : 'Enable "Public" toggle to generate a shareable link')
                            ->helperText(fn ($get) => $get('is_public')
                                ? 'Share this link to allow others to view your CV. Click the copy icon to copy to clipboard.'
                                : 'Toggle "Public" on to make this CV accessible via a unique link.')
                            ->copyable(fn ($get, $record) => $get('is_public') && $record?->public_slug),
                    ])
                    ->columnSpan(3)
                    ->collapsible(),

                Section::make('Personal Information')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),

                        DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        TextInput::make('nationality')
                            ->maxLength(255),

                        FileUpload::make('profile_photo_path')
                            ->label('Profile Photo')
                            ->image()
                            ->imageEditor()
                            ->directory('profile-photos')
                            ->visibility('private')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(3)
                    ->collapsible(),

                Section::make('Contact Information')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),

                        Textarea::make('address')
                            ->rows(2)
                            ->columnSpanFull(),

                        TextInput::make('city')
                            ->maxLength(255),

                        TextInput::make('postal_code')
                            ->maxLength(255),

                        TextInput::make('country')
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->columnSpan(3)
                    ->collapsible(),

                Section::make('Online Presence')
                    ->schema([
                        TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://linkedin.com/in/username'),

                        TextInput::make('website_url')
                            ->label('Personal Website')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://yourwebsite.com'),
                    ])
                    ->columns(2)
                    ->columnSpan(3)
                    ->collapsible(),

                Section::make('About')
                    ->schema([
                        Textarea::make('about_me')
                            ->label('About Me')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('A brief introduction about yourself and your professional background.'),
                    ])
                    ->columnSpan(3)
                    ->collapsible(),

                Section::make('Driving Licenses')
                    ->schema([
                        Repeater::make('driving_licenses')
                            ->label('')
                            ->simple(
                                TextInput::make('license')
                                    ->label('License Type')
                                    ->placeholder('e.g., B, C, D')
                                    ->required()
                            )
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Add License'),
                    ])
                    ->columnSpan(3)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
