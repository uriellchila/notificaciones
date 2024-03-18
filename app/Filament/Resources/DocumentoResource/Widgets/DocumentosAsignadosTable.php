<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use App\Models\User;
use Filament\Tables;
use App\Models\Documento;
use Filament\Tables\Table;
use Tables\Actions\Action;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Database\Query\Builder;

class DocumentosAsignadosTable extends BaseWidget
{   protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Asignados para su notificacion.';

    protected static ?int $sort = 3;
    protected static ?string $pollingInterval = '3s';
    public function table(Table $table): Table
    {   
        return $table
        ->striped()
        ->query(Documento::query()->where('user_id','!=',null))
        ->columns([
            TextColumn::make('tipo_documento.nombre')->sortable()->toggleable(),
            TextColumn::make('numero_doc')->sortable()->toggleable()->searchable(),
            TextColumn::make('anyo_doc')->sortable()->toggleable(),
            TextColumn::make('deuda_desde')->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('deuda_hasta')->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('deuda_ip')->sortable()->toggleable(),
            TextColumn::make('codigo')->sortable()->toggleable(),
            TextColumn::make('razon_social')->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('domicilio')->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('user.name')->sortable()->toggleable()->label('notificador'),
        ])->deferLoading()
        ->filters([
            SelectFilter::make('user')->relationship('user', 'name'),
            Filter::make('fecha_para_notificar')
                ->label('Fecha de Asignacion')
                ->form([
                    DatePicker::make('fecha_inicio'),
                    DatePicker::make('fecha_fin'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['fecha_inicio'],
                            fn (Builder $query, $date): Builder => $query->whereDate('fecha_para', '>=', $date),
                        )
                        ->when(
                            $data['fecha_fin'],
                            fn (Builder $query, $date): Builder => $query->whereDate('fecha_para', '<=', $date),
                        );
                })
        ])
        ->selectable()
   
        ->actions([
            //Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('Cambiar Notificador')
            ->form([
                Select::make('user_id')
                    ->label('Asignar Notificador')
                    ->options(
                        User::query()
                            ->join('model_has_roles','model_has_roles.model_id','=','users.id')
                            ->join('roles','roles.id','=','model_has_roles.role_id')
                            ->groupBy('users.name', 'users.id')
                            ->where('roles.name','Notificador')
                            ->pluck('users.name', 'users.id')
                    ),
                    //->required(),
            ])
            ->action(function (array $data, Documento $record): void {
                $record->user()->associate($data['user_id']);
                $record->save();
                $this->resetTable();
            })
            ->icon('heroicon-o-user')

        ])
        ->headerActions([
        ])
        ->bulkActions([
            Tables\Actions\BulkAction::make('Modificar Notificador')
            ->action(function (array $data,Documento $record, Collection $records) {
                $records->each(
                    fn (Documento $record) => $record->update([
                        'user_id' => $data['user_id'],
                        'fecha_para' => $data['fecha_para'],
                    ]),
                );
            })
            ->form([
                Select::make('user_id')
                    ->label('Notificador')
                    ->options(
                        User::query()
                            ->join('model_has_roles','model_has_roles.model_id','=','users.id')
                            ->join('roles','roles.id','=','model_has_roles.role_id')
                            ->groupBy('users.name', 'users.id')
                            ->where('roles.name','Notificador')
                            ->pluck('users.name', 'users.id')

                    ),
                DatePicker::make('fecha_para')->required()->default(date("Y-m-d")),
            ])
                
        ]);

    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDocumentos::route('/'),
        ];
    }
    public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }
}
