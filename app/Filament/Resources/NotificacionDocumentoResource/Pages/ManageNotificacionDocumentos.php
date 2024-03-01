<?php

namespace App\Filament\Resources\NotificacionDocumentoResource\Pages;

use App\Filament\Resources\NotificacionDocumentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageNotificacionDocumentos extends ManageRecords
{
    protected static string $resource = NotificacionDocumentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Registro Notificacion'),
        ];
    }
}
