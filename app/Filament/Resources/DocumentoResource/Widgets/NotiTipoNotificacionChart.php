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
        
        $notisrecepcion=User::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), 
        DB::raw('(select count(*) from documentos where user_id=id) as notis')
        )
        /*->whereExists(function (Builder $query) {
            $query->select(DB::raw(1))
                  ->from('documentos')
                  ->whereColumn('documentos.user_id', 'users.id');
        })*/
        /*->join('users', 'users.id', '=', 'notificacion_documentos.user_id')
        ->groupBy('user_id', 'name')
        ->orderBy('user_id','asc')
        ->where('notificacion_documentos.deleted_at',null)
        ->where('notificacion_documentos.tipo_notificacion_id',1)*/
        ->get();
        dd($notisrecepcion);

        /*$notiscedulon=NotificacionDocumento::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), DB::raw('count(*) as notis'))
        ->join('users', 'users.id', '=', 'notificacion_documentos.user_id')
        ->groupBy('user_id', 'name')
        ->orderBy('user_id','asc')
        ->where('notificacion_documentos.deleted_at',null)
        ->where('notificacion_documentos.tipo_notificacion_id',2)
        ->get();

        $notisnegatividad=NotificacionDocumento::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), DB::raw('count(*) as notis'))
        ->join('users', 'users.id', '=', 'notificacion_documentos.user_id')
        ->groupBy('user_id', 'name')
        ->orderBy('user_id','asc')
       ->where('notificacion_documentos.deleted_at',null)
        ->where('notificacion_documentos.tipo_notificacion_id',4)
        ->get();*/
        
        /*$asignados=Documento::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), DB::raw('count(*) as notis'))
        ->join('users', 'users.id', '=', 'documentos.user_id')
        ->groupBy('user_id', 'name')
        ->orderBy('user_id','asc')
        ->where('documentos.deleted_at',null)
        ->get();  */
        
        //$data=[0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89];
        //dd($data);
        return [
            'datasets' => [
                
                [
                    'label' => 'C.A. Recepcion',
                    'data' => array_column($notisrecepcion->toArray(), 'notis'),
                    'borderColor' => '#16A085',
                    'backgroundColor' => '#45B39D',

                    
                ],
               /* [
                    'label' => 'Cedulon',
                    'data' => array_column($notiscedulon->toArray(), 'notis'),
                    'borderColor' => '#BA4A00',
                    'backgroundColor' => '#EB984E',

                    
                ],
                [
                    'label' => 'Negatividad',
                    'data' => array_column($notisnegatividad->toArray(), 'notis'),
                    'backgroundColor' => '#5D6D7E',
                    'borderColor' => '#2E4053',
                    
                ],*/
                
            ],
            'labels' => array_column($notisrecepcion->toArray(), 'nombre'),
            
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
