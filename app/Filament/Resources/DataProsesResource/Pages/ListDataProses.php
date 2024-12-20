<?php

namespace App\Filament\Resources\DataProsesResource\Pages;

use App\Filament\Resources\DataProsesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataProses extends ListRecords
{
    protected static string $resource = DataProsesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
