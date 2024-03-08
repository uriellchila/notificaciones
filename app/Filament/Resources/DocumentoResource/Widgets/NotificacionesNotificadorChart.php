<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use App\Models\User;
use App\Models\Documento;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;
use Illuminate\Database\Query\Builder;

class NotificacionesNotificadorChart extends ChartWidget
{
    protected static ?string $heading = 'Notificaciones por Notificador';

    protected function getData(): array
    {
        
        $notificaciones=User::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), 
        //DB::raw('(select count(*) from documentos where user_id=users.id and deleted_at is null) as asignados'),
        DB::raw('(select count(*) from notificacion_documentos where user_id=users.id and deleted_at is null) as notificados')
        )
        ->whereExists(function (Builder $query) {
            $query->select(DB::raw(1))
                  ->from('documentos')
                  ->whereColumn('documentos.user_id', 'users.id');
        })
        
        ->groupBy('users.id', 'name')
        ->orderBy('notificados','desc')
        ->get();    
        
        //$data=[0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89];
        //dd($data);
        return [
            'datasets' => [
                [
                    'label' => 'Notificaciones por Notificador',
                    'data' => array_column($notificaciones->toArray(), 'notificados'),
                    'borderColor' => '#16A085',
                    'backgroundColor' => '#A3E4D7',
                    
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
