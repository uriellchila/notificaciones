<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use App\Models\DocumentoNotificador;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DocumentoNotificadorResource\Pages;
use App\Filament\Resources\DocumentoNotificadorResource\RelationManagers;

class DocumentoNotificadorResource extends Resource
{
    protected static ?string $model = DocumentoNotificador::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                ->columns(2)
                ->schema([
                    Select::make('contribuyente_id')
                        ->relationship('contribuyente', 'codigo')
                        ->required()->live()->preload()->searchable()
                        ->afterStateUpdated(function (Set $set){

                        }),                   
                    TextInput::make('codigo')->required(),
                    TextInput::make('dni_ruc')->required(),
                    TextInput::make('razon_social')->required(),
                    TextInput::make('domicilio')->required(),
                    Select::make('tipo_documento_id')
                        ->relationship('tipo_documento', 'nombre')
                        ->required()->live()->preload()->searchable(),
                    TextInput::make('numero_doc')->required(),
                    TextInput::make('numero_acuse')->required(),
                    Select::make('tipo_notificacion_id')
                        ->relationship('tipo_notificacion', 'nombre')
                        ->required()->live()->preload()->searchable(),
                    DatePicker::make('fecha_notificacion'),
                    TextInput::make('observaciones'),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDocumentoNotificadors::route('/'),
        ];
    }
}
