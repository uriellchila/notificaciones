<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use App\Models\User;
use Filament\Tables;
use App\Models\Documento;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ImportAction;

use App\Filament\Imports\DocumentoImporter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Widgets\TableWidget as BaseWidget;

class DocumentosAsignarTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Pendientes para asignar a un notificador.';

    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
        ->striped()
        ->query(Documento::query())
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
            Tables\Actions\Action::make('Asignar')
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
            ->icon('heroicon-o-user')
        ])
        ->headerActions([
            // ...
            //Tables\Actions\AttachAction::make(),
            Tables\Actions\ImportAction::make()
            ->importer(DocumentoImporter::class)
            ->options([
                'updateExisting' => true,
            ])
        ])
        ->bulkActions([
            //Tables\Actions\BulkActionGroup::make([
                //Tables\Actions\DeleteBulkAction::make(),

           // ]),
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
                Select::make('user_id')
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
    public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }

}
