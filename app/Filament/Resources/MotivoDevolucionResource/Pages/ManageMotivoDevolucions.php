<?php

namespace App\Filament\Resources\MotivoDevolucionResource\Pages;

use App\Filament\Resources\MotivoDevolucionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMotivoDevolucions extends ManageRecords
{
    protected static string $resource = MotivoDevolucionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
