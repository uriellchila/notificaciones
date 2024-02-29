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
use App\Models\TipoNotificacion;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use App\Models\SubTipoNotificacion;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
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
            ->columns(4)
            ->schema([
                Select::make('tipo_documento_id')->relationship('tipo_documento', 'nombre')->required(), 
                TextInput::make('numero_doc')->numeric()->required()->suffix(date('Y')),
                Hidden::make('anyo_doc')->required()->default(date('Y'))->disabled()->dehydrated(),
                TextInput::make('deuda_desde')->numeric()->required()->default('2024'),
                TextInput::make('deuda_hasta')->numeric()->required()->default('2024'),  
                 
            ]),
            Grid::make()
            ->columns(4)
            ->schema([
                TextInput::make('deuda_ip')->numeric()->required(), 
                TextInput::make('codigo')->required()
                ->live()
                ->afterStateUpdated(
                    function (Set $set, Get $get) {
                        $set('razon_social', '');
                        $set('domicilio', '');
                        $set('dni', '');
                        $idc =  Contribuyente::select('dni_ruc','razon_social', 'domicilio')
                        ->where('contribuyentes.codigo', $get('codigo'))
                        ->first();
                        if($idc!=null){
                           $set('dni', $idc->dni_ruc);
                           $set('razon_social', $idc->razon_social);
                           $set('domicilio', $idc->domicilio);
                        }
                        else{
                            $set('razon_social', 'asas');
                            $set('domicilio', 'asas');
                            $set('dni', ''); 
                        }
                        
                        
                    }),
                TextInput::make('dni')->required(),
                TextInput::make('razon_social')->required(),
                
                
            ]),
            Grid::make()
            ->columns(3)
            ->schema([
                TextInput::make('domicilio')->required(),
                Select::make('user_id')->relationship('user', 'name')->label('Asignar'),
                Toggle::make('prico'),
             ]),
            
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->striped()
        ->heading('Asignados para notificar.')
        ->query(Documento::query()->where('user_id',Auth::user()->id))
        ->columns([
            TextColumn::make('tipo_documento.nombre')->sortable()->toggleable()->searchable(),
            TextColumn::make('numero_doc')->sortable()->toggleable()->searchable(),
            TextColumn::make('anyo_doc')->sortable()->toggleable()->searchable(),
            TextColumn::make('deuda_desde')->sortable()->toggleable()->searchable(),
            TextColumn::make('deuda_hasta')->sortable()->toggleable()->searchable(),
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
            Tables\Actions\Action::make('Notificacion')
            ->form([
                    Grid::make()
                    ->columns(1)
                    ->schema([
                        TextInput::make('documento_id')->label('')
                            ->default(function (Documento $record) {
                                return "Numero Documento: ".$record->numero_doc." - ".$record->anyo_doc."  Razon social: ".$record->razon_social;})->disabled()                             
    
                    ]),
                    Grid::make()
                    ->columns(3)
                    ->schema([
                        TextInput::make('cantidad_visitas')->required()->numeric()->default(1),
                        TextInput::make('numero_acuse')->required()->numeric(),
                        Select::make('tipo_notificacion_id')
                            ->options(function (Get $get) {
                                return TipoNotificacion::query()
                                ->pluck('nombre', 'id');
                            })
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
            ])
            ->action(function (array $data, Documento $record): void {
                dd($record);
                $doc = new Flight;
 
                $doc->name = $request->name;
         
                $doc->save();
            })
        ])
        ->headerActions([
            // ...
            //Tables\Actions\AttachAction::make(),
        ])
        ->bulkActions([
            /*Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),

            ]),*/
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDocumentos::route('/'),
        ];
    }
}
