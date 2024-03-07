<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;

class NotificacionesNotificadorChart extends ChartWidget
{
    protected static ?string $heading = 'Notificaciones por Notificador';

    protected function getData(): array
    {
        
        $notis=NotificacionDocumento::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), DB::raw('count(*) as notis'))
        ->join('users', 'users.id', '=', 'notificacion_documentos.user_id')
        ->groupBy('user_id', 'name')
        ->orderBy('notis','desc')
        ->where('notificacion_documentos.deleted_at',null)
        ->get();
        
        
        //$data=[0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89];
        //dd($data);
        return [
            'datasets' => [
                [
                    'label' => 'Notificaciones por Notificador',
                    'data' => array_column($notis->toArray(), 'notis'),
                ],
            ],
            'labels' => array_column($notis->toArray(), 'nombre'),
        ];
        
    }


    protected function getType(): string
    {
        return 'bar';
    }
    /*public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }*/

}
