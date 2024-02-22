<?php

namespace App\Filament\Resources\SubTipoNotificacionResource\Pages;

use App\Filament\Resources\SubTipoNotificacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSubTipoNotificacions extends ManageRecords
{
    protected static string $resource = SubTipoNotificacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
