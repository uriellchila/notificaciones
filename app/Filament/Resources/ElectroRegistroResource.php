<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ElectroRegistro;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ElectroRegistroResource\Pages;
use App\Filament\Resources\ElectroRegistroResource\RelationManagers;

class ElectroRegistroResource extends Resource
{
    protected static ?string $model = ElectroRegistro::class;

    //protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Base Direcciones';
    //protected static ?string $navigationLabel = 'Tipo Documento';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->query(ElectroRegistro::query()->orderBy('razon_social', 'asc'))
            ->columns([
                TextColumn::make('dni')->sortable()->toggleable()->searchable(),
                TextColumn::make('razon_social')->sortable()->toggleable()->searchable(),
                TextColumn::make('direccion')->sortable()->toggleable()->searchable(),
                TextColumn::make('codigo_suministro')->sortable()->toggleable()->searchable(),
                TextColumn::make('serie_medidor')->sortable()->toggleable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
               // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                //]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageElectroRegistros::route('/'),
        ];
    }
}
