<?php

namespace App\Filament\Resources\DevolucionDocumentoResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\DevolucionDocumento;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget as BaseWidget;

class DevolucionDocumentosTable extends BaseWidget
{   
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Documentos Devueltos';
    public function table(Table $table): Table
    
    {
        return $table
        
            ->query(
                DevolucionDocumento::query()
            )
            ->columns([
                TextColumn::make('codigo')->sortable()->toggleable()->searchable(),
                TextColumn::make('dni')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('razon_social')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('domicilio')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tipo_documento.nombre')->sortable()->toggleable(),
                TextColumn::make('numero_doc')->sortable()->toggleable()->searchable(),
                TextColumn::make('cantidad_visitas')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('motivo_devolucion.nombre')->sortable()->toggleable(),
                ToggleColumn::make('prico')->sortable()->toggleable(),
                TextColumn::make('user.name')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true)->label('Notificador'),
            ])
            ->filters([

                SelectFilter::make('user')->relationship('user', 'name'),
                SelectFilter::make('tipo_documento')->relationship('tipo_documento', 'nombre'),
                SelectFilter::make('motivo_devolucion')->relationship('motivo_devolucion', 'nombre'),

            ]);
    }
    
}
