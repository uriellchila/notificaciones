<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;
use Illuminate\Database\Query\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class RankinNotificadoresOverview extends BaseWidget
{
    protected function getStats(): array
    {
        //$notificaciones=NotificacionDocumento::where('user_id',Auth::user()->id)->where('deleted_at',null)->count();
        
        $totalnotificadores = DB::table('users')
           ->whereExists(function (Builder $query) {
               $query->select(DB::raw(1))
                     ->from('documentos')
                     ->whereColumn('documentos.user_id', 'users.id');
           })
           ->count();
        $notis=NotificacionDocumento::select(DB::raw("SPLIT_PART(name, ' ', 1) as nombre"), DB::raw('count(*) as notis'))
           ->join('users', 'users.id', '=', 'notificacion_documentos.user_id')
           ->orderBy('notis','desc')
           ->groupBy('user_id', 'name')
           
           ->get();
           //dd($notis);
        $cantidad=1;
        $puesto1='';
        $puesto2='';
        $puesto3='';
        $puesto4='';

        $not1=0;
        $not2=0;
        $not3=0;
        $not4=0;

        foreach($notis as $data ){
            //$temp=NotificacionDocumento::where('user_id',$data->id)->where('deleted_at',null)->count();
            if($cantidad<=4){
            if($cantidad==1){
                $puesto1=$data->nombre;
                $not1=$data->notis;
                $cantidad=$cantidad+1;
            }
            else if($cantidad==2){
                $puesto2=$data->nombre;
                $not2=$data->notis;
                $cantidad=$cantidad+1;
            }
            else if($cantidad==3){
                $puesto3=$data->nombre;
                $not3=$data->notis;
                $cantidad=$cantidad+1;
            }
            else if($cantidad==4){
                $puesto4=$data->nombre;
                $not4=$data->notis;
                $cantidad=$cantidad+1;
                
            }
            }
        }
        return [
             Stat::make('Primero', $puesto1)
            ->description('con '.$not1. ' notificaciones..')
            ->descriptionIcon('heroicon-m-trophy')
            ->chart([0,1,2,3,$not1])
            ->color('success'),

            Stat::make('Segundo', $puesto2)
            ->description('con '.$not2. ' notificaciones..')
            ->descriptionIcon('heroicon-m-face-smile')
            ->chart([0,1,2,3,$not2])
            ->color('info'),

            
            Stat::make('Tercero', $puesto3)
            ->description('con '.$not3. ' notificaciones..')
            ->descriptionIcon('heroicon-m-face-smile')
            ->chart([0,1,2,3,$not3])
            ->color('warning'),

            
            Stat::make('Cuarto', $puesto4)
            ->description('con '.$not4. ' notificaciones..')
            ->descriptionIcon('heroicon-m-face-smile')
            ->chart([0,1,2,3,$not4])
            ->color('warning'),
            
            
        ];
    }
    /*public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }*/
}
