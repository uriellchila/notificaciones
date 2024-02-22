<?php

namespace App\Filament\Resources\DocumentoNotificadorResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentoNotificador;
use Illuminate\Support\Facades\Auth;

class TipoNotificacionChart extends ChartWidget
{
    protected static ?string $heading = 'Tipo - Notificaciones';

    protected function getData(): array
    {
        $notis=DocumentoNotificador::select('nombre')
        ->join('tipo_notificacions', 'tipo_notificacions.id', '=', 'documento_notificadors.tipo_notificacion_id')
        ->groupBy('nombre')
        ->select('nombre', DB::raw('count(*) as notis'))
        ->orderBy('nombre','asc')
        ->get();
        
        
        //$data=[0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89];
        //dd($data);
        return [
            'datasets' => [
                [
                    'label' => 'Tipo de Notificacion',
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

}
