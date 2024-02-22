<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\EmsaRegistro;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmsaRegistroResource\Pages;
use App\Filament\Resources\EmsaRegistroResource\RelationManagers;

class EmsaRegistroResource extends Resource
{
    protected static ?string $model = EmsaRegistro::class;

    //protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Base Direcciones';
    //protected static ?string $navigationLabel = 'Tipo Documento';
    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->query(EmsaRegistro::query()->orderBy('razon_social', 'asc'))
            ->columns([
                TextColumn::make('dni')->sortable()->toggleable()->searchable(isIndividual: true),
                TextColumn::make('razon_social')->sortable()->toggleable()->searchable(isIndividual: true),
                TextColumn::make('direccion')->sortable()->toggleable()->searchable(isIndividual: true),
                TextColumn::make('numero')->sortable()->toggleable()->searchable(isIndividual: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\BulkActionGroup::make([
                 //   Tables\Actions\DeleteBulkAction::make(),
                //]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEmsaRegistros::route('/'),
        ];
    }
}
