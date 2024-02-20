<?php

namespace App\Filament\Resources\DocumentoNotificadorResource\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentoNotificador;

class NotificadoresChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        
        $notis=DocumentoNotificador::select('name')
        ->join('users', 'users.id', '=', 'documento_notificadors.user_id')
        ->groupBy('user_id')
        ->select('name', DB::raw('count(*) as notis'))
        ->get();
        
        
        $data=[0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89];
        //dd($data);
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
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
}
