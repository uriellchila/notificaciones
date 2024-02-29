<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Documento;
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
    {   return $form
        ->schema([
            Grid::make()
            ->columns(3)
            ->schema([
                Select::make('tipo_documento_id')
                    ->relationship('tipo_documento', 'nombre')
                    ->live()->preload()->selectablePlaceholder(true)->required()->dehydrated()->visibleOn('create'),
                Select::make('tipo_documento_id')
                    ->relationship('tipo_documento', 'nombre')
                    ->live()->preload()->selectablePlaceholder(true)->required()->dehydrated()->disabled()->hiddenOn('create'),
                Select::make('documento_id')->label('Numero Documento')
                    //->relationship('documento', 'numero_doc')->required(),
                    ->options(function (Get $get) {
                        return Documento::query()
                        ->where('tipo_documento_id', $get('tipo_documento_id'))
                        ->where('user_id', Auth::user()->id)
                        ->whereNotExists(function($query){$query->select(DB::raw(1))
                                            ->from('notificacion_documentos as nd')
                                            ->whereRaw('documentos.id = nd.documento_id')
                                            ->whereRaw('nd.deleted_at is null');
                                    })
                        ->whereNotExists(function($query){$query->select(DB::raw(1))
                                            ->from('devolucion_documentos as dd')
                                            ->whereRaw('documentos.id = dd.documento_id');
                                            //->whereRaw('dd.deleted_at != null');
                                    })
                        ->pluck('numero_doc','documentos.id');
                        })
                        
                        ->live()->preload()
                        ->afterStateUpdated(function (Set $set, Get $get){
                            $data = DB::table('documentos')
                                ->where('id',$get('documento_id'))                                    
                                ->get();    
                                foreach ($data as $p) { 
                                    $set('codigo',$p->codigo);
                                  } 
                        })->searchable()->visibleOn('create'),
                Select::make('documento_id')->label('Numero Documento')
                        //->relationship('documento', 'numero_doc')->required(),
                        ->options(function (Get $get) {
                            return Documento::query()
                            ->where('tipo_documento_id', $get('tipo_documento_id'))
                            ->where('user_id', Auth::user()->id)
                            ->pluck('numero_doc','documentos.id');
                            })
                            
                            ->live()->preload()
                            ->afterStateUpdated(function (Set $set, Get $get){
                                $data = DB::table('documentos')
                                    ->where('id',$get('documento_id'))                                    
                                    ->get();    
                                    foreach ($data as $p) { 
                                        $set('codigo',$p->codigo);
                                      } 
                            })->searchable()->hiddenOn('create')->disabled(),
                
                TextInput::make('codigo')->disabled(),

            ]),
            Grid::make()
            ->columns(3)
            ->schema([
                TextInput::make('cantidad_visitas')->required()->numeric()->default(1),
                Select::make('motivo_devolucion_id')
                        ->relationship('motivo_devolucion', 'nombre')
                        ->required()->live()->preload(),
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
            TextColumn::make('id')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
            TextColumn::make('tipo_documento.nombre')->sortable()->toggleable()->searchable()->label('Tipo Documento'),
            TextColumn::make('documento.numero_doc')->sortable()->toggleable()->searchable()->label('Numero Doc.'),
            TextColumn::make('documento.anyo_doc')->sortable()->toggleable()->searchable()->label('Año Doc.'),
            TextColumn::make('documento.codigo')->sortable()->toggleable()->toggleable()->label('Codigo'),
            TextColumn::make('documento.dni')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true)->label('Dni'),
            TextColumn::make('documento.razon_social')->sortable()->toggleable(isToggledHiddenByDefault: true)->label('Año Doc.'),
            TextColumn::make('documento.domicilio')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('documento.deuda_desde')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable()->label('Deuda Desde.'),
            TextColumn::make('documento.deuda_hasta')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable()->label('Deuda Hasta.'),
            TextColumn::make('cantidad_visitas')->sortable()->toggleable()->searchable()->label('N° Visitas'),
            TextColumn::make('motivo_devolucion.nombre')->sortable()->toggleable(),
            ToggleColumn::make('documento.prico')->sortable()->toggleable(isToggledHiddenByDefault: true)->label('Prico')->disabled(),
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
