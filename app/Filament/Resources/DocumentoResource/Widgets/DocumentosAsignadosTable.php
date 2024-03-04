<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use App\Models\User;
use Filament\Tables;
use App\Models\Documento;
use Filament\Tables\Table;
use Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget as BaseWidget;

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
        ])->deferLoading()
        ->filters([
            SelectFilter::make('user')->relationship('user', 'name'),
        ])
        ->selectable()
   
        ->actions([
            //Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('Cambiar Notificador')
            ->form([
                Select::make('user_id')
                    ->label('Asignar Notificador')
                    ->options(User::query()->pluck('name', 'id')),
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
            /*Tables\Actions\BulkAction::make('Asignar Notificador')
            ->action(function (array $data,Documento $record, Collection $records) {
                $records->each(
                    fn (Documento $record) => $record->update([
                        'user_id' => $data['user_id'],
                    ]),
                );
            })
            ->form([
                Select::make('user_id')
                    ->label('Notificador')
                    ->options(User::query()->pluck('name', 'id')),
                    
            ])*/
                
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
