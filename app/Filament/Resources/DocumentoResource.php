<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Documento;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DocumentoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DocumentoResource\RelationManagers;

class DocumentoResource extends Resource
{
    protected static ?string $model = Documento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        
        ->schema([
            
            Grid::make()
            ->columns(4)
            ->schema([
                Select::make('tipo_documento_id')->relationship('tipo_documento', 'nombre')->required(), 
                TextInput::make('numero_doc')->numeric()->required()->suffix(date('Y')),
                Hidden::make('anyo_doc')->required()->default(date('Y'))->disabled()->dehydrated(),
                TextInput::make('deuda_desde')->numeric()->required()->default('2024'),
                TextInput::make('deuda_hasta')->numeric()->required()->default('2024'),  
            ]),
            Grid::make()
            ->columns(3)
            ->schema([
                TextInput::make('codigo')->required(),
                TextInput::make('razon_social')->required(),
                TextInput::make('domicilio')->required(),
                
            ]),
            Grid::make()
            ->columns(2)
            ->schema([
                Select::make('user_id')->relationship('user', 'name')->required(),
                Toggle::make('prico'),
             ]),
            
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocumentos::route('/'),
            'create' => Pages\CreateDocumento::route('/create'),
            'edit' => Pages\EditDocumento::route('/{record}/edit'),
        ];
    }
}
