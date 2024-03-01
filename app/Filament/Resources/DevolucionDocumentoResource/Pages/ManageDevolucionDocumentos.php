<?php

namespace App\Filament\Resources\DevolucionDocumentoResource\Pages;

use App\Filament\Resources\DevolucionDocumentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDevolucionDocumentos extends ManageRecords
{
    protected static string $resource = DevolucionDocumentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Registrar Devolucion'),
        ];
    }
}
