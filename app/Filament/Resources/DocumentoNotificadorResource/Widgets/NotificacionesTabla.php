<?php

namespace App\Filament\Resources\DocumentoNotificadorResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\DocumentoNotificador;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget as BaseWidget;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class NotificacionesTabla extends BaseWidget
{   
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                DocumentoNotificador::query()
            )
            ->columns([
                TextColumn::make('codigo')->sortable()->toggleable()->searchable(),
                TextColumn::make('dni')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('razon_social')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('domicilio')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tipo_documento.nombre')->sortable()->toggleable(),
                TextColumn::make('numero_doc')->sortable()->toggleable()->searchable(),
                TextColumn::make('numero_acuse')->sortable()->toggleable()->searchable(),
                TextColumn::make('tipo_notificacion.nombre')->sortable()->toggleable(),
                TextColumn::make('fecha_notificacion')->sortable()->toggleable(),
                TextColumn::make('user.name')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: false)->label('Notificador'),
            ])
            ->filters([

                SelectFilter::make('user')->relationship('user', 'name'),
                SelectFilter::make('tipo_documento')->relationship('tipo_documento', 'nombre'),
                SelectFilter::make('tipo_notificacion')->relationship('tipo_notificacion', 'nombre'),

            ])
            ->actions([
                //Tables\Actions\ViewAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                //Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                    //ExportBulkAction::make()
                //]),
            ]);
    }
}
