<?php

namespace App\Filament\Resources\DocumentoNotificadorResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\DocumentoNotificadorResource;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\Notificaciones;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\NotificadoresChart;

class ManageDocumentoNotificadors extends ManageRecords
{
    protected static string $resource = DocumentoNotificadorResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Registrar Notificacion'),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            Notificaciones::class,
            //NotificadoresChart::class,
        ];
    }
}
