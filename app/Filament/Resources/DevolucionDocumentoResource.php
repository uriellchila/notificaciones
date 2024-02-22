<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use App\Models\DevolucionDocumento;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\DevolucionDocumentoResource\Pages;
use App\Filament\Resources\DevolucionDocumentoResource\RelationManagers;
use App\Filament\Resources\DevolucionDocumentoResource\Pages\ManageDevolucionDocumentos;

class DevolucionDocumentoResource extends Resource
{
    protected static ?string $model = DevolucionDocumento::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                ->columns(2)
                ->schema([
                    Select::make('contribuyente_id')
                        ->relationship('contribuyente', 'codigo')
                        ->required()->live()->searchable()
                        ->afterStateUpdated(function (Set $set, Get $get){
                            $data = DB::table('contribuyentes')
                                //->select('ap_paterno','ap_materno','nombres')
                                ->where('id',$get('contribuyente_id'))
                                ->get();    
                                foreach ($data as $p) { 
                                    $set('codigo',$p->codigo);
                                    $set('dni',$p->dni_ruc);
                                    $set('razon_social',$p->razon_social);
                                    $set('domicilio',$p->domicilio);
                                } 
                        }),//->optionsLimit(20),                   
                    Hidden::make('codigo')->required(),
                    Hidden::make('dni')->required(),
                    TextInput::make('razon_social')->required()->disabled()->dehydrated(),
                    Hidden::make('domicilio')->required(),
                    

                    ]),
                Grid::make()
                ->columns(3)
                ->schema([
                    Select::make('tipo_documento_id')
                        ->relationship('tipo_documento', 'nombre')
                        ->live()->preload()->selectablePlaceholder(true)->required()->dehydrated(),
                    TextInput::make('numero_doc')->required()->numeric()->label('Numero Documento'),
                    TextInput::make('anyo')->required()->label('Periodo')->default(date('Y'))->disabled()->dehydrated(),
                    

                ]),
                Grid::make()
                ->columns(3)
                ->schema([
                    TextInput::make('cantidad_visitas')->required()->numeric()->default(1),
                    Select::make('motivo_devolucion_id')
                        ->relationship('motivo_devolucion', 'nombre')
                        ->required()->live()->preload(),
                    Toggle::make('prico'),
                    
                ]),
                Grid::make()
                ->columns(1)
                ->schema([
                    
                    TextInput::make('observaciones'),
                   
                    
                    Hidden::make('user_id')->default(Auth::user()->id),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->query(DevolucionDocumento::query()->where('user_id',Auth::user()->id))
            ->columns([
                //TextColumn::make('contribuyente.codigo')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('tipo_documento')->relationship('tipo_documento', 'nombre'),
                SelectFilter::make('motivo_devolucion')->relationship('motivo_devolucion', 'nombre'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDevolucionDocumentos::route('/'),
        ];
    }
}
