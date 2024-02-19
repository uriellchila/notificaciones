<?php

namespace App\Filament\Resources\DocumentoNotificadorResource\Pages;

use App\Filament\Resources\DocumentoNotificadorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDocumentoNotificadors extends ManageRecords
{
    protected static string $resource = DocumentoNotificadorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
