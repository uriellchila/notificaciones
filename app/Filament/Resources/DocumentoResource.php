<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Documento;
use Filament\Tables\Table;
use App\Models\Contribuyente;
use Tables\Actions\BulkAction;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use RelationManagers\UserRelationManager;
use RelationManagers\UsersRelationManager;
use Illuminate\Database\Eloquent\Collection;
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
            ->columns(5)
            ->schema([
                Select::make('tipo_documento_id')->relationship('tipo_documento', 'nombre')->required(), 
                TextInput::make('numero_doc')->numeric()->required()->suffix(date('Y')),
                Hidden::make('anyo_doc')->required()->default(date('Y'))->disabled()->dehydrated(),
                TextInput::make('deuda_desde')->numeric()->required()->default('2024'),
                TextInput::make('deuda_hasta')->numeric()->required()->default('2024'),  
                TextInput::make('deuda_ip')->numeric()->required(),  
            ]),
            Grid::make()
            ->columns(3)
            ->schema([
                TextInput::make('codigo')->required()
                ->live()
                ->afterStateUpdated(
                    function (Set $set, Get $get) {
                        $set('razon_social', '');
                        $set('domicilio', '');
                        $idc =  Contribuyente::select('razon_social', 'domicilio')
                        ->where('contribuyentes.codigo', $get('codigo'))
                        ->first();
                        $set('razon_social', $idc->razon_social);
                        $set('domicilio', $idc->domicilio);
                        
                    }),
                TextInput::make('razon_social')->required(),
                TextInput::make('domicilio')->required(),
                
            ]),
            Grid::make()
            ->columns(2)
            ->schema([
                Select::make('user_id')->relationship('user', 'name'),
                
                Toggle::make('prico'),
             ]),
            
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tipo_documento.nombre')->sortable()->toggleable()->searchable(),
                TextColumn::make('numero_doc')->sortable()->toggleable()->searchable(),
                TextColumn::make('anyo_doc')->sortable()->toggleable()->searchable(),
                TextColumn::make('deuda_desde')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('deuda_hasta')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('deuda_ip')->sortable()->toggleable()->searchable(),
                TextColumn::make('codigo')->sortable()->toggleable()->searchable(),
                TextColumn::make('razon_social')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('domicilio')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('user.name')->sortable()->toggleable()->label('notificador')->searchable(),
            ])
            ->filters([
                //
            ])
            ->selectable()
       
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Asig. Notificador')
                ->form([
                    Select::make('user_id')
                        ->label('Asignar Notificador')
                        ->options(User::query()->pluck('name', 'id')),
                        //->required(),
                ])
                ->action(function (array $data, Documento $record): void {
                    $record->user()->associate($data['user_id']);
                    $record->save();
                })
            ])
            ->headerActions([
                // ...
                Tables\Actions\AttachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    /*Tables\Actions\AttachAction::make()
                    ->recordSelect(function (Select $select) {
                        return $select->multiple();
                    })
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('user_id')->required(),
                    ]),*/
                ]),
                Tables\Actions\BulkAction::make('Asignar Notificador')
                //->accessSelectedRecords()
                ->action(function (array $data,Documento $record, Collection $records) {
                    $records->each(
                        fn (Documento $record) => $record->update([
                            'user_id' => $data['user_id'],
                        ]),
                    );
                })
                ->form([
                    Forms\Components\Select::make('user_id')
                        ->label('Notificador')
                        ->options(User::query()->pluck('name', 'id')),
                        //->required(),
                ])
                    //->action(fn (Collection $records) => $records->each->update())
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //RelationManagers\UsersRelationManager::class,
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
