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
        
        $notis=NotificacionDocumento::select('name')
        ->join('users', 'users.id', '=', 'notificacion_documentos.user_id')
        ->groupBy('user_id')
        ->select('name', DB::raw('count(*) as notis'))
        ->orderBy('user_id','asc')
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
            'labels' => array_column($notis->toArray(), 'name'),
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