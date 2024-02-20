<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;
use App\Models\DocumentoNotificador;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\DocumentoNotificadorResource\Pages;
use App\Filament\Resources\DocumentoNotificadorResource\RelationManagers;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\Notificaciones;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\NotificacionesNoti;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\NotificadoresChart;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\NotificacionesTabla;

class DocumentoNotificadorResource extends Resource
{
    protected static ?string $model = DocumentoNotificador::class;
    //protected static ?string $title = 'Custom Page Title';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    //protected static ?string $navigationGroup = 'Mantenimiento';
    protected static ?string $navigationLabel = 'Notificacion';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Notificaciones';
    
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
                    Select::make('tipo_documento_id')
                        ->relationship('tipo_documento', 'nombre')
                        ->live()->preload()->selectablePlaceholder(true)->required()->dehydrated(),
                    TextInput::make('numero_doc')->required(),
                    TextInput::make('numero_acuse')->required(),
                    Select::make('tipo_notificacion_id')
                        ->relationship('tipo_notificacion', 'nombre')
                        ->required()->live()->preload(),
                    DatePicker::make('fecha_notificacion'),
                    TextInput::make('observaciones'),
                    Hidden::make('user_id')->default(Auth::user()->id),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {   

            return $table
            //->heading('Notificaciones')
            //->description('Notificaciones')
            ->striped()
            ->query(DocumentoNotificador::query()->where('user_id',Auth::user()->id))
            ->columns([
                //TextColumn::make('contribuyente.codigo')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('codigo')->sortable()->toggleable()->searchable(),
                TextColumn::make('dni')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('razon_social')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('domicilio')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tipo_documento.nombre')->sortable()->toggleable(),
                TextColumn::make('numero_doc')->sortable()->toggleable()->searchable(),
                TextColumn::make('numero_acuse')->sortable()->toggleable()->searchable(),
                TextColumn::make('tipo_notificacion.nombre')->sortable()->toggleable(),
                TextColumn::make('fecha_notificacion')->sortable()->toggleable(),
                TextColumn::make('user.name')->sortable()->toggleable()->toggleable(isToggledHiddenByDefault: true)->label('Notificador'),

            ])
            ->filters([
                //SelectFilter::make('contribuyente.codigo')->relationship('contribuyente', 'codigo'),
                /*SelectFilter::make('user_id')
                ->options(fn (): array => User::query()->where('id',Auth::user()->id)->pluck('name', 'id')->all())
                ->default(Auth::user()->id),*/
                SelectFilter::make('tipo_documento')->relationship('tipo_documento', 'nombre'),
                SelectFilter::make('tipo_notificacion')->relationship('tipo_notificacion', 'nombre'),
                /*SelectFilter::make('user_id')
                //->multiple()
                ->options([
                    Auth::user()->id => Auth::user()->name,
                ])
                ->default(Auth::user()->name)*/
            ])//->deselectAllRecordsWhenFiltered(true)
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
    public static function getWidgets(): array
    {
        return [
            Notificaciones::class,
            NotificacionesNoti::class,
            NotificacionesTabla::class,
            //NotificadoresChart::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDocumentoNotificadors::route('/'),
        ];
    }
}
