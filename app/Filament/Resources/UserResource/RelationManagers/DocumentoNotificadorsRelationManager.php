<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class DocumentoNotificadorsRelationManager extends RelationManager
{
    protected static string $relationship = 'documento_notificadors';
    protected static ?string $label = 'sss';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('codigo')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('codigo')
            ->columns([
                Tables\Columns\TextColumn::make('codigo'),
                Tables\Columns\TextColumn::make('codigo')->sortable()->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('dni')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('razon_social')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('domicilio')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tipo_documento.nombre')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('numero_doc')->sortable()->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('numero_acuse')->sortable()->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('tipo_notificacion.nombre')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('fecha_notificacion')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('user.name')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true)->label('Notificador'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                ]),
            ]);
    }
}
