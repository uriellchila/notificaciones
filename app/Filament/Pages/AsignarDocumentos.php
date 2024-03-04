<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\DocumentoResource\Widgets\DocumentosAsignarTable;

class AsignarDocumentos extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.asignar-documentos';
    protected static ?string $navigationLabel = 'Asignar';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Asignar';
    //protected static ?string $navigationGroup = 'Documentos';

    protected function getHeaderWidgets(): array
    {
    return [
        DocumentosAsignarTable::class
    ];
    }
    /*public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }*/
}
