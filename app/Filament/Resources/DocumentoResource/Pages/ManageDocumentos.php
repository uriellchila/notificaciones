<?php

namespace App\Filament\Resources\DocumentoResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\DocumentoResource;
use App\Filament\Resources\DocumentoResource\Widgets\DocumentosAsignarTable;

class ManageDocumentos extends ManageRecords
{
    protected static string $resource = DocumentoResource::class;

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
            //NotificadoresChart::class,
        ];
    }
}
