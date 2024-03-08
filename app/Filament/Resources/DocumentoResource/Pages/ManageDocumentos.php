<?php

namespace App\Filament\Resources\DocumentoResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\DocumentoResource;
use App\Filament\Resources\DocumentoResource\Widgets\DocumentosAsignarTable;
use App\Filament\Resources\DocumentoResource\Widgets\DocumentosAsignadosTable;

class ManageDocumentos extends ManageRecords
{
    protected static string $resource = DocumentoResource::class;
    protected static string $routePath = 'finance';
    protected function getHeaderActions(): array
    {
        return [
           Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            DocumentosAsignarTable::class,
            DocumentosAsignadosTable::class,
            //NotificadoresChart::class,
        ];
    }
}
