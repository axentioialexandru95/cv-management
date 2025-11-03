<?php

namespace App\Filament\Resources\CVS;

use App\Filament\Resources\CVS\Pages\CreateCV;
use App\Filament\Resources\CVS\Pages\EditCV;
use App\Filament\Resources\CVS\Pages\ListCVS;
use App\Filament\Resources\CVS\Schemas\CVForm;
use App\Filament\Resources\CVS\Tables\CVSTable;
use App\Models\CV;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CVResource extends Resource
{
    protected static ?string $model = CV::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'CVs';

    protected static ?string $modelLabel = 'CV';

    protected static ?string $pluralModelLabel = 'CVs';

    protected static string|UnitEnum|null $navigationGroup = 'CV Management';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CVForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CVSTable::configure($table);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'first_name', 'last_name', 'email'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Owner' => trim("{$record->first_name} {$record->last_name}"),
            'Email' => $record->email,
            'Status' => $record->is_active ? 'Active' : 'Inactive',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id())
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\WorkExperiencesRelationManager::class,
            RelationManagers\EducationEntriesRelationManager::class,
            RelationManagers\LanguagesRelationManager::class,
            RelationManagers\SkillsRelationManager::class,
            RelationManagers\CertificationsRelationManager::class,
            RelationManagers\ProjectsRelationManager::class,
            RelationManagers\PublicationsRelationManager::class,
            RelationManagers\VolunteerExperiencesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCVS::route('/'),
            'create' => CreateCV::route('/create'),
            'edit' => EditCV::route('/{record}/edit'),
        ];
    }
}
