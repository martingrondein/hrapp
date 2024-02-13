<?php

namespace App\Filament\Resources;

use Filament\Forms;

use Filament\Tables;
use App\Models\Staff;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;
// use App\Filament\Resources\StaffResource\RelationManagers;
use App\Filament\Exports\StaffExporter;
use App\Filament\Imports\StaffImporter;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Actions\Exports\Models\Export;
use App\Filament\Resources\StaffResource\Pages;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Actions\ExportBulkAction;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Staff Information')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                Fieldset::make('Personal Information')
                                    ->schema([
                                        Forms\Components\TextInput::make('first_name')->required()->autocapitalize('words')->maxLength(255),
                                        Forms\Components\TextInput::make('last_name')->required()->autocapitalize('words')->maxLength(255),
                                        Forms\Components\TextInput::make('preferred_name')->autocapitalize('words')->maxLength(255),
                                        Forms\Components\TextInput::make('email')->email()->maxLength(255),
                                        Forms\Components\TextInput::make('phone_number')->tel()->maxLength(255),
                                        Forms\Components\DatePicker::make('date_of_birth')->required()->maxDate(now()),
                                        Forms\Components\Textarea::make('home_address')->rows(5),
                                        Forms\Components\TextInput::make('city')->maxLength(255),
                                        Forms\Components\TextInput::make('country')->maxLength(255),
                                    ])
                                    ->columns(3),

                                Fieldset::make('Company Information')
                                    ->schema([
                                        Forms\Components\DatePicker::make('hire_date')->required()->maxDate(now()),
                                        Forms\Components\Select::make('department_id')->options(Department::all()->pluck('department_name', 'id')),
                                        Forms\Components\TextInput::make('position')->maxLength(255),
                                        Forms\Components\TextInput::make('notice_period')->numeric()->maxLength(255),
                                    ])
                                    ->columns(3)
                            ]),
                        Tabs\Tab::make('Documents')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Leave')
                            ->icon('heroicon-s-calendar')
                            ->schema([
                                // ...
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpan('full'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('last_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('department.department_name')->label('Department')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('position')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('years_employed')->badge()->color(fn (string $state): string => match ($state) {
                    '0 year(s)' => 'gray',
                    '1 year(s)' => 'warning',
                    default => 'success',
                }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_id')->label('Department')->options(Department::all()->pluck('department_name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(StaffImporter::class)
                    ->label('Import')
                    ->icon('heroicon-o-bars-arrow-up'),
                ExportAction::make()
                    ->exporter(StaffExporter::class)
                    ->label('Export')
                    ->icon('heroicon-o-bars-arrow-down')
                    ->formats([
                        ExportFormat::Csv,
                    ])->action(function (Staff $record) {
                        return $record->id;
                    }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(StaffExporter::class)
                        ->label('Export Selected')
                        ->icon('heroicon-o-bars-arrow-down')
                        ->formats([
                            ExportFormat::Csv
                        ]),
                ]),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
        ];
    }
}
