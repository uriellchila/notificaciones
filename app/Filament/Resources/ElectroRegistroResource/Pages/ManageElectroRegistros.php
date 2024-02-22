<?php

namespace App\Filament\Resources\ElectroRegistroResource\Pages;

use App\Filament\Resources\ElectroRegistroResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageElectroRegistros extends ManageRecords
{
    protected static string $resource = ElectroRegistroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
