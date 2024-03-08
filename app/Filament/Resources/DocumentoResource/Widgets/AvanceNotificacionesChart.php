<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use App\Models\Documento;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\NotificacionDocumento;

class AvanceNotificacionesChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        
        $notis=NotificacionDocumento::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), DB::raw('count(*) as notis'))
        ->join('users', 'users.id', '=', 'notificacion_documentos.user_id')
        ->groupBy('user_id', 'name')
        ->orderBy('user_id','asc')
        ->where('notificacion_documentos.deleted_at',null)
        ->get();
        
        $asignados=Documento::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), DB::raw('count(*) as notis'))
        ->join('users', 'users.id', '=', 'documentos.user_id')
        ->groupBy('user_id', 'name')
        ->orderBy('user_id','asc')
        ->where('documentos.deleted_at',null)
        ->get();  
        
        //$data=[0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89];
        //dd($data);
        return [
            'datasets' => [
                
                [
                    'label' => 'Asignados',
                    'data' => array_column($asignados->toArray(), 'notis'),
                    'borderColor' => '#2874A6',
                    
                ],
                [
                    'label' => 'Notificados',
                    'data' => array_column($notis->toArray(), 'notis'),
                    //'backgroundColor' => '#FDEDEC',
                    'borderColor' => '#148F77',
                    
                ],
                
            ],
            'labels' => array_column($notis->toArray(), 'nombre'),
            
        ];
        
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
