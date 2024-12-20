<?php

namespace App\Filament\Resources\DataProsesResource\Pages;

use App\Filament\Resources\DataProsesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataProses extends EditRecord
{
    protected static string $resource = DataProsesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
