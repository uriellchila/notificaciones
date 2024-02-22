<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\SubTipoNotificacion;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubTipoNotificacionResource\Pages;
use App\Filament\Resources\SubTipoNotificacionResource\RelationManagers;

class SubTipoNotificacionResource extends Resource
{
    protected static ?string $model = SubTipoNotificacion::class;

    //protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Mantenimiento';
    protected static ?string $navigationLabel = 'Sub Tipo Notificacion';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tipo_notificacion_id')
                        ->relationship('tipo_notificacion', 'nombre')
                        ->required()->live()->preload(),
                TextInput::make('nombre'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tipo_notificacion.nombre'),
                TextColumn::make('nombre'),
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
            'index' => Pages\ManageSubTipoNotificacions::route('/'),
        ];
    }
}
