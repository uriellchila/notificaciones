<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use App\Models\User;
use Filament\Tables;
use App\Models\Documento;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Imports\DocumentoImporter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Database\Query\Builder;

class DocumentosAsignarTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Pendientes para asignar a un notificador.';

    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '3s';
    public function table(Table $table): Table
    {
        return $table
        ->striped()
        ->query(Documento::query()->where('user_id','=',null))
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
            //TextColumn::make('user.name')->sortable()->toggleable()->label('notificador'),
        ])->deferLoading()
        
        ->filters([
            SelectFilter::make('user')->relationship('user', 'name'),
        ])
        ->selectable()
   
        ->actions([
            //Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('Asignar')
            
           /* ->action(function (array $data, Documento $record): void {
                $record->user()->associate($data['user_id']);
                $record->save();
            })*/

            ->action(function (array $data,Documento $record) {
                    $record->update([
                        'user_id' => $data['user_id'],
                        'fecha_para' => $data['fecha_para'],
                    ]);   
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
                    //->required(),
                DatePicker::make('fecha_para')->required()->default(date("Y-m-d")),
            ])
            
            ->icon('heroicon-o-user')
            //->visible(false)
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
                    //->required(),
                DatePicker::make('fecha_para')->required()->default(date("Y-m-d")),
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
