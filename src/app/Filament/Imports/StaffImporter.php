<?php

namespace App\Filament\Imports;

use App\Models\Staff;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class StaffImporter extends Importer
{
    protected static ?string $model = Staff::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('first_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('last_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('preferred_name')
                ->rules(['max:255']),
            ImportColumn::make('email')
                ->rules(['email', 'max:255']),
            ImportColumn::make('phone_number')
                ->rules(['max:255']),
            ImportColumn::make('date_of_birth')
                ->rules(['date']),
            ImportColumn::make('home_address')
                ->requiredMapping()
                ->rules(['required', 'max:65535']),
            ImportColumn::make('city')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('country')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('profile_photo')
                ->rules(['max:255']),
            ImportColumn::make('hire_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('department')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('position')
                ->rules(['max:255']),
            ImportColumn::make('notice_period')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Staff
    {
        // return Staff::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Staff();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your staff import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
