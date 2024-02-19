<?php

namespace App\Filament\Resources\TipoNotificacionResource\Pages;

use App\Filament\Resources\TipoNotificacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTipoNotificacions extends ManageRecords
{
    protected static string $resource = TipoNotificacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
