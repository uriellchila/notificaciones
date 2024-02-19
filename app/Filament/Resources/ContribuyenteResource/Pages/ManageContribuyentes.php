<?php

namespace App\Filament\Resources\ContribuyenteResource\Pages;

use App\Filament\Resources\ContribuyenteResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageContribuyentes extends ManageRecords
{
    protected static string $resource = ContribuyenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
