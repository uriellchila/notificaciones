<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use Filament\Tables;
use App\Models\Documento;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class DocumentosNotificadosTable extends BaseWidget
{   protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Documentos Notificados';
    public function table(Table $table): Table
    {
        return $table
        ->query(NotificacionDocumento::query()->where('deleted_at','=',null))
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

        ])->deferLoading()
        ->filters([
            SelectFilter::make('tipo_documento')->relationship('tipo_documento', 'nombre'),
            SelectFilter::make('user')->relationship('user', 'name'),
            SelectFilter::make('tipo_notificacion')->relationship('tipo_notificacion', 'nombre'),
            Filter::make('fecha_notificacion')
            ->form([
                DatePicker::make('fecha_inicio'),
                DatePicker::make('fecha_fin'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['fecha_inicio'],
                        fn (Builder $query, $date): Builder => $query->whereDate('fecha_notificacion', '>=', $date),
                    )
                    ->when(
                        $data['fecha_fin'],
                        fn (Builder $query, $date): Builder => $query->whereDate('fecha_notificacion', '<=', $date),
                    );
            })
        ])
        ->actions([
            /*Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),*/
        ])
        ->bulkActions([
            /*Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),*/
            ExportBulkAction::make()->label('Exportar a Excel')
        ]);
    }
    public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }
}
