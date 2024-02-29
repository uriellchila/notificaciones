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
use App\Models\SubTipoNotificacion;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NotificacionDocumentoResource\Pages;
use App\Filament\Resources\NotificacionDocumentoResource\RelationManagers;

class NotificacionDocumentoResource extends Resource
{
    protected static ?string $model = NotificacionDocumento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
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
                    TextInput::make('numero_acuse')->required()->numeric(),
                    Select::make('tipo_notificacion_id')
                        ->relationship('tipo_notificacion', 'nombre')
                        ->required()->live()->preload(),
                    
                ]),
                Grid::make()
                ->columns(3)
                ->schema([
                    Select::make('sub_tipo_notificacion_id')
                        ->options(function (Get $get) {
                            return SubTipoNotificacion::query()
                            ->where('tipo_notificacion_id', $get('tipo_notificacion_id'))
                            ->pluck('nombre', 'id');
                        })
                        ->live()->preload()
                        ->visible(
                            function(Get $get){
                                if (SubTipoNotificacion::query()->where('tipo_notificacion_id', $get('tipo_notificacion_id'))->count()>0)
                                 {
                                    
                                    return true;
                                    
                                } else {
                                    return false;
                                }
                            }
                        ),
                    DatePicker::make('fecha_notificacion')->required(),
                    TextInput::make('telefono_contacto'),
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
            ->query(NotificacionDocumento::query()->where('user_id',Auth::user()->id))
            ->columns([
                //TextColumn::make('contribuyente.codigo')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('id')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable(),
                TextColumn::make('tipo_documento.nombre')->sortable()->toggleable()->searchable()->label('Tipo Documento'),
                TextColumn::make('documento.numero_doc')->sortable()->toggleable()->searchable()->label('Numero Doc.'),
                TextColumn::make('documento.anyo_doc')->sortable()->toggleable()->searchable()->label('Año Doc.'),
                TextColumn::make('documento.codigo')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true)->label('Codigo'),
                TextColumn::make('documento.dni')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true)->label('Dni'),
                TextColumn::make('documento.razon_social')->sortable()->toggleable(isToggledHiddenByDefault: true)->label('Año Doc.'),
                TextColumn::make('documento.domicilio')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('documento.deuda_desde')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable()->label('Deuda Desde.'),
                TextColumn::make('documento.deuda_hasta')->sortable()->toggleable(isToggledHiddenByDefault: true)->searchable()->label('Deuda Hasta.'),
                TextColumn::make('cantidad_visitas')->sortable()->toggleable()->searchable()->label('N° Visitas'),
                TextColumn::make('numero_acuse')->sortable()->toggleable()->searchable()->label('N° Acuse'),
                TextColumn::make('tipo_notificacion.nombre')->sortable()->toggleable(),
                TextColumn::make('sub_tipo_notificacion.nombre')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fecha_notificacion')->sortable()->toggleable(),
                ToggleColumn::make('documento.prico')->sortable()->toggleable(isToggledHiddenByDefault: true)->label('Prico')->disabled(),
                TextColumn::make('user.name')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true)->label('Notificador'),

            ])
            ->filters([
                SelectFilter::make('tipo_documento')->relationship('tipo_documento', 'nombre'),
                SelectFilter::make('tipo_notificacion')->relationship('tipo_notificacion', 'nombre'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ManageNotificacionDocumentos::route('/'),
        ];
    }
}
