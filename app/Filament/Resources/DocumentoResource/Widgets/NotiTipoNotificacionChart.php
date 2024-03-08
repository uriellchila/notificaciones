<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use App\Models\User;
use App\Models\Documento;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;
use Illuminate\Contracts\Database\Query\Builder;

class NotiTipoNotificacionChart extends ChartWidget
{
    protected static ?string $heading = 'Notficaciones - Por tipo de notificacion';

    protected function getData(): array
    {
        
        $notificaciones=User::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), 
        DB::raw('(select count(*) from notificacion_documentos where user_id=users.id and tipo_notificacion_id = 1 and deleted_at is null) as recepcionados'),
        DB::raw('(select count(*) from notificacion_documentos where user_id=users.id and tipo_notificacion_id = 2 and deleted_at is null) as cedulon'),
        DB::raw('(select count(*) from notificacion_documentos where user_id=users.id and tipo_notificacion_id = 3 and deleted_at is null) as correo'),
        DB::raw('(select count(*) from notificacion_documentos where user_id=users.id and tipo_notificacion_id = 4 and deleted_at is null) as negativa')
        )
        ->whereExists(function (Builder $query) {
            $query->select(DB::raw(1))
                  ->from('documentos')
                  ->whereColumn('documentos.user_id', 'users.id');
        })
        
        ->groupBy('users.id', 'name')
        ->orderBy('recepcionados','desc')
        ->get();
        
        //$data=[0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89];
        //dd($data);
        return [
            'datasets' => [
                
                [
                    'label' => 'C.A. Recepcion',
                    'data' => array_column($notificaciones->toArray(), 'recepcionados'),
                    'borderColor' => '#16A085',
                    'backgroundColor' => '#A3E4D7',

                    
                ],
               [
                    'label' => 'Cedulon',
                    'data' => array_column($notificaciones->toArray(), 'cedulon'),
                    'borderColor' => '#BA4A00',
                    'backgroundColor' => '#EDBB99',

                    
                ],
                [
                    'label' => 'Negatividad',
                    'data' => array_column($notificaciones->toArray(), 'negativa'),
                    'backgroundColor' => '#85929E',
                    'borderColor' => '#2E4053',
                    
                ],
                
            ],
            'labels' => array_column($notificaciones->toArray(), 'nombre'),
            
        ];
        
    }

    protected function getType(): string
    {
        return 'bar';
    }
    public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }
}
