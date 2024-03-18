<?php

namespace App\Filament\Resources\NotificacionDocumentoResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\NotificacionDocumentoResource;
use App\Filament\Resources\DocumentoResource\Widgets\DocumentosNotificadosTable;

class ManageNotificacionDocumentos extends ManageRecords
{
    protected static string $resource = NotificacionDocumentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Registro Notificacion'),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            //DocumentosAsignarTable::class,
            DocumentosNotificadosTable::class,
            //NotificadoresChart::class,
        ];
    }
}
