<?php

namespace App\Filament\Resources\EmsaRegistroResource\Pages;

use App\Filament\Resources\EmsaRegistroResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmsaRegistros extends ManageRecords
{
    protected static string $resource = EmsaRegistroResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }
}
